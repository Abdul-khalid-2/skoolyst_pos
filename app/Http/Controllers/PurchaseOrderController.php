<?php

namespace App\Http\Controllers;

use App\Models\InventoryLog;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Supplier;
use App\Models\Branch;
use App\Models\PurchasePayment;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with(['supplier', 'items', 'branch', 'payments'])
            ->where('tenant_id', auth()->user()->tenant_id)
            ->latest()
            ->get();
            
        return view('admin.purchases.index', compact('purchases'));
    }

    public function create()
    {
        $tenantId = auth()->user()->tenant_id;
        
        $suppliers = Supplier::where('tenant_id', $tenantId)->get();
        $products = Product::with('variants')->where('tenant_id', $tenantId)->get();
        $branches = Branch::where('tenant_id', $tenantId)->get();
        
        // Generate invoice number
        $lastPurchase = Purchase::where('tenant_id', $tenantId)->latest()->first();
        $invoiceNumber = 'PO-' . str_pad($lastPurchase ? $lastPurchase->id + 1 : 1, 6, '0', STR_PAD_LEFT);
        
        return view('admin.purchases.create', compact('suppliers', 'products', 'branches', 'invoiceNumber'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'branch_id' => 'required|exists:branches,id',
            'invoice_number' => 'required|string|max:255|unique:purchases',
            'purchase_date' => 'required|date',
            'expected_delivery_date' => 'nullable|date|after_or_equal:purchase_date',
            'shipping_amount' => 'nullable|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.variant_id' => 'nullable|exists:product_variants,id',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        // Calculate totals
        $subtotal = collect($request->items)->sum(function($item) {
            return $item['quantity'] * $item['unit_price'];
        });

        $totalAmount = $subtotal 
            + ($request->shipping_amount ?? 0) 
            + ($request->tax_amount ?? 0)
            - ($request->discount_amount ?? 0);

        // Create purchase
        $purchase = Purchase::create([
            'tenant_id' => auth()->user()->tenant_id,
            'branch_id' => $request->branch_id,
            'supplier_id' => $request->supplier_id,
            'invoice_number' => $request->invoice_number,
            'purchase_date' => $request->purchase_date,
            'expected_delivery_date' => $request->expected_delivery_date,
            'status' => 'ordered', // Default status
            'subtotal' => $subtotal,
            'shipping_amount' => $request->shipping_amount ?? 0,
            'tax_amount' => $request->tax_amount ?? 0,
            'discount_amount' => $request->discount_amount ?? 0,
            'total_amount' => $totalAmount,
            'notes' => $request->notes,
        ]);

        // Add items
        foreach ($request->items as $item) {
            PurchaseItem::create([
                'tenant_id' => auth()->user()->tenant_id,
                'purchase_id' => $purchase->id,
                'product_id' => $item['product_id'],
                'variant_id' => $item['variant_id'],
                'quantity' => $item['quantity'],
                'quantity_received' => 0, // Will be updated when received
                'unit_price' => $item['unit_price'],
                'total_price' => $item['quantity'] * $item['unit_price'],
            ]);
        }

        return redirect()->route('purchases.index')->with('success', 'Purchase order created successfully.');
    }

    public function show(Purchase $purchase)
    {
        // $this->authorize('view', $purchase);
        
        $purchase->load([
            'supplier', 
            'branch', 
            'items.product', 
            'items.variant', 
            'payments.paymentMethod'
        ]);
        
        $paymentMethods = PaymentMethod::where('tenant_id', auth()->user()->tenant_id)->get();
        
        return view('admin.purchases.show', compact('purchase', 'paymentMethods'));
    }

    public function edit(Purchase $purchase)
    {
        // $this->authorize('update', $purchase);
        
        $tenantId = auth()->user()->tenant_id;
        $suppliers = Supplier::where('tenant_id', $tenantId)->get();
        $products = Product::with('variants')->where('tenant_id', $tenantId)->get();
        $branches = Branch::where('tenant_id', $tenantId)->get();
        $purchase->load('items');
        
        return view('admin.purchases.edit', compact('purchase', 'suppliers', 'products', 'branches'));
    }

    public function update(Request $request, Purchase $purchase)
    {
        // $this->authorize('update', $purchase);
        
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'branch_id' => 'required|exists:branches,id',
            'invoice_number' => 'required|string|max:255|unique:purchases,invoice_number,'.$purchase->id,
            'purchase_date' => 'required|date',
            'expected_delivery_date' => 'nullable|date|after_or_equal:purchase_date',
            'shipping_amount' => 'nullable|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'status' => 'required|in:ordered,partial,received,cancelled',
        ]);

        // Update purchase
        $purchase->update([
            'branch_id' => $request->branch_id,
            'supplier_id' => $request->supplier_id,
            'invoice_number' => $request->invoice_number,
            'purchase_date' => $request->purchase_date,
            'expected_delivery_date' => $request->expected_delivery_date,
            'status' => $request->status,
            'shipping_amount' => $request->shipping_amount ?? 0,
            'tax_amount' => $request->tax_amount ?? 0,
            'discount_amount' => $request->discount_amount ?? 0,
            'notes' => $request->notes,
        ]);

        return redirect()->route('purchases.show', $purchase->id)
            ->with('success', 'Purchase updated successfully.');
    }

    public function receiveItems(Request $request, Purchase $purchase)
    {
        // $this->authorize('update', $purchase);
        
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:purchase_items,id,purchase_id,'.$purchase->id,
            'items.*.quantity_received' => 'required|numeric|min:0',
        ]);

        $allReceived = true;
        $totalReceived = 0;
        
        foreach ($request->items as $itemData) {
            $item = PurchaseItem::find($itemData['id']);
            
            // Only update if quantity received is changing
            if ($item->quantity_received != $itemData['quantity_received']) {
                $item->update([
                    'quantity_received' => $itemData['quantity_received']
                ]);
                
                // Update inventory if item is fully or partially received
                if ($itemData['quantity_received'] > 0) {
                    $this->updateInventory(
                        $item->product_id, 
                        $item->variant_id, 
                        $purchase->branch_id,
                        $itemData['quantity_received'],
                        $purchase->id
                    );
                }
            }
            
            // Check if all items are fully received
            if ($item->quantity_received < $item->quantity) {
                $allReceived = false;
            }
            
            $totalReceived += $item->quantity_received;
        }
        
        // Update purchase status
        $newStatus = $allReceived ? 'received' : ($totalReceived > 0 ? 'partial' : 'ordered');
        $purchase->update(['status' => $newStatus]);

        return redirect()->back()->with('success', 'Items received successfully.');
    }

    public function addPayment(Request $request, Purchase $purchase)
    {
        // $this->authorize('update', $purchase);
        
        $request->validate([
            'payment_method_id' => 'required|exists:payment_methods,id',
            'amount' => 'required|numeric|min:0.01|max:'.$purchase->remaining_balance,
            'reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'date' => 'required|date',
        ]);

        PurchasePayment::create([
            'tenant_id' => auth()->user()->tenant_id,
            'purchase_id' => $purchase->id,
            'payment_method_id' => $request->payment_method_id,
            'amount' => $request->amount,
            'reference' => $request->reference,
            'notes' => $request->notes,
            'user_id' => auth()->id(),
            'created_at' => $request->date,
        ]);

        // Update purchase status if fully paid
        if ($purchase->refresh()->remaining_balance <= 0) {
            $purchase->update(['payment_status' => 'paid']);
        }

        return redirect()->back()->with('success', 'Payment added successfully.');
    }

    protected function updateInventory($productId, $variantId, $branchId, $quantity, $purchaseId)
    {
        if ($variantId) {
            $variant = ProductVariant::find($variantId);
            $variant->increment('current_stock', $quantity);
        }
        
        // Create inventory log
        InventoryLog::create([
            'tenant_id' => auth()->user()->tenant_id,
            'product_id' => $productId,
            'variant_id' => $variantId,
            'branch_id' => $branchId,
            'quantity_change' => $quantity,
            'new_quantity' => $variantId ? ProductVariant::find($variantId)->current_stock : 0,
            'reference_type' => 'purchase',
            'reference_id' => $purchaseId,
            'user_id' => auth()->id(),
        ]);
    }
}