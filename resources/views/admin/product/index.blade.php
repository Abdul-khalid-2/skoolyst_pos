<x-app-layout>
    @push('css')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css"/>

    @endpush

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex flex-wrap flex-wrap align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="mb-3">Product List</h4>
                        <p class="mb-0">Manage all your products in one place. Track inventory, prices, and variants<br> for effective stock management and sales.</p>
                    </div>
                    <a href="{{ route('products.create') }}" class="btn btn-primary add-list"><i class="las la-plus mr-3"></i>Add Product</a>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="table-responsive rounded mb-3">
                    <table class="data-tables table mb-0 tbl-server-info">
                        <thead class="bg-white text-uppercase">
                            <tr class="ligth ligth-data">
                                <th>
                                    <div class="checkbox d-inline-block">
                                        <input type="checkbox" class="checkbox-input" id="select-all">
                                        <label for="select-all" class="mb-0"></label>
                                    </div>
                                </th>
                                <th>Product</th>
                                <th>SKU</th>
                                <th>Category</th>
                                <th>Brand</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="ligth-body">
                            @foreach($products as $product)
                            <tr>
                                <td>
                                    <div class="checkbox d-inline-block">
                                        <input type="checkbox" class="checkbox-input" id="product-{{ $product->id }}">
                                        <label for="product-{{ $product->id }}" class="mb-0"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($product->image_paths)
                                            @php
                                                $images = json_decode($product->image_paths);
                                                $firstImage = $images[0] ?? null;
                                            @endphp
                                            <img src="{{ asset('backend/'.$firstImage) }}" class="img-fluid rounded avatar-50 mr-3" alt="{{ $product->name }}">
                                        @else
                                            <div class="avatar-50 mr-3 bg-primary rounded-circle d-flex align-items-center justify-content-center">
                                                <span class="text-white">{{ strtoupper(substr($product->name, 0, 1)) }}</span>
                                            </div>
                                        @endif
                                        <div>
                                            {{ $product->name }}
                                            <p class="mb-0"><small>{{ $product->variants_count }} variants</small></p>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $product->sku }}</td>
                                <td>{{ $product->category->name ?? 'N/A' }}</td>
                                <td>{{ $product->brand->name ?? 'N/A' }}</td>
                                <td>
                                    @if($product->variants_count > 0)
                                        Rs {{ number_format($product->variants->min('selling_price'), 2) }} - Rs {{ number_format($product->variants->max('selling_price'), 2) }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if($product->track_inventory)
                                        {{ $product->variants->sum('current_stock') }} in stock
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-{{ $product->status == 'active' ? 'success' : 'danger' }}">
                                        {{ ucfirst($product->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center list-action">
                                        <a class="badge badge-info mr-2" data-toggle="tooltip" data-placement="top" title="View" 
                                           href="{{ route('products.show', $product->id) }}">
                                            <i class="ri-eye-line mr-0"></i>
                                        </a>
                                        <a class="badge bg-success mr-2" data-toggle="tooltip" data-placement="top" title="Edit" 
                                           href="{{ route('products.edit', $product->id) }}">
                                            <i class="ri-pencil-line mr-0"></i>
                                        </a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="badge bg-warning mr-2 border-0" data-toggle="tooltip"
                                                data-placement="top" title="Delete" onclick="return confirm('Are you sure? All variants will be deleted too.')">
                                                <i class="ri-delete-bin-line mr-0"></i>
                                            </button>
                                        </form>
                                        <a class="badge bg-secondary" data-toggle="tooltip" data-placement="top" title="variant" 
                                           href="{{ route('product-variants.index', $product->id) }}">
                                            <i class="ri-store-2-line mr-0"></i>
                                        </a>
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
    
    <script>
        $(document).ready(function() {
            // Bulk actions
            $('#select-all').change(function() {
                $('.checkbox-input').prop('checked', $(this).prop('checked'));
            });
            
            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    @endpush
</x-app-layout>