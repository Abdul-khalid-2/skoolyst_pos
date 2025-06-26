<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'brand', 'supplier', 'variants'])
            ->withCount('variants')
            ->latest()
            ->get();

        return view('admin.product.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();

        return view('admin.product.create', compact('categories', 'brands', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:100|unique:products,sku',
            'barcode' => 'nullable|string|max:100|unique:products,barcode',
            'category_id' => 'nullable|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'is_taxable' => 'required|boolean',
            'track_inventory' => 'required|boolean',
            'reorder_level' => 'nullable|integer|min:0',
            'image_paths' => 'nullable|json',
        ]);

        $validated['tenant_id'] = auth()->user()->tenant_id;

        // Create product
        $product = Product::create($validated);

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully. Add variants next.');
    }

    public function show(Product $product)
    {
        $product->load([
            'category',
            'brand',
            'supplier',
            'variants',
            'inventoryLogs' => function ($query) {
                $query->latest()->with(['variant', 'user']);
            }
        ]);

        return view('admin.product.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();

        return view('admin.product.edit', compact('product', 'categories', 'brands', 'suppliers'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:100|unique:products,sku,' . $product->id,
            'barcode' => 'nullable|string|max:100|unique:products,barcode,' . $product->id,
            'category_id' => 'nullable|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'is_taxable' => 'required|boolean',
            'track_inventory' => 'required|boolean',
            'reorder_level' => 'nullable|integer|min:0',
            'image_paths' => 'nullable|json',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {

        if ($product->image_paths) {
            $images = json_decode($product->image_paths);
            foreach ($images as $image) {
                Storage::delete('public/' . $image);
            }
        }

        $product->delete();
        $product->variants()->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function uploadImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        $path = Storage::disk('website')->put('product_images', $request->image);

        return response()->json(['path' => $path]);
    }

    public function removeImage(Request $request)
    {
        $request->validate([
            'path' => 'required|string'
        ]);

        Storage::disk('website')->delete($request->path);

        return response()->json(['success' => true]);
    }

    public function inventory(Product $product)
    {

        $product->load(['variants', 'inventoryLogs']);
        return view('admin.inventory.index', compact('product'));
    }

    public function inventoryHistory(Product $product)
    {
        $inventoryLogs = $product->inventoryLogs()
            ->with(['variant', 'user', 'branch'])
            ->latest()
            ->paginate(20);

        return view('admin.product.inventory-history', compact('product', 'inventoryLogs'));
    }
}
