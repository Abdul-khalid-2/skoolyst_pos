<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductVariant;

class ProductsController extends Controller
{
    // Display products page
    public function index()
    {
        return view('website.products');
    }

    // API endpoint to get all products and filters
    public function getAllProducts(Request $request)
    {
        try {
            // Get all products with relationships including variants
            $products = Product::with(['category', 'brand', 'reviews', 'variants'])
                ->where('status', 'active')
                ->get()
                ->map(function ($product) {
                    $image = !empty($product->image_paths) ? $product->image_paths[0] : null;

                    // Get price range from variants
                    $variantPrices = $product->variants->pluck('selling_price');
                    $minPrice = $variantPrices->min();
                    $maxPrice = $variantPrices->max();

                    // Check if product has multiple price points
                    $hasMultiplePrices = $variantPrices->unique()->count() > 1;

                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'slug' => $product->slug,
                        'description' => $product->description,
                        'short_description' => $product->short_description,
                        'price' => $hasMultiplePrices ? [
                            'min' => $minPrice,
                            'max' => $maxPrice,
                            'formatted' => 'Rs ' . number_format($minPrice, 2) . ' - Rs ' . number_format($maxPrice, 2)
                        ] : [
                            'min' => $minPrice,
                            'max' => $minPrice,
                            'formatted' => 'Rs ' . number_format($minPrice, 2)
                        ],
                        'has_multiple_prices' => $hasMultiplePrices,
                        'discount' => $product->discount,
                        'image' => $image,
                        'in_stock' => $product->variants->sum('current_stock') > 0,
                        'stock_quantity' => $product->variants->sum('current_stock'),
                        'category_id' => $product->category_id,
                        'category_name' => $product->category->name ?? 'Uncategorized',
                        'brand_id' => $product->brand_id,
                        'brand_name' => $product->brand->name ?? 'No Brand',
                        'rating' => $product->reviews->avg('rating') ?? 0,
                        'review_count' => $product->reviews->count(),
                        'featured' => $product->featured,
                        'url' => route('product.detail', $product->slug),
                        'created_at' => $product->created_at,
                        'variants_count' => $product->variants->count(),
                        'has_variants' => $product->variants->count() > 1
                    ];
                });

            // Get categories with product counts
            $categories = Category::withCount(['products' => function ($query) {
                $query->where('status', 'active');
            }])->get()->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'count' => $category->products_count
                ];
            });

            // Get brands with product counts
            $brands = Brand::withCount(['products' => function ($query) {
                $query->where('status', 'active');
            }])->get()->map(function ($brand) {
                return [
                    'id' => $brand->id,
                    'name' => $brand->name,
                    'count' => $brand->products_count
                ];
            });

            // Get price range from product variants
            $minPrice = ProductVariant::whereHas('product', function ($query) {
                $query->where('status', 'active');
            })->min('selling_price');

            $maxPrice = ProductVariant::whereHas('product', function ($query) {
                $query->where('status', 'active');
            })->max('selling_price');

            return response()->json([
                'success' => true,
                'data' => [
                    'products' => $products,
                    'filters' => [
                        'categories' => $categories,
                        'brands' => $brands,
                        'price_range' => [
                            'min' => $minPrice ?? 0,
                            'max' => $maxPrice ?? 100000
                        ]
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load products: ' . $e->getMessage()
            ], 500);
        }
    }
}
