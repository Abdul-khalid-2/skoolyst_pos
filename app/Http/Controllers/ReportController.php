<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Purchase;
use App\Models\Expense;
use App\Models\ReturnProduct;
use App\Models\Branch;
use App\Models\ReturnItem;
use App\Models\SaleItem;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function profitLoss(Request $request)
    {
        // Get date range from request or default to current month
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        // Get branch filter if applicable
        $branchId = $request->input('branch_id');

        // Calculate revenue (sales minus returns)
        $salesQuery = Sale::with('return')
            ->whereBetween('sale_date', [$startDate, $endDate])
            ->where('status', 'completed');

        $returnsQuery = ReturnProduct::with('sale')
            ->whereBetween('return_date', [$startDate, $endDate])
            ->where('status', '!=', 'cancelled');

        if ($branchId) {
            $salesQuery->where('branch_id', $branchId);
            $returnsQuery->whereHas('sale', function ($q) use ($branchId) {
                $q->where('branch_id', $branchId);
            });
        }

        $totalSales = $salesQuery->sum('total_amount');
        $totalReturns = $returnsQuery->sum('total_amount');
        $revenue = $totalSales - $totalReturns;

        // Calculate cost of goods sold (COGS)
        $cogs = $this->calculateCOGS($startDate, $endDate, $branchId);

        // Calculate gross profit
        $grossProfit = $revenue - $cogs;


        // In the profitLoss method, replace the expenses query with:
        $expensesQuery = Expense::whereBetween('date', [$startDate, $endDate]);
        if ($branchId) {
            $expensesQuery->where('branch_id', $branchId);
        }
        $totalExpenses = $expensesQuery->sum('amount');

        // Similarly update getProfitTrendData and getExpenseBreakdown methods to include branch filtering
        // Calculate net profit
        $netProfit = $grossProfit - $totalExpenses;

        // Get data for charts
        $profitTrend = $this->getProfitTrendData($startDate, $endDate, $branchId);
        $expenseBreakdown = $this->getExpenseBreakdown($startDate, $endDate);

        $branchName = $branchId ? Branch::find($branchId)->name : null;

        return view('admin.reports.profit_and_lost', [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
            'branchName' => $branchName,
            'branches' => Branch::all(),
            'revenue' => $revenue,
            'totalSales' => $totalSales,
            'totalReturns' => $totalReturns,
            'cogs' => $cogs,
            'grossProfit' => $grossProfit,
            'totalExpenses' => $totalExpenses,
            'netProfit' => $netProfit,
            'profitTrend' => $profitTrend,
            'expenseBreakdown' => $expenseBreakdown,
        ]);
    }

    protected function calculateCOGS($startDate, $endDate, $branchId = null)
    {
        // Get all sold items in the period with their cost prices
        $saleItemsQuery = SaleItem::with(['sale', 'variant'])
            ->whereHas('sale', function ($query) use ($startDate, $endDate, $branchId) {
                $query->whereBetween('sale_date', [$startDate, $endDate])
                    ->where('status', 'completed');

                if ($branchId) {
                    $query->where('branch_id', $branchId);
                }
            });

        $totalCOGS = $saleItemsQuery->get()
            ->sum(function ($item) {
                return $item->quantity * $item->cost_price;
            });

        // Adjust for returned items
        $returnItemsQuery = ReturnItem::with(['return.sale', 'saleItem'])
            ->whereHas('return', function ($query) use ($startDate, $endDate, $branchId) {
                $query->whereBetween('return_date', [$startDate, $endDate])
                    ->where('status', '!=', 'cancelled')
                    ->whereHas('sale', function ($q) use ($branchId) {
                        if ($branchId) {
                            $q->where('branch_id', $branchId);
                        }
                    });
            });

        $returnedCOGS = $returnItemsQuery->get()
            ->sum(function ($item) {
                return $item->quantity * $item->saleItem->cost_price;
            });

        return $totalCOGS - $returnedCOGS;
    }

    protected function getProfitTrendData($startDate, $endDate, $branchId = null)
    {
        $data = [];
        $current = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        // Group by week if period > 3 months, otherwise by day
        $groupByWeek = $current->diffInDays($end) > 90;

        while ($current <= $end) {
            $periodStart = $current->copy();
            $periodEnd = $groupByWeek ? $current->copy()->endOfWeek() : $current->copy()->endOfDay();

            if ($periodEnd > $end) {
                $periodEnd = $end;
            }

            // Calculate for this period
            $salesQuery = Sale::whereBetween('sale_date', [$periodStart, $periodEnd])
                ->where('status', 'completed');

            $returnsQuery = ReturnProduct::whereBetween('return_date', [$periodStart, $periodEnd])
                ->where('status', '!=', 'cancelled');

            if ($branchId) {
                $salesQuery->where('branch_id', $branchId);
                $returnsQuery->whereHas('sale', function ($q) use ($branchId) {
                    $q->where('branch_id', $branchId);
                });
            }

            $totalSales = $salesQuery->sum('total_amount');
            $totalReturns = $returnsQuery->sum('total_amount');
            $revenue = $totalSales - $totalReturns;

            $cogs = $this->calculateCOGS($periodStart->format('Y-m-d'), $periodEnd->format('Y-m-d'), $branchId);
            $grossProfit = $revenue - $cogs;

            // Expenses without branch filter
            $totalExpenses = Expense::whereBetween('date', [$periodStart, $periodEnd])
                ->sum('amount');

            $netProfit = $grossProfit - $totalExpenses;

            $label = $groupByWeek ?
                "Week of " . $periodStart->format('M j') :
                $periodStart->format('M j');

            $data[] = [
                'period' => $label,
                'revenue' => $revenue,
                'gross_profit' => $grossProfit,
                'net_profit' => $netProfit
            ];

            $current = $groupByWeek ? $current->addWeek() : $current->addDay();
        }

        return $data;
    }

    protected function getExpenseBreakdown($startDate, $endDate)
    {
        return Expense::with('category')
            ->whereBetween('date', [$startDate, $endDate])
            ->get()
            ->groupBy('category.name')
            ->map(function ($items, $category) {
                return [
                    'category' => $category,
                    'total' => $items->sum('amount')
                ];
            })
            ->values()
            ->toArray(); // Add this to convert Collection to array
    }
    // In ReportController.php

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
            $salesQuery->whereHas('customer', function($q) use ($customerGroup) {
                $q->where('customer_group', $customerGroup);
            });
        }

        // Get data
        $sales = $salesQuery->orderBy('sale_date', 'desc')->get();
        $totalSales = $sales->sum('total_amount');
        $totalItemsSold = $sales->sum(function($sale) {
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
                'total' => $group->sum(function($item) {
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
