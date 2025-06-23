<!DOCTYPE html>
<html>
<head>
    <title>Products Export - Md Autos</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .page { page-break-after: always; }
        .page:last-child { page-break-after: avoid; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18px; }
        .header p { margin: 5px 0 0; color: #666; }
        .product-table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        .product-table th, 
        .product-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .product-table th { background-color: #f2f2f2; font-weight: bold; }
        .product-row { background-color: #f8f9fa; }
        .variant-table { width: 100%; border-collapse: collapse; margin: 5px 0 15px; }
        .variant-table th, 
        .variant-table td { border: 1px solid #eee; padding: 6px; text-align: left; }
        .variant-table th { background-color: #f1f1f1; }
        .no-variants { color: #999; font-style: italic; padding: 8px; }
        .badge { padding: 3px 6px; border-radius: 3px; font-size: 11px; }
        .badge-success { background-color: #28a745; color: white; }
        .badge-danger { background-color: #dc3545; color: white; }
        .badge-secondary { background-color: #6c757d; color: white; }
        .footer { margin-top: 20px; text-align: right; font-size: 10px; color: #666; }
    </style>
</head>
<body>
    @foreach($products as $product)
    <div class="page">
        <div class="header">
            <h1>Md Autos</h1>
            <p>Product Details - {{ date('Y-m-d H:i:s') }}</p>
        </div>
        
        <h2>Product Information</h2>
        <table class="product-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>SKU</th>
                    <th>Category</th>
                    <th>Brand</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr class="product-row">
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->sku }}</td>
                    <td>{{ $product->category->name ?? '-' }}</td>
                    <td>{{ $product->brand->name ?? '-' }}</td>
                    <td>
                        <span class="badge badge-{{ $product->status == 'active' ? 'success' : 'secondary' }}">
                            {{ ucfirst($product->status) }}
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
        
        @if($includeVariants)
        <h2>Product Variants</h2>
        @if($product->variants->isEmpty())
            <div class="no-variants">No variants available</div>
        @else
            <table class="variant-table">
                <thead>
                    <tr>
                        <th>Variant Name</th>
                        <th>Variant SKU</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Unit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($product->variants as $variant)
                        <tr>
                            <td>{{ $variant->name }}</td>
                            <td>{{ $variant->sku }}</td>
                            <td>{{ config('settings.currency_symbol') }}{{ number_format($variant->selling_price, 2) }}</td>
                            <td>
                                <span class="badge badge-{{ $variant->current_stock > 0 ? 'success' : 'danger' }}">
                                    {{ $variant->current_stock }}
                                </span>
                            </td>
                            <td>{{ $variant->unit_type }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        @endif
        
        <div class="footer">
            Page {{ $loop->iteration }} of {{ $loop->count }} | Generated on {{ date('Y-m-d H:i:s') }}
        </div>
    </div>
    @endforeach
</body>
</html>