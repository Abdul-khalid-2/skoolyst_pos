<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Sale;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::withCount('sales')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.customer.index', compact('customers'));
    }

    public function create()
    {
        return view('admin.customer.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:customers,email',
            'phone' => 'required|string|max:20|unique:customers,phone',
            'address' => 'nullable|string',
            'tax_number' => 'nullable|string|max:50',
            'customer_group' => 'required|string|in:retail,wholesale,vip',
            'credit_limit' => 'nullable|numeric|min:0',
        ]);

        $validated['tenant_id'] = auth()->user()->tenant_id;
        $validated['balance'] = 0;

        Customer::create($validated);

        return redirect()->route('customers.index')
            ->with('success', 'Customer created successfully.');
    }

    public function show(Customer $customer)
    {
        // Get customer's recent sales
        $sales = Sale::with(['items.product', 'items.variant'])
            ->where('customer_id', $customer->id)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Calculate total spent
        $totalSpent = Sale::where('customer_id', $customer->id)
            ->sum('total_amount');

        return view('admin.customer.show', compact('customer', 'sales', 'totalSpent'));
    }

    public function edit(Customer $customer)
    {
        return view('admin.customer.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:customers,email,' . $customer->id,
            'phone' => 'required|string|max:20|unique:customers,phone,' . $customer->id,
            'address' => 'nullable|string',
            'tax_number' => 'nullable|string|max:50',
            'customer_group' => 'required|string|in:retail,wholesale,vip',
            'credit_limit' => 'nullable|numeric|min:0',
            'balance_adjustment' => 'nullable|numeric|min:0',
            'balance_operation' => 'nullable|string|in:add,subtract,set',
        ]);

        // Handle balance adjustment if provided
        if ($request->filled('balance_adjustment') && $request->filled('balance_operation')) {
            $amount = (float) $request->balance_adjustment;
            $operation = $request->balance_operation;

            switch ($operation) {
                case 'add':
                    $customer->balance += $amount;
                    break;
                case 'subtract':
                    $customer->balance -= $amount;
                    break;
                case 'set':
                    $customer->balance = $amount;
                    break;
            }
        }

        // Update all other fields
        $customer->update($validated);

        return redirect()->route('customers.show', $customer->id)
            ->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully.');
    }
}
