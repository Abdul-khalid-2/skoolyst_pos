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
        $request->validate([
            'import_file' => 'required|file|mimes:csv,txt,xlsx|max:2048'
        ]);

        try {
            $import = new ProductsImport();
            Excel::import($import, $request->file('import_file'));

            $importedCount = $import->getRowCount();
            $skippedCount = $import->getSkippedCount();

            $message = "Successfully imported {$importedCount} products.";
            if ($skippedCount > 0) {
                $message .= " {$skippedCount} rows were skipped due to errors.";
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
        $templatePath = storage_path('app/public/templates/products_import_template.csv');

        if (!file_exists($templatePath)) {
            \Storage::makeDirectory('public/templates');

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
                'weight'
            ];

            $template = fopen($templatePath, 'w');
            fputcsv($template, $headers);

            // Add sample data
            $sampleData = [
                'Sample Product',
                'PROD001',
                '123456789',
                'Electronics',
                'Brand A',
                'Supplier X',
                'Sample product description',
                'active',
                '1',
                '1',
                '5',
                'Variant 1',
                'PROD001-V1',
                '987654321',
                '10.00',
                '15.00',
                '100',
                'pcs',
                '0.5'
            ];
            fputcsv($template, $sampleData);

            fclose($template);
        }

        return response()->download($templatePath)->deleteFileAfterSend(true);
    }
}
