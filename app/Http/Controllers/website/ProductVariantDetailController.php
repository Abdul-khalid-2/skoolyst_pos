<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductVariant;
use App\Models\Review;
use Illuminate\Support\Str;

class ProductVariantDetailController extends Controller
{
    // Display product detail page using ID with optional slug
    public function show($id, $slug = null)
    {
        $product = Product::with(['category', 'brand', 'reviews', 'variants'])
            ->where('id', $id)
            ->where('status', 'active')
            ->first();
        
        if (!$product) {
            abort(404);
        }
        
        // Redirect to correct URL if slug doesn't match
        $expectedSlug = Str::slug($product->name);
        if ($slug !== $expectedSlug) {
            return redirect()->route('product.detail', ['id' => $id, 'slug' => $expectedSlug]);
        }
        
        return view('product_details', [
            'productId' => $id,
            'product' => $product // Pass product data to avoid extra API call
        ]);
    }

    // Display product detail page using slug only
    public function showBySlug($slug)
    {
        $product = Product::with(['category', 'brand', 'reviews', 'variants'])
            ->where('slug', $slug)
            ->where('status', 'active')
            ->first();
        
        if (!$product) {
            abort(404);
        }
        
        return view('product_details', [
            'productId' => $product->id,
            'product' => $product
        ]);
    }

    // API: Get all products with filters
    public function getAllProducts(Request $request)
    {
        try {
            // Get all products with relationships including variants
            $products = Product::with(['category', 'brand', 'reviews', 'variants'])
                ->where('status', 'active')
                ->get()
                ->map(function($product) {
                    // Get default variant or first variant
                    $defaultVariant = $product->default_variant ?? $product->variants->first();
                    $hasDiscount = $defaultVariant && $defaultVariant->has_discount;
                    $discountPercent = $defaultVariant ? $defaultVariant->discount_percentage : 0;
                    
                    $images = !empty($product->image_paths) ? json_decode($product->image_paths, true) : [];
                    $image = !empty($images) ? $images[0] : '/backend/assets/images/no_image.png';
                    
                    // Get price range from variants
                    $variantPrices = $product->variants->pluck('selling_price');
                    $minPrice = $variantPrices->min() ?? 0;
                    $maxPrice = $variantPrices->max() ?? 0;
                    
                    // Check if product has multiple price points
                    $hasMultiplePrices = $variantPrices->unique()->count() > 1;
                    
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'slug' => $product->slug,
                        'description' => $product->description,
                        'short_description' => $product->short_description,
                        'price' => [
                            'min' => $minPrice,
                            'max' => $maxPrice,
                            'formatted' => $hasMultiplePrices ? 
                                'Rs ' . number_format($minPrice, 2) . ' - Rs ' . number_format($maxPrice, 2) :
                                'Rs ' . number_format($minPrice, 2)
                        ],
                        'has_multiple_prices' => $hasMultiplePrices,
                        'discount' => $discountPercent,
                        'has_discount' => $hasDiscount,
                        'image' => asset($image),
                        'image_paths' => $product->image_paths,
                        'in_stock' => $product->is_in_stock,
                        'stock_quantity' => $product->variants->sum('current_stock'),
                        'category_id' => $product->category_id,
                        'category_name' => $product->category->name ?? 'Uncategorized',
                        'brand_id' => $product->brand_id,
                        'brand_name' => $product->brand->name ?? 'No Brand',
                        'rating' => $product->reviews->avg('rating') ?? 0,
                        'review_count' => $product->reviews->count(),
                        'featured' => $product->featured,
                        'sku' => $product->sku,
                        'barcode' => $product->barcode,
                        'status' => $product->status,
                        'url' => route('product.detail', ['id' => $product->id, 'slug' => Str::slug($product->name)]),
                        'created_at' => $product->created_at,
                        'variants_count' => $product->variants->count(),
                        'has_variants' => $product->variants->count() > 1,
                        'default_variant' => $defaultVariant ? [
                            'id' => $defaultVariant->id,
                            'name' => $defaultVariant->name,
                            'selling_price' => $defaultVariant->selling_price,
                            'has_discount' => $defaultVariant->has_discount,
                            'discount_percentage' => $defaultVariant->discount_percentage
                        ] : null
                    ];
                });
            
            // Get categories with product counts
            $categories = Category::withCount(['products' => function($query) {
                $query->where('status', 'active');
            }])->get()->map(function($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'count' => $category->products_count
                ];
            });
            
            // Get brands with product counts
            $brands = Brand::withCount(['products' => function($query) {
                $query->where('status', 'active');
            }])->get()->map(function($brand) {
                return [
                    'id' => $brand->id,
                    'name' => $brand->name,
                    'count' => $brand->products_count
                ];
            });
            
            // Get price range from product variants
            $minPrice = ProductVariant::whereHas('product', function($query) {
                $query->where('status', 'active');
            })->min('selling_price');
            
            $maxPrice = ProductVariant::whereHas('product', function($query) {
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

    // API: Get single product detail
    public function getProductDetail($id)
    {
        try {
            // Get product by ID or slug
            if (is_numeric($id)) {
                $product = Product::with(['category', 'brand', 'reviews', 'variants'])
                    ->where('id', $id)
                    ->where('status', 'active')
                    ->first();
            } else {
                $product = Product::with(['category', 'brand', 'reviews', 'variants'])
                    ->where('slug', $id)
                    ->where('status', 'active')
                    ->first();
            }
            
            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found'
                ], 404);
            }
            
            // Get default variant
            $defaultVariant = $product->default_variant ?? $product->variants->first();
            $hasDiscount = $defaultVariant && $defaultVariant->has_discount;
            $discountPercent = $defaultVariant ? $defaultVariant->discount_percentage : 0;
            
            // Process images
            $images = !empty($product->image_paths) ? json_decode($product->image_paths, true) : [];
            
            // Get variants
            $variants = $product->variants->map(function($variant) {
                return [
                    'id' => $variant->id,
                    'name' => $variant->name,
                    'sku' => $variant->sku,
                    'barcode' => $variant->barcode,
                    'purchase_price' => $variant->purchase_price,
                    'selling_price' => $variant->selling_price,
                    'current_stock' => $variant->current_stock,
                    'unit_type' => $variant->unit_type,
                    'weight' => $variant->weight,
                    'status' => $variant->status,
                    'remark' => $variant->remark,
                    'has_discount' => $variant->has_discount,
                    'discount_percentage' => $variant->discount_percentage
                ];
            });
            
            $productData = [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'description' => $product->description,
                'short_description' => $product->short_description,
                'price' => [
                    'min' => $variants->min('selling_price') ?? 0,
                    'max' => $variants->max('selling_price') ?? 0
                ],
                'discount' => $discountPercent,
                'has_discount' => $hasDiscount,
                'image_paths' => $product->image_paths,
                'images' => $images,
                'main_image' => !empty($images) ? asset($images[0]) : asset('/backend/assets/images/no_image.png'),
                'stock_quantity' => $product->variants->sum('current_stock'),
                'is_in_stock' => $product->is_in_stock,
                'category_id' => $product->category_id,
                'category_name' => $product->category->name ?? 'Uncategorized',
                'brand_id' => $product->brand_id,
                'brand_name' => $product->brand->name ?? 'No Brand',
                'rating' => $product->reviews->avg('rating') ?? 0,
                'review_count' => $product->reviews->count(),
                'featured' => $product->featured,
                'sku' => $product->sku,
                'barcode' => $product->barcode,
                'status' => $product->status,
                'is_taxable' => $product->is_taxable,
                'track_inventory' => $product->track_inventory,
                'reorder_level' => $product->reorder_level,
                'compatibility' => $product->compatibility,
                'created_at' => $product->created_at,
                'updated_at' => $product->updated_at,
                'default_variant' => $defaultVariant ? [
                    'id' => $defaultVariant->id,
                    'name' => $defaultVariant->name,
                    'selling_price' => $defaultVariant->selling_price,
                    'has_discount' => $defaultVariant->has_discount,
                    'discount_percentage' => $defaultVariant->discount_percentage
                ] : null
            ];
            
            return response()->json([
                'success' => true,
                'data' => [
                    'product' => $productData,
                    'variants' => $variants
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load product: ' . $e->getMessage()
            ], 500);
        }
    }

    // API: Get related products
    public function getRelatedProducts($categoryId, Request $request)
    {
        try {
            $excludeProductId = $request->query('exclude');
            
            $relatedProducts = Product::with(['category', 'brand', 'reviews', 'variants'])
                ->where('category_id', $categoryId)
                ->where('status', 'active')
                ->when($excludeProductId, function($query) use ($excludeProductId) {
                    return $query->where('id', '!=', $excludeProductId);
                })
                ->limit(6)
                ->get()
                ->map(function($product) {
                    // Get default variant
                    $defaultVariant = $product->default_variant ?? $product->variants->first();
                    $hasDiscount = $defaultVariant && $defaultVariant->has_discount;
                    $discountPercent = $defaultVariant ? $defaultVariant->discount_percentage : 0;
                    
                    $images = !empty($product->image_paths) ? json_decode($product->image_paths, true) : [];
                    $image = !empty($images) ? asset($images[0]) : asset('/backend/assets/images/no_image.png');
                    
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'slug' => $product->slug,
                        'description' => $product->description,
                        'short_description' => $product->short_description,
                        'price' => [
                            'min' => $defaultVariant ? $defaultVariant->selling_price : 0
                        ],
                        'discount' => $discountPercent,
                        'has_discount' => $hasDiscount,
                        'image' => $image,
                        'rating' => $product->reviews->avg('rating') ?? 0,
                        'review_count' => $product->reviews->count(),
                        'is_in_stock' => $product->is_in_stock,
                        'url' => route('product.detail', ['id' => $product->id, 'slug' => Str::slug($product->name)])
                    ];
                });
            
            return response()->json([
                'success' => true,
                'data' => $relatedProducts
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load related products: ' . $e->getMessage()
            ], 500);
        }
    }
}