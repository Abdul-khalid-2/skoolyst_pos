<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Illuminate\Validation\Rule;

class ProductsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, SkipsEmptyRows
{
    use SkipsErrors;

    protected $rowCount = 0;
    protected $skippedCount = 0;

    public function model(array $row)
    {
        // Skip rows with missing required data
        if (empty($row['name']) || empty($row['sku']) || empty($row['category'])) {
            $this->skippedCount++;
            return null;
        }

        try {
            // Find or create category
            $category = Category::firstOrCreate(
                ['name' => $row['category']],
                ['name' => $row['category'], 'code' => strtoupper(substr($row['category'], 0, 3))]
            );

            // Find or create brand
            $brand = null;
            if (!empty($row['brand'])) {
                $brand = Brand::firstOrCreate(
                    ['name' => $row['brand']],
                    ['name' => $row['brand'], 'description' => $row['brand']]
                );
            }

            // Find or create supplier
            $supplier = null;
            if (!empty($row['supplier'])) {
                $supplier = Supplier::firstOrCreate(
                    ['name' => $row['supplier']],
                    [
                        'name' => $row['supplier'],
                        'phone' => '0000000000',
                        'address' => 'Not specified'
                    ]
                );
            }

            // Create or update product
            $product = Product::updateOrCreate(
                ['sku' => $row['sku']],
                [
                    'name' => $row['name'],
                    'barcode' => $row['barcode'] ?? null,
                    'category_id' => $category->id,
                    'brand_id' => $brand ? $brand->id : null,
                    'supplier_id' => $supplier ? $supplier->id : null,
                    'description' => $row['description'] ?? null,
                    'status' => $row['status'] ?? 'active',
                    'is_taxable' => isset($row['is_taxable']) ? (bool)$row['is_taxable'] : true,
                    'track_inventory' => isset($row['track_inventory']) ? (bool)$row['track_inventory'] : true,
                    'reorder_level' => $row['reorder_level'] ?? 5,
                ]
            );

            // Handle variants if provided
            if (!empty($row['variant_name'])) {
                $variantData = [
                    'product_id' => $product->id,
                    'name' => $row['variant_name'],
                    'sku' => $row['variant_sku'] ?? $product->sku . '-' . str_slug($row['variant_name']),
                    'barcode' => $row['variant_barcode'] ?? null,
                    'purchase_price' => $row['purchase_price'] ?? 0,
                    'selling_price' => $row['selling_price'] ?? 0,
                    'current_stock' => $row['current_stock'] ?? 0,
                    'unit_type' => $row['unit_type'] ?? 'pcs',
                    'weight' => $row['weight'] ?? null,
                    'status' => $row['status'] ?? 'active',
                ];

                if (isset($row['variant_sku'])) {
                    ProductVariant::updateOrCreate(
                        ['sku' => $row['variant_sku']],
                        $variantData
                    );
                } else {
                    ProductVariant::create($variantData);
                }
            }

            $this->rowCount++;
            return $product;
        } catch (\Exception $e) {
            $this->skippedCount++;
            $this->recordError($row, $e->getMessage());
            return null;
        }
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:100',
            'category' => 'required|string',
            'status' => 'nullable|in:active,inactive',
            'purchase_price' => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'current_stock' => 'nullable|integer|min:0',
        ];
    }

    public function getRowCount()
    {
        return $this->rowCount;
    }

    public function getSkippedCount()
    {
        return $this->skippedCount;
    }

    protected function recordError($row, $message)
    {
        $this->errors[] = [
            'row' => $row,
            'message' => $message
        ];
    }
}
