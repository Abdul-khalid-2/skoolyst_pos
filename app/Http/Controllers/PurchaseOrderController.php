<?php
// app/Http/Controllers/PurchaseController.php
// namespace App\Http\Controllers;

// use App\Models\InventoryLog;
// use App\Models\Purchase;
// use App\Models\PurchaseItem;
// use App\Models\Product;
// use App\Models\ProductVariant;
// use App\Models\Supplier;
// use Illuminate\Http\Request;

// class PurchaseOrderController extends Controller
// {
//     public function index()
//     {
//         $purchases = Purchase::with(['supplier', 'items'])->latest()->get();
//         return view('admin.purchases.index', compact('purchases'));
//     }

//     public function create()
//     {
//         $suppliers = Supplier::all();
//         $products = Product::with('variants')->get();
//         return view('admin.purchases.create', compact('suppliers', 'products'));
//     }

//     public function store(Request $request)
//     {
//         $request->validate([
//             'supplier_id' => 'required|exists:suppliers,id',
//             'invoice_number' => 'required|string|max:255',
//             'purchase_date' => 'required|date',
//             'items' => 'required|array|min:1',
//             'items.*.product_id' => 'required|exists:products,id',
//             'items.*.variant_id' => 'nullable|exists:product_variants,id',
//             'items.*.quantity' => 'required|numeric|min:1',
//             'items.*.unit_price' => 'required|numeric|min:0',
//         ]);

//         // Create purchase
//         $purchase = Purchase::create([
//             'tenant_id' => auth()->user()->tenant_id,
//             'supplier_id' => $request->supplier_id,
//             'invoice_number' => $request->invoice_number,
//             'purchase_date' => $request->purchase_date,
//             'status' => 'received',
//             'subtotal' => 0, // Will be calculated
//             'total_amount' => 0, // Will be calculated
//         ]);

//         // Add items and calculate totals
//         $subtotal = 0;
//         foreach ($request->items as $item) {
//             $purchaseItem = PurchaseItem::create([
//                 'purchase_id' => $purchase->id,
//                 'product_id' => $item['product_id'],
//                 'variant_id' => $item['variant_id'],
//                 'quantity' => $item['quantity'],
//                 'quantity_received' => $item['quantity'], // Assuming full receipt
//                 'unit_price' => $item['unit_price'],
//                 'total_price' => $item['quantity'] * $item['unit_price'],
//             ]);

//             $subtotal += $purchaseItem->total_price;

//             // Update inventory
//             $this->updateInventory($item['product_id'], $item['variant_id'], $item['quantity']);
//         }

//         // Update purchase totals
//         $purchase->update([
//             'subtotal' => $subtotal,
//             'total_amount' => $subtotal, // Add tax/shipping if needed
//         ]);

//         return redirect()->route('purchases.index')->with('success', 'Purchase created successfully.');
//     }

//     protected function updateInventory($productId, $variantId, $quantity)
//     {
//         if ($variantId) {
//             $variant = ProductVariant::find($variantId);
//             $variant->increment('current_stock', $quantity);
//         } else {
//             $product = Product::find($productId);
//             // Update default variant or handle as needed
//         }
        
//         // Create inventory log
//         InventoryLog::create([
//             'tenant_id' => auth()->user()->tenant_id,
//             'product_id' => $productId,
//             'variant_id' => $variantId,
//             'branch_id' => 1, // Default branch or select from UI
//             'quantity_change' => $quantity,
//             'reference_type' => 'purchase',
//             'reference_id' => $purchase->id,
//         ]);
//     }
// }


namespace App\Http\Controllers;

use App\Models\InventoryLog;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Supplier;
use App\Models\Branch;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with(['supplier', 'items', 'branch'])->latest()->get();
        return view('admin.purchases.index', compact('purchases'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $products = Product::with('variants')->get();
        $branches = Branch::all();
        
        // Generate invoice number
        $lastPurchase = Purchase::latest()->first();
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
            'expected_delivery_date' => 'nullable|date',
            'shipping_amount' => 'nullable|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
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

        $totalAmount = $subtotal + $request->shipping_amount + $request->tax_amount;

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
            'total_amount' => $totalAmount,
            'notes' => $request->notes,
        ]);

        // Add items
        foreach ($request->items as $item) {
            PurchaseItem::create([
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

   
    // ... other methods ...
}