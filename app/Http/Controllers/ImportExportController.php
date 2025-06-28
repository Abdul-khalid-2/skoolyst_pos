<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;
use App\Exports\ProductsExport;
use Barryvdh\DomPDF\Facade\Pdf;

class ImportExportController extends Controller
{
    /**
     * Show import modal
     */
    public function showImport()
    {
        return view('admin.settings.import');
    }

    /**
     * Process import
     */
    public function import(Request $request)
    {
        set_time_limit(900);
        $request->validate([
            'import_file' => 'required|file|mimes:csv,txt,xlsx|max:2048'
        ]);

        $file = $request->file('import_file');
        if (!$file->isValid()) {
            return back()->with('error', 'Invalid file upload');
        }

        try {
            $import = new ProductsImport();
            Excel::import($import, $file);

            $importedCount = $import->getRowCount();
            $skippedCount = $import->getSkippedCount();
            $errors = $import->getErrors();

            $message = "Successfully imported {$importedCount} products.";
            if ($skippedCount > 0) {
                $message .= " {$skippedCount} rows were skipped due to errors.";
                session()->flash('import_errors', $errors);
            }

            return redirect()->back()
                ->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error importing products: ' . $e->getMessage());
        }
    }

    /**
     * Show export modal
     */
    public function showExport()
    {
        return view('admin.settings.export');
    }

    /**
     * Process export
     */
    public function export(Request $request)
    {
        ini_set('memory_limit', '512M'); 
        set_time_limit(300); 
        $request->validate([
            'format' => 'required|in:csv,xlsx,pdf',
            'include_variants' => 'sometimes|boolean'
        ]);

        $includeVariants = $request->boolean('include_variants', true);
        $fileName = 'products_export_' . date('Ymd_His') . '.' . $request->format;

        if ($request->format === 'pdf') {
            $products = Product::with(['category', 'brand', 'variants'])->get();
            $pdf = PDF::loadView('admin.settings.export_import.products_pdf', [
                'products' => $products,
                'includeVariants' => $includeVariants
            ]);

            // Set options for page breaks
            $pdf->setOption('margin-top', 10);
            $pdf->setOption('margin-bottom', 10);
            $pdf->setOption('margin-left', 10);
            $pdf->setOption('margin-right', 10);

            return $pdf->download($fileName);
        }

        if ($request->format === 'csv') {
            return Excel::download(
                new ProductsExport($includeVariants),
                $fileName,
                \Maatwebsite\Excel\Excel::CSV
            );
        }

        return Excel::download(
            new ProductsExport($includeVariants),
            $fileName
        );
    }

    /**
     * Download import template
     */
    public function downloadTemplate()
    {
        $templateDir = storage_path('app/public/templates');
        $templatePath = $templateDir . '/products_import_template.csv';

        if (!file_exists($templateDir)) {
            if (!mkdir($templateDir, 0755, true)) {
                return back()->with('error', 'Failed to create templates directory');
            }
        }

        $headers = [
            'name',
            'sku',
            'barcode',
            'category',
            'brand',
            'supplier',
            'description',
            'status',
            'is_taxable',
            'track_inventory',
            'reorder_level',
            'variant_name',
            'variant_sku',
            'variant_barcode',
            'purchase_price',
            'selling_price',
            'current_stock',
            'unit_type',
            'remark'
        ];

        $sampleProducts = [
            // Product 1 with 2 variants (category, brand, supplier can be null)
            [
                'name' => 'Wireless Earbuds',
                'sku' => 'WEB-100',
                'barcode' => '',
                'category' => '',
                'brand' => '',
                'supplier' => '',
                'description' => 'Premium wireless earbuds with charging case',
                'status' => 'active',
                'is_taxable' => '1',
                'track_inventory' => '1',
                'reorder_level' => '15',
                'variant_name' => 'Black',
                'variant_sku' => 'WEB-100-BK',
                'variant_barcode' => '',
                'purchase_price' => '49.99',
                'selling_price' => '89.99',
                'current_stock' => '50',
                'unit_type' => 'pcs',
                'remark' => '--'
            ],
            [
                'name' => 'Wireless Earbuds',
                'sku' => 'WEB-100',
                'barcode' => '',
                'category' => '',
                'brand' => '',
                'supplier' => '',
                'description' => 'Premium wireless earbuds with charging case',
                'status' => 'active',
                'is_taxable' => '1',
                'track_inventory' => '1',
                'reorder_level' => '15',
                'variant_name' => 'White',
                'variant_sku' => 'WEB-100-WH',
                'variant_barcode' => '',
                'purchase_price' => '49.99',
                'selling_price' => '89.99',
                'current_stock' => '30',
                'unit_type' => 'pcs',
                'remark' => '--'
            ],

            // Product 2 with 2 variants (category, brand, supplier can be null)
            [
                'name' => 'Bluetooth Speaker',
                'sku' => 'BTS-200',
                'barcode' => '',
                'category' => '',
                'brand' => '',
                'supplier' => '',
                'description' => 'Portable waterproof bluetooth speaker',
                'status' => 'active',
                'is_taxable' => '1',
                'track_inventory' => '1',
                'reorder_level' => '10',
                'variant_name' => 'Black',
                'variant_sku' => 'BTS-200-BK',
                'variant_barcode' => '',
                'purchase_price' => '39.99',
                'selling_price' => '69.99',
                'current_stock' => '25',
                'unit_type' => 'pcs',
                'remark' => '--'
            ],
            [
                'name' => 'Bluetooth Speaker',
                'sku' => 'BTS-200',
                'barcode' => '',
                'category' => '',
                'brand' => '',
                'supplier' => '',
                'description' => 'Portable waterproof bluetooth speaker',
                'status' => 'active',
                'is_taxable' => '1',
                'track_inventory' => '1',
                'reorder_level' => '10',
                'variant_name' => 'Blue',
                'variant_sku' => 'BTS-200-BL',
                'variant_barcode' => '',
                'purchase_price' => '39.99',
                'selling_price' => '69.99',
                'current_stock' => '20',
                'unit_type' => 'pcs',
                'remark' => '--'
            ]
        ];

        try {
            $file = fopen($templatePath, 'w');
            if ($file === false) {
                throw new \Exception("Could not open file for writing");
            }

            fwrite($file, "\xEF\xBB\xBF"); // UTF-8 BOM
            fputcsv($file, $headers);

            foreach ($sampleProducts as $product) {
                fputcsv($file, $product);
            }

            fclose($file);

            if (!file_exists($templatePath)) {
                throw new \Exception("File was not created successfully");
            }

            return response()->download($templatePath)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to create template: ' . $e->getMessage());
        }
    }
}
