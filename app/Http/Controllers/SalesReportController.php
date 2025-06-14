<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Branch;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SalesReportController extends Controller
{

    public function sales(Request $request)
    {
        // Get filters from request
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $branchId = $request->input('branch_id');
        $customerGroup = $request->input('customer_group');

        // Base query
        $salesQuery = Sale::with(['customer', 'branch', 'user', 'items.product', 'payments.paymentMethod'])
            ->whereBetween('sale_date', [$startDate, $endDate])
            ->where('status', 'completed');

        // Apply filters
        if ($branchId) {
            $salesQuery->where('branch_id', $branchId);
        }

        if ($customerGroup) {
            $salesQuery->whereHas('customer', function ($q) use ($customerGroup) {
                $q->where('customer_group', $customerGroup);
            });
        }

        // Get data
        $sales = $salesQuery->orderBy('sale_date', 'desc')->get();
        $totalSales = $sales->sum('total_amount');
        $totalItemsSold = $sales->sum(function ($sale) {
            return $sale->items->sum('quantity');
        });

        // Sales by payment method
        $salesByPaymentMethod = $sales->flatMap->payments
            ->groupBy(fn($payment) => $payment->paymentMethod->name)
            ->map(fn($group) => [
                'method' => $group->first()->paymentMethod->name,
                'total' => $group->sum('amount'),
                'count' => $group->count()
            ])
            ->values();

        // Sales by product category
        $salesByCategory = $sales->flatMap->items
            ->groupBy(fn($item) => $item->product->category->name ?? 'Uncategorized')
            ->map(fn($group) => [
                'category' => $group->first()->product->category->name ?? 'Uncategorized',
                'total' => $group->sum(function ($item) {
                    return $item->quantity * $item->unit_price;
                }),
                'quantity' => $group->sum('quantity')
            ])
            ->sortByDesc('total')
            ->values();

        // Daily sales trend
        $dailySalesTrend = $this->getDailySalesTrend($startDate, $endDate, $branchId);


        $salesByPaymentMethod = $salesByPaymentMethod->toArray();

        return view('admin.reports.sales', [
            'sales' => $sales,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
            'customerGroup' => $customerGroup,
            'branches' => Branch::all(),
            'customerGroups' => ['retail', 'wholesale', 'vip'],
            'totalSales' => $totalSales,
            'totalItemsSold' => $totalItemsSold,
            'salesByPaymentMethod' => $salesByPaymentMethod,
            'salesByCategory' => $salesByCategory,
            'dailySalesTrend' => $dailySalesTrend,
        ]);
    }

    protected function getDailySalesTrend($startDate, $endDate, $branchId = null)
    {
        $current = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        $data = [];

        while ($current <= $end) {
            $date = $current->format('Y-m-d');
            $query = Sale::whereDate('sale_date', $date)
                ->where('status', 'completed');

            if ($branchId) {
                $query->where('branch_id', $branchId);
            }

            $totalSales = $query->sum('total_amount');
            $totalTransactions = $query->count();

            $data[] = [
                'date' => $current->format('M j'),
                'total_sales' => $totalSales,
                'transaction_count' => $totalTransactions
            ];

            $current->addDay();
        }

        return $data;
    }
}
