<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Purchase;
use App\Models\SaleItem;
use App\Models\Product;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BackendController extends Controller
{
    public function dashboard()
    {
        $tenantId = auth()->user()->tenant_id ?? 1;

        // 1. Core metrics
        //$totalSales = Sale::where('tenant_id', $tenantId)->sum('total_amount');
        //$totalCost = Sale::with('items')->get()->sum(function ($sale) {
        //     return $sale->items->sum(function ($item) {
        //         return $item->quantity * $item->cost_price;
        //     });
        //});
        //$productsSold = SaleItem::where('tenant_id', $tenantId)->sum('quantity');
        //$profit = $totalSales - $totalCost;

        //$profitMargin = $totalSales > 0 ? ($profit / $totalSales) * 100 : 0;

        $tenantId = auth()->user()->tenant_id;
        $today = now()->format('Y-m-d'); // Gets current date in YYYY-MM-DD format

        $totalSales = Sale::where('tenant_id', $tenantId)
            ->whereDate('sale_date', $today)
            ->sum('total_amount');


        // Today's total cost (more efficient query)
        $totalCost = SaleItem::whereHas('sale', function ($query) use ($tenantId, $today) {
            $query->where('tenant_id', $tenantId)
                ->whereDate('sale_date', $today);
        })
            ->sum(\DB::raw('quantity * cost_price'));

        // Today's products sold
        $productsSold = SaleItem::whereHas('sale', function ($query) use ($tenantId, $today) {
            $query->where('tenant_id', $tenantId)
                ->whereDate('sale_date', $today);
        })
            ->sum('quantity');

        // Today's profit and margin
        $profit = $totalSales - $totalCost;
        $profitMargin = $totalSales > 0 ? ($profit / $totalSales) * 100 : 0;

        // $totalCost = Sale::with('items')->get()->sum(function ($sale) {
        //     return $sale->items->sum(function ($item) {
        //         return $item->quantity * $item->cost_price;
        //     });
        // });
        // $productsSold = SaleItem::where('tenant_id', $tenantId)->sum('quantity');
        // $profit = $totalSales - $totalCost;

        // $profitMargin = $totalSales > 0 ? ($profit / $totalSales) * 100 : 0;

        // 2. Recent sales
        $recentSales = Sale::with(['customer:id,name'])
            ->where('tenant_id', $tenantId)
            ->latest()
            ->take(5)
            ->get();

        // 3. Top products
        $topProducts = SaleItem::with('product:id,name,image_paths')
            ->where('tenant_id', $tenantId)
            ->get()
            ->groupBy('product_id')
            ->map(function ($items, $productId) {
                $product = $items->first()->product;
                return (object)[
                    'id' => $product->id,
                    'name' => $product->name,
                    'total_sold' => $items->sum('quantity'),
                    'total_revenue' => $items->sum('total_price'),
                    'image' => $product->image_paths
                        ? asset('storage/' . json_decode($product->image_paths, true)[0])
                        : asset('backend/assets/images/product/04.png')
                ];
            })
            ->sortByDesc('total_sold')
            ->values()
            ->take(4);

        // 4. Sales overview (last 30 days)
        $salesOverview = Sale::where('tenant_id', $tenantId)
            ->where('created_at', '>=', now()->subDays(30))
            ->get()
            ->groupBy(fn($sale) => $sale->created_at->toDateString())
            ->map(fn($items, $date) => [
                'date' => $date,
                'total' => $items->sum('total_amount')
            ])
            ->sortBy('date')
            ->values();

        // 5. Revenue vs Cost (last 30 days)
        $startDate = Carbon::now()->subDays(30)->startOfDay();
        $sales = Sale::where('tenant_id', $tenantId)
            ->where('created_at', '>=', $startDate)
            ->get()
            ->groupBy(fn($sale) => $sale->created_at->toDateString());

        $purchases = Purchase::where('tenant_id', $tenantId)
            ->where('created_at', '>=', $startDate)
            ->get()
            ->groupBy(fn($purchase) => $purchase->created_at->toDateString());

        $allDates = collect($sales->keys())
            ->merge($purchases->keys())
            ->unique()
            ->sort()
            ->values();

        $revenueVsCost = $allDates->map(function ($date) use ($sales, $purchases) {
            $daySales = $sales->get($date, collect());
            $dayPurchases = $purchases->get($date, collect());
            return [
                'date' => $date,
                'revenue' => $daySales->sum('total_amount'),
                'cost' => $dayPurchases->sum('total_amount')
            ];
        });

        // 6. Best products (top 2)
        $bestProducts = SaleItem::with('product:id,name,image_paths')
            ->where('tenant_id', $tenantId)
            ->get()
            ->groupBy('product_id')
            ->map(function ($items, $productId) {
                $product = $items->first()->product;
                return (object)[
                    'id' => $product->id,
                    'name' => $product->name,
                    'total_sold' => $items->sum('quantity'),
                    'total_revenue' => $items->sum('total_price'),
                    'image' => $product->image_paths
                        ? asset('storage/' . json_decode($product->image_paths, true)[0])
                        : asset('backend/assets/images/product/04.png')
                ];
            })
            ->sortByDesc('total_sold')
            ->values()
            ->take(2);

        // 7. Income & expenses
        $income = Transaction::where('tenant_id', $tenantId)
            ->where('type', 'income')
            ->sum('amount');

        $expenses = Transaction::where('tenant_id', $tenantId)
            ->where('type', 'expense')
            ->sum('amount');

        return view('admin.dashboard.index', [
            'totalSales' => $totalSales,
            'totalCost' => $totalCost,
            'productsSold' => $productsSold,
            'profit' => $profit,
            'profitMargin' => $profitMargin,
            'recentSales' => $recentSales,
            'topProducts' => $topProducts,
            'salesOverview' => $salesOverview,
            'revenueVsCost' => $revenueVsCost,
            'bestProducts' => $bestProducts,
            'income' => $income,
            'expenses' => $expenses,
        ]);
    }

    public function getFinancialData(Request $request)
    {
        $tenantId = auth()->user()->tenant_id ?? 1;
        $period = $request->input('period', 'month');

        $now = Carbon::now();

        if ($period === 'year') {
            $startDate = $now->copy()->subYear();
        } elseif ($period === 'week') {
            $startDate = $now->copy()->subWeek();
        } else {
            $startDate = $now->copy()->subMonth();
        }

        $income = Transaction::where('tenant_id', $tenantId)
            ->where('type', 'income')
            ->where('created_at', '>=', $startDate)
            ->sum('amount');

        $expenses = Transaction::where('tenant_id', $tenantId)
            ->where('type', 'expense')
            ->where('created_at', '>=', $startDate)
            ->sum('amount');

        return response()->json([
            'income' => $income,
            'expenses' => $expenses
        ]);
    }



    public function getRecentSales(Request $request)
    {
        $tenantId = auth()->user()->tenant_id ?? 1;
        $period = $request->input('period', 'month');
        $limit = 5; // Number of recent sales to show

        $now = Carbon::now();

        $query = Sale::with(['customer:id,name'])
            ->where('tenant_id', $tenantId)
            ->latest();

        if ($period === 'year') {
            $query->where('created_at', '>=', $now->copy()->subYear());
        } elseif ($period === 'week') {
            $query->where('created_at', '>=', $now->copy()->subWeek());
        } else {
            // Default to month
            $query->where('created_at', '>=', $now->copy()->subMonth());
        }

        $recentSales = $query->take($limit)->get();

        return response()->json([
            'sales' => $recentSales
        ]);
    }

    public function getTopProducts(Request $request)
    {
        $tenantId = auth()->user()->tenant_id ?? 1;
        $period = $request->input('period', 'month');
        $limit = $request->input('limit', 4);

        $now = Carbon::now();

        // Determine the start date based on period
        $startDate = match ($period) {
            'year' => $now->copy()->subYear(),
            'week' => $now->copy()->subWeek(),
            default => $now->copy()->subMonth(),
        };

        // Get sales within the period
        $sales = Sale::where('tenant_id', $tenantId)
            ->where('created_at', '>=', $startDate)
            ->with('items.product:id,name,image_paths')
            ->get();

        // Process the data
        $topProducts = $sales->flatMap(function ($sale) {
            return $sale->items->map(function ($item) {
                return [
                    'product_id' => $item->product_id,
                    'product' => $item->product,
                    'quantity' => $item->quantity,
                    'total_price' => $item->total_price
                ];
            });
        })
            ->groupBy('product_id')
            ->map(function ($items, $productId) {
                $product = $items->first()['product'];
                return (object)[
                    'id' => $productId,
                    'name' => $product->name,
                    'total_sold' => $items->sum('quantity'),
                    'total_revenue' => $items->sum('total_price'),
                    'image' => $product->image_paths
                        ? asset('storage/' . json_decode($product->image_paths, true)[0])
                        : asset('backend/assets/images/product/04.png')
                ];
            })
            ->sortByDesc('total_sold')
            ->take($limit)
            ->values();

        return response()->json([
            'products' => $topProducts
        ]);
    }

    public function getSalesOverview(Request $request)
    {
        $tenantId = auth()->user()->tenant_id ?? 1;
        $period = $request->input('period', 'month');
        $now = Carbon::now();

        $startDate = match ($period) {
            'year' => $now->copy()->subYear(),
            'week' => $now->copy()->subWeek(),
            default => $now->copy()->subMonth(),
        };

        $sales = Sale::where('tenant_id', $tenantId)
            ->where('created_at', '>=', $startDate)
            ->get()
            ->groupBy(fn($sale) => $sale->created_at->toDateString())
            ->map(fn($items, $date) => [
                'date' => $date,
                'total' => $items->sum('total_amount')
            ])
            ->sortBy('date')
            ->values();

        return response()->json(['sales' => $sales]);
    }

    public function getRevenueCost(Request $request)
    {
        $tenantId = auth()->user()->tenant_id ?? 1;
        $period = $request->input('period', 'month');
        $now = Carbon::now();

        $startDate = match ($period) {
            'year' => $now->copy()->subYear(),
            'week' => $now->copy()->subWeek(),
            default => $now->copy()->subMonth(),
        };

        $sales = Sale::where('tenant_id', $tenantId)
            ->where('created_at', '>=', $startDate)
            ->get()
            ->groupBy(fn($sale) => $sale->created_at->toDateString());

        $purchases = Purchase::where('tenant_id', $tenantId)
            ->where('created_at', '>=', $startDate)
            ->get()
            ->groupBy(fn($purchase) => $purchase->created_at->toDateString());

        $allDates = collect($sales->keys())
            ->merge($purchases->keys())
            ->unique()
            ->sort()
            ->values();

        $data = $allDates->map(function ($date) use ($sales, $purchases) {
            return [
                'date' => $date,
                'revenue' => $sales->get($date, collect())->sum('total_amount'),
                'cost' => $purchases->get($date, collect())->sum('total_amount')
            ];
        });

        return response()->json(['data' => $data]);
    }
}
