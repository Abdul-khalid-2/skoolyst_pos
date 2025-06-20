<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\SalePayment;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Customer;
use App\Models\Branch;
use App\Models\PaymentMethod;
use App\Models\InventoryLog;
use App\Models\Business;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with(['customer', 'branch', 'user', 'items', 'payments'])
            ->where('tenant_id', auth()->user()->tenant_id)
            ->latest()
            ->get();

        return view('admin.sales.index', compact('sales'));
    }

    public function create()
    {
        $tenantId = auth()->user()->tenant_id;

        $customers = Customer::where('tenant_id', $tenantId)->get();
        $products = Product::with('variants')->where('tenant_id', $tenantId)->get();
        $branches = Branch::where('tenant_id', $tenantId)->get();
        $paymentMethods = PaymentMethod::where('tenant_id', $tenantId)->where('is_active', true)->get();

        // Generate invoice number
        $lastSale = Sale::where('tenant_id', $tenantId)->latest()->first();
        $invoiceNumber = 'INV-' . Carbon::now()->format('Ym') . str_pad($lastSale ? $lastSale->id + 1 : 1, 4, '0', STR_PAD_LEFT);

        return view('admin.sales.create', compact(
            'customers',
            'products',
            'branches',
            'paymentMethods',
            'invoiceNumber'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'nullable',
            'branch_id' => 'required|exists:branches,id',
            'invoice_number' => 'required|string|max:255|unique:sales',
            'sale_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.variant_id' => 'nullable|exists:product_variants,id',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.tax_rate' => 'nullable|numeric|min:0|max:100',
            'items.*.discount_rate' => 'nullable|numeric|min:0|max:100',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'amount_paid' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'custom_customer_name' => 'nullable|string|max:255',
            'custom_customer_phone' => 'nullable|string|max:20',
        ]);

        // Handle customer
        $customerId = null; // Default to null for walk-in customers
        $walkInCustomerInfo = null;

        if ($request->customer_id !== 'Walk-in-Customer' && $request->customer_id) {
            // Existing customer selected
            $customerId = $request->customer_id;
        } elseif ($request->filled('custom_customer_name')) {
            // Create new customer for named walk-in
            $walkInCustomerInfo = [
                'name' => $request->custom_customer_name,
                'phone' => $request->custom_customer_phone,
            ];
        }
        // Else remains null for anonymous walk-in customers

        // Calculate totals
        $subtotal = 0;
        $taxAmount = 0;
        $discountAmount = 0;

        foreach ($request->items as $item) {
            $itemTotal = $item['quantity'] * $item['unit_price'];
            $itemDiscount = $itemTotal * ($item['discount_rate'] ?? 0) / 100;
            $itemTax = ($itemTotal - $itemDiscount) * ($item['tax_rate'] ?? 0) / 100;

            $subtotal += $itemTotal;
            $taxAmount += $itemTax;
            $discountAmount += $itemDiscount;
        }

        $totalAmount = $subtotal + $taxAmount - $discountAmount - $request->discount_amount;
        $changeAmount = max(0, $request->amount_paid - $totalAmount);
        $paymentStatus = $request->amount_paid >= $totalAmount ? 'paid' : 'partial';

        // Create sale
        $sale = Sale::create([
            'tenant_id' => auth()->user()->tenant_id,
            'branch_id' => $request->branch_id,
            'customer_id' => $customerId, // Will be null for walk-in customers
            'walk_in_customer_info' => $walkInCustomerInfo,
            'user_id' => auth()->id(),
            'invoice_number' => $request->invoice_number,
            'sale_date' => $request->sale_date,
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'discount_amount' => $discountAmount + $request->discount_amount,
            'total_amount' => $totalAmount,
            'amount_paid' => min($request->amount_paid, $totalAmount),
            'change_amount' => $changeAmount,
            'payment_status' => $paymentStatus,
            'status' => 'completed',
            'notes' => $request->notes,
        ]);

        // Rest of your method remains the same...
        foreach ($request->items as $item) {
            $itemTotal = $item['quantity'] * $item['unit_price'];
            $itemDiscount = $itemTotal * ($item['discount_rate'] ?? 0) / 100;
            $itemTax = ($itemTotal - $itemDiscount) * ($item['tax_rate'] ?? 0) / 100;

            $saleItem = SaleItem::create([
                'tenant_id' => auth()->user()->tenant_id,
                'sale_id' => $sale->id,
                'product_id' => $item['product_id'],
                'variant_id' => $item['variant_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'cost_price' => $item['cost_price'],
                'tax_rate' => $item['tax_rate'] ?? 0,
                'tax_amount' => $itemTax,
                'discount_rate' => $item['discount_rate'] ?? 0,
                'discount_amount' => $itemDiscount + $request->discount_amount,
                'total_price' => $itemTotal - $itemDiscount + $itemTax,
            ]);

            // Update inventory
            $this->updateInventory(
                $item['product_id'],
                $item['variant_id'],
                $request->branch_id,
                -$item['quantity'], // Negative for sales
                $sale->id
            );
        }

        // Record payment if any amount was paid
        if ($request->amount_paid > 0) {
            SalePayment::create([
                'tenant_id' => auth()->user()->tenant_id,
                'sale_id' => $sale->id,
                'payment_method_id' => $request->payment_method_id,
                'amount' => min($request->amount_paid, $totalAmount),
                'reference' => $request->payment_reference,
                'user_id' => auth()->id(),
            ]);
        }

        return redirect()->route('sales.show', $sale->id)
            ->with('success', 'Sale completed successfully.');
    }

    public function show(Sale $sale)
    {
        // $this->authorize('view', $sale);

        $sale->load([
            'customer',
            'branch',
            'user',
            'items.product',
            'items.variant',
            'payments.paymentMethod'
        ]);

        $paymentMethods = PaymentMethod::where('tenant_id', auth()->user()->tenant_id)
            ->where('is_active', true)
            ->get();

        return view('admin.sales.show', compact('sale', 'paymentMethods'));
    }

    public function edit(Sale $sale)
    {
        // $this->authorize('update', $sale);

        if ($sale->status != 'completed') {
            return redirect()->back()->with('error', 'Only completed sales can be edited.');
        }

        $tenantId = auth()->user()->tenant_id;

        $customers = Customer::where('tenant_id', $tenantId)->get();
        $products = Product::with('variants')->where('tenant_id', $tenantId)->get();
        $branches = Branch::where('tenant_id', $tenantId)->get();
        $paymentMethods = PaymentMethod::where('tenant_id', $tenantId)->where('is_active', true)->get();

        $sale->load('items', 'payments');

        return view('admin.sales.edit', compact('sale', 'customers', 'products', 'branches', 'paymentMethods'));
    }

    public function update(Request $request, Sale $sale)
    {
        // $this->authorize('update', $sale);

        if ($sale->status != 'completed') {
            return redirect()->back()->with('error', 'Only completed sales can be edited.');
        }

        $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'branch_id' => 'required|exists:branches,id',
            'invoice_number' => 'required|string|max:255|unique:sales,invoice_number,' . $sale->id,
            'sale_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.variant_id' => 'nullable|exists:product_variants,id',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'amount_paid' => 'required|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        // First, restore inventory for all original items
        foreach ($sale->items as $item) {
            $this->updateInventory(
                $item->product_id,
                $item->variant_id,
                $sale->branch_id,
                $item->quantity, // Positive to add back
                $sale->id,
                'sale_updated'
            );
        }

        // Calculate new totals
        $subtotal = 0;
        $taxAmount = 0;

        foreach ($request->items as $item) {
            $itemTotal = $item['quantity'] * $item['unit_price'];
            $subtotal += $itemTotal;
        }

        $discountAmount = $request->discount_amount ?? 0;
        $totalAmount = $subtotal + $taxAmount - $discountAmount;
        $changeAmount = max(0, $request->amount_paid - $totalAmount);
        $paymentStatus = $request->amount_paid >= $totalAmount ? 'paid' : 'partial';

        // Update sale
        $sale->update([
            'customer_id' => $request->customer_id,
            'branch_id' => $request->branch_id,
            'invoice_number' => $request->invoice_number,
            'sale_date' => $request->sale_date,
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'discount_amount' => $discountAmount,
            'total_amount' => $totalAmount,
            'amount_paid' => min($request->amount_paid, $totalAmount),
            'change_amount' => $changeAmount,
            'payment_status' => $paymentStatus,
            'notes' => $request->notes,
        ]);

        // Delete old items
        $sale->items()->delete();

        // Add new items and update inventory
        foreach ($request->items as $item) {
            $itemTotal = $item['quantity'] * $item['unit_price'];

            $saleItem = SaleItem::create([
                'tenant_id' => auth()->user()->tenant_id,
                'sale_id' => $sale->id,
                'product_id' => $item['product_id'],
                'variant_id' => $item['variant_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'cost_price' => $item['cost_price'],
                'tax_rate' => 0, // Update if you have tax rates
                'tax_amount' => 0,
                'discount_rate' => 0,
                'discount_amount' => 0,
                'total_price' => $itemTotal,
            ]);

            // Update inventory (negative for sales)
            $this->updateInventory(
                $item['product_id'],
                $item['variant_id'],
                $request->branch_id,
                -$item['quantity'],
                $sale->id,
                'sale_updated'
            );
        }

        // Update payment if changed
        if ($sale->payments->count() > 0) {
            $payment = $sale->payments->first();
            $payment->update([
                'payment_method_id' => $request->payment_method_id,
                'amount' => min($request->amount_paid, $totalAmount),
                'reference' => $request->payment_reference,
            ]);
        }

        return redirect()->route('sales.show', $sale->id)
            ->with('success', 'Sale updated successfully.');
    }

    public function destroy(Sale $sale)
    {
        // $this->authorize('delete', $sale);

        if ($sale->status != 'completed') {
            return redirect()->back()->with('error', 'Only completed sales can be deleted.');
        }

        // Restore inventory
        foreach ($sale->items as $item) {
            $this->updateInventory(
                $item->product_id,
                $item->variant_id,
                $sale->branch_id,
                $item->quantity, // Positive to add back
                $sale->id,
                'sale_deleted'
            );
        }

        // Delete related records
        $sale->items()->delete();
        $sale->payments()->delete();
        $sale->delete();

        return redirect()->route('sales.index')
            ->with('success', 'Sale deleted successfully.');
    }

    public function addPayment(Request $request, Sale $sale)
    {
        // $this->authorize('update', $sale);

        $request->validate([
            'payment_method_id' => 'required|exists:payment_methods,id',
            'amount' => 'required|numeric|min:0.01|max:' . $sale->remaining_balance,
            'reference' => 'nullable|string|max:255',
            'date' => 'required|date',
        ]);

        SalePayment::create([
            'tenant_id' => auth()->user()->tenant_id,
            'sale_id' => $sale->id,
            'payment_method_id' => $request->payment_method_id,
            'amount' => $request->amount,
            'reference' => $request->reference,
            'user_id' => auth()->id(),
            'created_at' => $request->date,
        ]);

        // Update payment status
        $paymentStatus = $sale->refresh()->remaining_balance <= 0 ? 'paid' : 'partial';
        $sale->update([
            'amount_paid' => $sale->payments->sum('amount'),
            'payment_status' => $paymentStatus,
        ]);

        return redirect()->back()->with('success', 'Payment added successfully.');
    }

    protected function updateInventory($productId, $variantId, $branchId, $quantity, $referenceId, $referenceType = 'sale')
    {
        if ($variantId) {
            $variant = ProductVariant::find($variantId);
            $variant->increment('current_stock', $quantity);
            $newQuantity = $variant->current_stock;
        } else {
            // Handle products without variants if needed
            $product = Product::find($productId);
            $newQuantity = 0;
        }

        // Create inventory log
        InventoryLog::create([
            'tenant_id' => auth()->user()->tenant_id,
            'product_id' => $productId,
            'variant_id' => $variantId,
            'branch_id' => $branchId,
            'quantity_change' => $quantity,
            'new_quantity' => $newQuantity,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
            'user_id' => auth()->id(),
        ]);
    }



    public function invoice(Sale $sale)
    {
        // $this->authorize('view', $sale);

        $sale->load([
            'customer',
            'user',
            'items.product',
            'items.variant',
            'payments.paymentMethod',
            'branch'
        ]);
        $business = Business::first();

        return view('admin.sales.invoice', compact('sale', 'business'));
    }

    public function invoicePdf(Sale $sale)
    {

        $sale->load([
            'customer',
            'branch',
            'user',
            'items.product',
            'items.variant',
            'payments.paymentMethod'
        ]);
        
        $business = Business::first();
        
        // Use 'Pdf' instead of 'PDF'
        $pdf = Pdf::loadView('admin.sales.invoice-pdf', [
            'sale' => $sale,
            'business' => $business
        ]);
        
        $pdf->setPaper('Latter', 'portrait');
        $filename = 'invoice-' . $sale->invoice_number . '.pdf';
        
        return $pdf->download($filename);
    }


    public function createCreditNote(Sale $sale)
    {
        // $this->authorize('update', $sale);

        if ($sale->payment_status == 'paid') {
            return redirect()->back()->with('error', 'Sale is already fully paid.');
        }

        // Create a credit note (simplified example)
        $creditNote = CreditNote::create([
            'tenant_id' => auth()->user()->tenant_id,
            'sale_id' => $sale->id,
            'amount' => $sale->remaining_balance,
            'status' => 'pending',
            'notes' => 'Created for unpaid balance of sale #' . $sale->invoice_number,
        ]);

        return redirect()->back()->with('success', 'Credit note created for unpaid balance.');
    }
}
