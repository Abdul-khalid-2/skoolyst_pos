<x-app-layout>
    @push('css')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css')}}">
    @endpush

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex flex-wrap flex-wrap align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="mb-3">Variants for {{ $product->name }}</h4>
                        <p class="mb-0">Manage all variants of this product. Each variant can have different<br> prices, stock levels, and other attributes.</p>
                    </div>
                    <div>
                        <a href="{{ route('products.index') }}" class="btn btn-light mr-2">
                            <i class="ri-arrow-left-line mr-1"></i> Back to Products
                        </a>
                        <a href="{{ route('product-variants.create', $product->id) }}" class="btn btn-primary add-list">
                            <i class="las la-plus mr-1"></i> Add Variant
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="table-responsive rounded mb-3">
                    <table class="data-tables table mb-0 tbl-server-info">
                        <thead class="bg-white text-uppercase">
                            <tr class="ligth ligth-data">
                                <th>Variant</th>
                                <th>SKU</th>
                                <th>Barcode</th>
                                <th>Purchase Price</th>
                                <th>Selling Price</th>
                                <th>Stock</th>
                                <th>Unit</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="ligth-body">
                            @foreach($variants as $variant)
                            <tr>
                                <td>{{ $variant->name }}</td>
                                <td>{{ $variant->sku }}</td>
                                <td>{{ $variant->barcode ?? 'N/A' }}</td>
                                <td>Rs {{ number_format($variant->purchase_price, 2) }}</td>
                                <td>Rs {{ number_format($variant->selling_price, 2) }}</td>
                                <td>{{ $variant->current_stock }}</td>
                                <td>{{ $variant->unit_type }}</td>
                                <td>
                                    <span class="badge badge-{{ $variant->status == 'active' ? 'success' : 'danger' }}">
                                        {{ ucfirst($variant->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center list-action">
                                        <a class="badge bg-success mr-2" data-toggle="tooltip"
                                            data-placement="top" title="Edit" 
                                            href="{{ route('product-variants.edit', ['product' => $product->id, 'variant' => $variant->id]) }}">
                                            <i class="ri-pencil-line mr-0"></i>
                                        </a>
                                        <form action="{{ route('product-variants.destroy', ['product' => $product->id, 'variant' => $variant->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="badge bg-warning mr-2 border-0" data-toggle="tooltip"
                                                data-placement="top" title="Delete" 
                                                onclick="return confirm('Are you sure you want to delete this variant?')">
                                                <i class="ri-delete-bin-line mr-0"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('js')
    <!-- Backend Bundle JavaScript -->
    <script src="{{ asset('backend/assets/js/backend-bundle.min.js') }}"></script>

    <!-- Table Treeview JavaScript -->
    <script src="{{ asset('backend/assets/js/table-treeview.js') }}"></script>

    <!-- Chart Custom JavaScript -->
    <script src="{{ asset('backend/assets/js/customizer.js') }}"></script>

    <!-- Chart Custom JavaScript -->
    <script async src="{{ asset('backend/assets/js/chart-custom.js') }}"></script>

    <!-- app JavaScript -->
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>
    @endpush
</x-app-layout>