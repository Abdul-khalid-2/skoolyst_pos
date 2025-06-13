<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::withCount('products')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.supplier.index', compact('suppliers'));
    }

    public function create()
    {
        return view('admin.supplier.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|unique:suppliers,email',
            'phone' => 'required|string|max:20|unique:suppliers,phone',
            'alternate_phone' => 'nullable|string|max:20',
            'address' => 'required|string',
            'tax_number' => 'nullable|string|max:50',
        ]);

        $validated['tenant_id'] = auth()->user()->tenant_id;

        Supplier::create($validated);

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier created successfully.');
    }

    public function show(Supplier $supplier)
{
    // Get products supplied by this supplier
    $products = $supplier->products()->with('category')->paginate(10);
    
    // Get purchase history data
    $purchases = $supplier->purchases()
        ->with(['items', 'branch', 'payments']) // Include payments
        ->latest()
        ->take(10)
        ->get();
    
    // Calculate purchase statistics
    $totalPurchases = $supplier->purchases()->sum('total_amount');
    
    // Calculate outstanding balance correctly
    $outstandingBalance = $supplier->purchases()
        ->withSum('payments as total_payments', 'amount')
        ->get()
        ->sum(function ($purchase) {
            return $purchase->total_amount - $purchase->total_payments;
        });
    
    return view('admin.supplier.show', compact(
        'supplier',
        'products',
        'purchases',
        'totalPurchases',
        'outstandingBalance'
    ));
}
    public function edit(Supplier $supplier)
    {
        return view('admin.supplier.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|unique:suppliers,email,' . $supplier->id,
            'phone' => 'required|string|max:20|unique:suppliers,phone,' . $supplier->id,
            'alternate_phone' => 'nullable|string|max:20',
            'address' => 'required|string',
            'tax_number' => 'nullable|string|max:50',
        ]);

        $supplier->update($validated);

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier updated successfully.');
    }

    public function destroy(Supplier $supplier)
    {
        if ($supplier->products()->exists()) {
            return redirect()->route('suppliers.index')
                ->with('error', 'Cannot delete supplier with associated products.');
        }

        $supplier->delete();

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier deleted successfully.');
    }
}
