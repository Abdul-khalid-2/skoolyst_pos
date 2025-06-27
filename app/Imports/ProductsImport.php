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
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ProductsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, SkipsEmptyRows
{
    use SkipsErrors;

    protected $rowCount = 0;
    protected $skippedCount = 0;
    protected $errors = [];
    protected $tenantId;

    public function __construct()
    {
        $this->tenantId = Auth::check() ? Auth::user()->tenant_id : null;

        if (!$this->tenantId) {
            throw new \Exception('Tenant ID not found. User must be authenticated and have a tenant_id.');
        }
    }

    public function model(array $row)
    {
        $row = $this->normalizeRow($row);

        if (empty($row['name']) || empty($row['sku'])) {
            $this->skippedCount++;
            $this->recordError($row, 'Missing required fields (name or sku)');
            return null;
        }

        try {
            // Process category if provided
            $categoryId = null;
            if (!empty($row['category'])) {
                $category = Category::firstOrCreate(
                    ['tenant_id' => $this->tenantId, 'id' => $row['category']],
                );
                $categoryId = $category->id;
            }

            $brandId = null;
            if (!empty($row['brand'])) {
                $brand = Brand::firstOrCreate(
                    ['tenant_id' => $this->tenantId, 'name' => $row['brand']],
                    ['description' => $row['brand']]
                );
                $brandId = $brand->id;
            }

            // Process supplier if provided
            $supplierId = null;
            if (!empty($row['supplier'])) {
                $supplier = Supplier::firstOrCreate(
                    ['tenant_id' => $this->tenantId, 'name' => $row['supplier']],
                    [
                        'phone' => '0000000000',
                        'address' => 'Not specified'
                    ]
                );
                $supplierId = $supplier->id;
            }

            // Create/update product
            $product = Product::updateOrCreate(
                ['tenant_id' => $this->tenantId, 'sku' => $row['sku']],
                [
                    'name' => $row['name'],
                    'barcode' => $row['barcode'] ?? null,
                    'category_id' => $categoryId,
                    'brand_id' => $brandId,
                    'supplier_id' => $supplierId,
                    'description' => $row['description'] ?? null,
                    'status' => $this->normalizeStatus($row['status'] ?? 'active'),
                    'is_taxable' => $this->convertToBoolean($row['is_taxable'] ?? false),
                    'track_inventory' => $this->convertToBoolean($row['track_inventory'] ?? false),
                    'reorder_level' => $row['reorder_level'] ?? 0,
                ]
            );

            // Process variant if provided
            // if (!empty($row['variant_name'])) {
            //     if (!empty($row['variant_sku'])) {
            //         // First try to find existing variant
            //         $existingVariant = ProductVariant::where([
            //             'tenant_id' => $this->tenantId,
            //             'product_id' => $product->id,
            //             'sku' => $row['variant_sku'] // Check if SKU exists without the name prefix
            //         ])->first();

            //         // Determine the SKU to use
            //         $remark = $row['remark'] ?? '--';
            //         if ($existingVariant) {

            //             $existSameVariant = ProductVariant::where([
            //                 'remark' => $remark
            //             ])->first();
            //             $concateRemare = $row['variant_sku'] . "-" . $remark;
            //             $sku = $existSameVariant  ? $row['variant_sku'] : str_replace(' ', '-', $row['variant_sku']);
            //         } else {
            //             $sku =  str_replace(' ', '-', $row['variant_sku']);
            //         }

            //         ProductVariant::updateOrCreate(
            //             [
            //                 'tenant_id' => $this->tenantId,
            //                 'product_id' => $product->id,
            //                 'sku' => $sku,
            //                 'name' => $row['variant_name'],  // Include name in the unique identifier
            //             ],
            //             [

            //                 'barcode' => $row['variant_barcode'] ?? null,
            //                 'purchase_price' => $this->parseNumber($row['purchase_price'] ?? 0),
            //                 'selling_price' => $this->parseNumber($row['selling_price'] ?? 0),
            //                 'current_stock' => (int)($row['current_stock'] ?? 0),
            //                 'unit_type' => $row['unit_type'] ?? 'pcs',
            //                 'remark' => $row['remark'] ?? '--',
            //                 'status' => $this->normalizeStatus($row['status'] ?? 'active'),
            //             ]
            //         );
            //     }
            // }
            if (!empty($row['variant_name'])) {
                if (!empty($row['variant_sku'])) {
                    // First try to find existing variant with same name and SKU but different remark
                    $existingVariantWithDifferentRemark = ProductVariant::where([
                        'tenant_id' => $this->tenantId,
                        'product_id' => $product->id,
                        'name' => $row['variant_name'],
                    ])
                        ->where('sku', 'like', $row['variant_sku'] . '%') // SKU starts with the same base
                        ->where('remark', '!=', $row['remark'] ?? '--')
                        ->first();

                    // Determine the SKU to use
                    $remarkPart = isset($row['remark']) ? '( ' . str_replace(' ', '-', $row['remark']) . ' )' : '';

                    if ($existingVariantWithDifferentRemark) {
                        // If there's an existing variant with same name and SKU base but different remark,
                        // we need to make the SKU unique by adding the remark
                        $sku = str_replace(' ', '-', $row['variant_sku']) . '-' . $remarkPart;
                    } else {
                        // Check if there's an exact match (same name, SKU, and remark)
                        $existingExactVariant = ProductVariant::where([
                            'tenant_id' => $this->tenantId,
                            'product_id' => $product->id,
                            'name' => $row['variant_name'],
                            'sku' => $row['variant_sku'],
                            'remark' => $row['remark'] ?? '--',
                        ])->first();

                        $sku = $existingExactVariant ? $row['variant_sku'] : str_replace(' ', '-', $row['variant_sku']);
                    }

                    ProductVariant::updateOrCreate(
                        [
                            'tenant_id' => $this->tenantId,
                            'product_id' => $product->id,
                            'sku' => $sku,
                            'name' => $row['variant_name'],  // Include name in the unique identifier
                        ],
                        [

                            'barcode' => $row['variant_barcode'] ?? null,
                            'purchase_price' => $this->parseNumber($row['purchase_price'] ?? 0),
                            'selling_price' => $this->parseNumber($row['selling_price'] ?? 0),
                            'current_stock' => (int)($row['current_stock'] ?? 0),
                            'unit_type' => $row['unit_type'] ?? 'pcs',
                            'remark' => $row['remark'] ?? '--',
                            'status' => $this->normalizeStatus($row['status'] ?? 'active'),
                        ]
                    );
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
            'barcode' => 'nullable|string|max:100',
            'category' => 'nullable',
            'brand' => 'nullable|string',
            'supplier' => 'nullable|string',
            'status' => 'nullable|in:active,inactive',
            'is_taxable' => 'nullable|boolean',
            'track_inventory' => 'nullable|boolean',
            'reorder_level' => 'nullable|integer|min:0',
            'variant_name' => 'nullable|string',
            'variant_sku' => 'nullable|string|max:100',
            'variant_barcode' => 'nullable|string|max:100',
            'purchase_price' => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'current_stock' => 'nullable|integer|min:0',
            'unit_type' => 'nullable|string',
            'remark' => 'nullable',
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

    public function getErrors()
    {
        return $this->errors;
    }

    protected function recordError($row, $message)
    {
        $this->errors[] = [
            'row' => $row,
            'message' => $message
        ];
    }

    protected function normalizeRow(array $row): array
    {
        // Handle case sensitivity and different naming conventions
        $normalized = [];
        foreach ($row as $key => $value) {
            $normalized[strtolower($key)] = $value;
        }

        return $normalized;
    }

    protected function convertToBoolean($value): bool
    {
        if (is_bool($value)) return $value;
        if (is_int($value)) return (bool)$value;
        if (is_string($value)) {
            $value = strtolower($value);
            return in_array($value, ['yes', 'true', '1', 'y']);
        }
        return false;
    }

    protected function normalizeStatus($status): string
    {
        $status = strtolower($status);
        return in_array($status, ['active', 'inactive']) ? $status : 'active';
    }

    protected function parseNumber($value)
    {
        if (is_null($value)) return null;
        if (is_numeric($value)) return $value;

        // Handle formatted numbers (like "1,000.50")
        return (float)str_replace(',', '', trim($value));
    }
}
