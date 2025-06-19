<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductVariantController extends Controller
{
    public function index(Product $product)
    {
        $variants = $product->variants()
            ->with('product')
            ->latest()
            ->get();

        return view('admin.variant.index', compact('product', 'variants'));
    }

    public function create(Product $product)
    {
        return view('admin.variant.form', compact('product'));
    }


    // Helper function to generate clean SKU
    protected function generateSku($product, $variantSku)
    {
        $productNamePart = strtok($product->name, ' ');
        $productNamePart = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $productNamePart));
        return $productNamePart . '-' . $variantSku;
    }

    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'sku' => 'required|string|max:50', // Reduced max length since we'll be combining it
            'barcode' => 'nullable|string|max:100|unique:product_variants,barcode',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'current_stock' => 'required|integer|min:0',
            'unit_type' => 'required|string|max:50',
            'weight' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        // Generate final SKU
        $finalSku = $this->generateSku($product, $validated['sku']);
        
        // Check uniqueness of the final SKU
        $exists = ProductVariant::where('sku', $finalSku)->exists();
        if ($exists) {
            return back()->withInput()->withErrors([
                'sku' => 'The generated SKU already exists. Please try a different variant SKU.'
            ]);
        }

        $validated['sku'] = $finalSku;
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
