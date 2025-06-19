<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Purchase;
use App\Models\Expense;
use App\Models\ReturnProduct;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\ReturnItem;
use App\Models\SaleItem;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CustomerReportController extends Controller
{
    public function customer(Request $request)
    {
        // Get filters from request
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $branchId = $request->input('branch_id');
        $customerGroup = $request->input('customer_group');

        // Base query
        $customersQuery = Customer::with(['sales' => function($query) use ($startDate, $endDate, $branchId) {
            $query->whereBetween('sale_date', [$startDate, $endDate])
                ->where('status', 'completed');
            
            if ($branchId) {
                $query->where('branch_id', $branchId);
            }
        }]);

        // Apply filters
        if ($customerGroup) {
            $customersQuery->where('customer_group', $customerGroup);
        }

        // Get data
        $customers = $customersQuery->orderBy('name')->get()->map(function($customer) {
            $totalSales = $customer->sales->sum('total_amount');
            $totalPurchases = $customer->sales->count();
            $avgPurchaseValue = $totalPurchases > 0 ? $totalSales / $totalPurchases : 0;
            
            return [
                'id' => $customer->id,
                'name' => $customer->name,
                'email' => $customer->email,
                'phone' => $customer->phone,
                'customer_group' => $customer->customer_group,
                'total_sales' => $totalSales,
                'total_purchases' => $totalPurchases,
                'avg_purchase_value' => $avgPurchaseValue,
                'last_purchase_date' => $customer->sales->max('sale_date')?->format('Y-m-d'),
                'balance' => $customer->balance
            ];
        });

        $sale = Sale::get();

        // Top customers by sales
        $topCustomers = $customers->sortByDesc('total_sales')->take(5);

        // Customer groups summary
        $customerGroups = $customers->groupBy('customer_group')->map(function($group, $name) {
            return [
                'name' => $name,
                'count' => $group->count(),
                'total_sales' => $group->sum('total_sales'),
                'avg_sales' => $group->avg('total_sales')
            ];
        })->values();

        return view('admin.reports.customer', [
            'customers' => $customers,
            'topCustomers' => $topCustomers,
            'customerGroups' => $customerGroups,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
            'customerGroup' => $customerGroup,
            'branches' => Branch::all(),
            'availableGroups' => ['retail', 'wholesale', 'vip'],
            'sale' => $sale
        ]);
    }
    
}
