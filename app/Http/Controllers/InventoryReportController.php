<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Purchase;
use App\Models\Expense;
use App\Models\ReturnProduct;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Customer;
use App\Models\InventoryLog;
use App\Models\Product;
use App\Models\ReturnItem;
use App\Models\SaleItem;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InventoryReportController extends Controller
{
    public function inventory(Request $request)
    {
        // Get filters from request
        $branchId = $request->input('branch_id');
        $categoryId = $request->input('category_id');
        $stockLevel = $request->input('stock_level', 'all'); // all, low, out

        // Base query
        $productsQuery = Product::with(['variants', 'category', 'brand'])
            ->where('tenant_id', auth()->user()->tenant_id)
            ->where('track_inventory', true);

        // Apply filters
        if ($categoryId) {
            $productsQuery->where('category_id', $categoryId);
        }

        if ($branchId) {
            $productsQuery->with(['variants' => function($query) use ($branchId) {
                $query->with(['inventory' => function($q) use ($branchId) {
                    $q->where('branch_id', $branchId);
                }]);
            }]);
        }

        // Get all products
        $products = $productsQuery->get()->map(function($product) use ($branchId) {
            $variants = $product->variants->map(function($variant) use ($product, $branchId) {
                $stock = $branchId ? 
                    ($variant->inventory->first()?->closing_stock ?? 0) : 
                    $variant->current_stock;
                    
                return [
                    'id' => $variant->id,
                    'name' => $variant->name,
                    'sku' => $variant->sku,
                    'stock' => $stock,
                    'reorder_level' => $product->reorder_level ?? 0, // Added null check
                    'status' => $stock <= 0 ? 'Out of Stock' : 
                            ($stock <= ($product->reorder_level ?? 0) ? 'Low Stock' : 'In Stock')
                ];
            });

            return [
                'id' => $product->id,
                'name' => $product->name,
                'category' => $product->category->name ?? 'Uncategorized',
                'brand' => $product->brand->name ?? 'No Brand',
                'variants' => $variants,
                'total_stock' => $variants->sum('stock'),
                'status' => $variants->every(fn($v) => $v['stock'] <= 0) ? 'Out of Stock' : 
                        ($variants->some(fn($v) => $v['stock'] <= ($product->reorder_level ?? 0)) ? 'Low Stock' : 'In Stock')
            ];
        });

        // Apply stock level filter
        if ($stockLevel !== 'all') {
            $products = $products->filter(function($product) use ($stockLevel) {
                return $stockLevel === 'out' ? 
                    $product['status'] === 'Out of Stock' : 
                    $product['status'] === 'Low Stock';
            });
        }

        // Inventory summary
        $inventorySummary = [
            'total_products' => $products->count(),
            'total_variants' => $products->sum(fn($p) => count($p['variants'])),
            'out_of_stock' => $products->filter(fn($p) => $p['status'] === 'Out of Stock')->count(),
            'low_stock' => $products->filter(fn($p) => $p['status'] === 'Low Stock')->count()
        ];

        // Stock movement data (last 30 days)
        $stockMovement = $this->getStockMovement($branchId);

        return view('admin.reports.inventory', [
            'products' => $products,
            'inventorySummary' => $inventorySummary,
            'stockMovement' => $stockMovement,
            'branchId' => $branchId,
            'categoryId' => $categoryId,
            'stockLevel' => $stockLevel,
            'branches' => Branch::where('tenant_id', auth()->user()->tenant_id)->get(),
            'categories' => Category::where('tenant_id', auth()->user()->tenant_id)->get()
        ]);
    }

    protected function getStockMovement($branchId = null)
    {
        $startDate = Carbon::now()->subDays(30)->format('Y-m-d');
        $endDate = Carbon::now()->format('Y-m-d');

        $query = InventoryLog::with(['product', 'variant', 'branch'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('tenant_id', auth()->user()->tenant_id);

        if ($branchId) {
            $query->where('branch_id', $branchId);
        }

        return $query->orderBy('created_at', 'desc')
            ->take(50)
            ->get()
            ->groupBy(function($log) {
                return $log->created_at->format('Y-m-d');
            })
            ->map(function($logs, $date) {
                return [
                    'date' => $date,
                    'items_added' => $logs->where('quantity_change', '>', 0)->sum('quantity_change'),
                    'items_removed' => abs($logs->where('quantity_change', '<', 0)->sum('quantity_change')),
                    'transactions' => $logs->count()
                ];
            })
            ->values();
    }
}