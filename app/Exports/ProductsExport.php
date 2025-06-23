<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class ProductsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithColumnFormatting
{
    protected $includeVariants;

    public function __construct($includeVariants = true)
    {
        $this->includeVariants = $includeVariants;
    }

    public function collection()
    {
        return Product::with(['category', 'brand', 'supplier', 'variants'])
            ->orderBy('name')
            ->get();
    }

    public function headings(): array
    {
        $baseHeadings = [
            'ID',
            'Name',
            'SKU',
            'Barcode',
            'Category',
            'Brand',
            'Supplier',
            'Description',
            'Status',
            'Taxable',
            'Track Inventory',
            'Reorder Level'
        ];

        if ($this->includeVariants) {
            $variantHeadings = [
                'Variant Name',
                'Variant SKU',
                'Variant Barcode',
                'Purchase Price',
                'Selling Price',
                'Current Stock',
                'Unit Type',
                'Weight'
            ];
            return array_merge($baseHeadings, $variantHeadings);
        }

        return $baseHeadings;
    }

    public function map($product): array
    {
        $baseData = [
            $product->id,
            $product->name,
            $product->sku,
            $product->barcode,
            $product->category->name ?? '',
            $product->brand->name ?? '',
            $product->supplier->name ?? '',
            $product->description,
            $product->status,
            $product->is_taxable ? 'Yes' : 'No',
            $product->track_inventory ? 'Yes' : 'No',
            $product->reorder_level
        ];

        if (!$this->includeVariants || $product->variants->isEmpty()) {
            return $baseData;
        }

        $mappedData = [];
        foreach ($product->variants as $variant) {
            $variantData = [
                $variant->name,
                $variant->sku,
                $variant->barcode,
                $variant->purchase_price,
                $variant->selling_price,
                $variant->current_stock,
                $variant->unit_type,
                $variant->weight
            ];
            $mappedData[] = array_merge($baseData, $variantData);
        }

        return $mappedData;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => ['font' => ['bold' => true]],

            // Style variant rows with light background
            'A2:Z1000' => [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['argb' => 'FFF9F9F9']
                ]
            ]
        ];
    }

    public function columnFormats(): array
    {
        return [
            'N' => NumberFormat::FORMAT_NUMBER_00, // Purchase Price
            'O' => NumberFormat::FORMAT_NUMBER_00, // Selling Price
            'P' => NumberFormat::FORMAT_NUMBER,    // Current Stock
            'Q' => NumberFormat::FORMAT_NUMBER_00  // Weight
        ];
    }
}
