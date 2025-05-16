<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Purchase;
use App\Models\SaleItem;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;


class BackendController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function dashboard()
    {
        $tenantId = auth()->user()->tenant_id ?? 1;

        // Sales data
        $totalSales = Sale::where('tenant_id', $tenantId)->sum('total_amount');
        $totalCost = Purchase::where('tenant_id', $tenantId)->sum('total_amount');
        $productsSold = SaleItem::where('tenant_id', $tenantId)->sum('quantity');

        // Recent sales
        $recentSales = Sale::where('tenant_id', $tenantId)
            ->latest()
            ->take(5)
            ->get();

        // Top products
        // $topProducts = SaleItem::with('product')
        //     ->where('tenant_id', $tenantId)
        //     ->select('product_id', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(total_price) as total_revenue'))
        //     ->groupBy('product_id')
        //     ->orderByDesc('total_sold')
        //     ->with('product:id,name')
        //     ->take(4)
        //     ->get()
        //     ->map(function ($item) {
        //         return [
        //             'id' => $item->product->id,
        //             'name' => $item->product->name,
        //             'total_sold' => $item->total_sold,
        //             'total_revenue' => $item->total_revenue,
        //         ];
        //     });

        $topProducts = SaleItem::with('product')
            ->where('tenant_id', $tenantId)
            ->select('product_id', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(total_price) as total_revenue'))
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->with('product:id,name')
            ->take(4)
            ->get()
            ->map(function ($item) {
                return (object)[
                    'id' => $item->product->id,
                    'name' => $item->product->name,
                    'total_sold' => $item->total_sold,
                    'total_revenue' => $item->total_revenue,
                ];
            });

        // Sales overview (last 30 days)
        $salesOverview = Sale::where('tenant_id', $tenantId)
            ->where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Revenue vs cost (last 30 days)
        $salesData = Sale::where('tenant_id', $tenantId)
            ->where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue')
            ->groupBy('date')
            ->orderBy('date');

        $revenueVsCost = Purchase::where('tenant_id', $tenantId)
            ->where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as cost')
            ->groupBy('date')
            ->orderBy('date')
            ->union($salesData)
            ->get();

        // Best selling product
        $bestProduct = SaleItem::select('product_id', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(total_price) as total_revenue'))
            ->where('tenant_id', $tenantId)
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->with('product:id,name')
            ->first();

        // Second best product
        $secondBestProduct = SaleItem::select('product_id', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(total_price) as total_revenue'))
            ->where('tenant_id', $tenantId)
            ->when($bestProduct, function ($query) use ($bestProduct) {
                return $query->where('product_id', '!=', $bestProduct->product_id);
            })
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->with('product:id,name')
            ->first();

        // Income and expenses
        $income = Transaction::where('tenant_id', $tenantId)
            ->where('type', 'income')
            ->sum('amount');

        $expenses = Transaction::where('tenant_id', $tenantId)
            ->where('type', 'expense')
            ->sum('amount');
        // $topProducts = SaleItem::with('product')
        //     ->where('tenant_id', $tenantId)
        //     ->select('product_id', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(total_price) as total_revenue'))
        //     ->groupBy('product_id')
        //     ->orderByDesc('total_sold')
        //     ->with('product:id,name')
        //     ->take(4)
        //     ->get();
        return view('admin.dashboard.index', [
            'totalSales' => $totalSales,
            'totalCost' => $totalCost,
            'productsSold' => $productsSold,
            'recentSales' => $recentSales,
            'topProducts' => $topProducts,
            'salesOverview' => $salesOverview,
            'revenueVsCost' => $revenueVsCost,
            'bestProduct' => $bestProduct,
            'secondBestProduct' => $secondBestProduct,
            'income' => $income,
            'expenses' => $expenses,
        ]);
    }

    public function index()
    {
        return view('dashboard');
    }
}
