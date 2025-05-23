<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    public function index(Product $product)
    {
        $variants = $product->variants()
            ->with('product')
            ->latest()
            ->paginate(10);

        return view('admin.variant.index', compact('product', 'variants'));
    }

    public function create(Product $product)
    {
        return view('admin.variant.form', compact('product'));
    }

    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'sku' => 'required|string|max:100|unique:product_variants,sku',
            'barcode' => 'nullable|string|max:100|unique:product_variants,barcode',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'current_stock' => 'required|integer|min:0',
            'unit_type' => 'required|string|max:50',
            'weight' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $validated['product_id'] = $product->id;
        $validated['tenant_id'] = auth()->user()->tenant_id;

        ProductVariant::create($validated);

        return redirect()->route('product-variants.index', $product->id)
            ->with('success', 'Product variant created successfully.');
    }

    public function edit(Product $product, ProductVariant $variant)
    {
        return view('admin.variant.form', compact('product', 'variant'));
    }

    public function update(Request $request, Product $product, ProductVariant $variant)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'sku' => 'required|string|max:100|unique:product_variants,sku,' . $variant->id,
            'barcode' => 'nullable|string|max:100|unique:product_variants,barcode,' . $variant->id,
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'current_stock' => 'required|integer|min:0',
            'unit_type' => 'required|string|max:50',
            'weight' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $variant->update($validated);

        return redirect()->route('product-variants.index', $product->id)
            ->with('success', 'Product variant updated successfully.');
    }

    public function destroy(Product $product, ProductVariant $variant)
    {
        $variant->delete();

        return redirect()->route('product-variants.index', $product->id)
            ->with('success', 'Product variant deleted successfully.');
    }
}
