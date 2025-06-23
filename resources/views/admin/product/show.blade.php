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
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Product Details: {{ $product->name }}</h4>
                        </div>
                        <div>
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-primary">
                                <i class="ri-edit-line"></i> Edit
                            </a>
                            <a href="{{ route('products.index') }}" class="btn btn-sm btn-secondary">
                                <i class="ri-arrow-left-line"></i> Back to List
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Product Images -->
                            <div class="col-md-4">
                                <div class="product-images">
                                    <h5>Product Images</h5>
                                    @if($product->image_paths)
                                        @php $images = json_decode($product->image_paths) @endphp
                                        <div class="row">
                                            @foreach($images as $image)
                                                <div class="col-6 mb-3">
                                                    <img src="{{ asset('storage/'.$image) }}" alt="Product Image" class="img-fluid rounded">
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="alert alert-info">No images available</div>
                                    @endif
                                </div>

                                <!-- Basic Info Card -->
                                <div class="card mt-4">
                                    <div class="card-header">
                                        <h5>Basic Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <span>Status</span>
                                                <span class="badge bg-{{ $product->status == 'active' ? 'success' : 'danger' }}">
                                                    {{ ucfirst($product->status) }}
                                                </span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <span>SKU</span>
                                                <span>{{ $product->sku }}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <span>Barcode</span>
                                                <span>{{ $product->barcode ?? 'N/A' }}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <span>Taxable</span>
                                                <span>{{ $product->is_taxable ? 'Yes' : 'No' }}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <span>Inventory Tracking</span>
                                                <span>{{ $product->track_inventory ? 'Enabled' : 'Disabled' }}</span>
                                            </li>
                                            @if($product->track_inventory)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <span>Reorder Level</span>
                                                <span>{{ $product->reorder_level }}</span>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Product Details -->
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Product Details</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <h6>Category</h6>
                                                <p>{{ $product->category->name ?? 'N/A' }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <h6>Brand</h6>
                                                <p>{{ $product->brand->name ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <h6>Supplier</h6>
                                                <p>{{ $product->supplier->name ?? 'N/A' }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <h6>Created At</h6>
                                                <p>{{ $product->created_at->format('M d, Y H:i') }}</p>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <h6>Description</h6>
                                            <p>{{ $product->description ?? 'No description available' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Variants Section -->
                                <div class="card mt-4">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5>Product Variants</h5>
                                        <a href="{{ route('product-variants.create', $product->id) }}" 
                                           class="btn btn-sm btn-primary">
                                            <i class="ri-add-line"></i> Add Variant
                                        </a>
                                    </div>
                                    
                                    <div class="card-body">
                                        @if($product->variants->count() > 0)
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>SKU</th>
                                                            <th>Price</th>
                                                            <th>Stock</th>
                                                            <th>Status</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($product->variants as $variant)
                                                        <tr>
                                                            <td>{{ $variant->name }}</td>
                                                            <td>{{ $variant->sku }}</td>
                                                            <td>{{ format_currency($variant->selling_price) }}</td>
                                                            <td>{{ $variant->current_stock }}</td>
                                                            <td>
                                                                <span class="badge bg-{{ $variant->status == 'active' ? 'success' : 'danger' }}">
                                                                    {{ ucfirst($variant->status) }}
                                                                </span>
                                                            </td>
                                                            <!-- <td>
                                                                <div class="d-flex gap-2">
                                                                    <a href=" {{ route('product-variants.edit', ['product' => $product->id, 'variant' => $variant->id]) }}" 
                                                                       class="btn btn-sm btn-outline-primary">
                                                                        <i class="ri-edit-line"></i>
                                                                    </a>
                                                                    <form action="{{ route('product-variants.destroy', $variant->id) }}" 
                                                                          method="POST" class="d-inline">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                                                onclick="return confirm('Are you sure?')">
                                                                            <i class="ri-delete-bin-line"></i>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </td> -->
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
                                        @else
                                            <div class="alert alert-info">No variants found for this product.</div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Inventory History -->
                                <div class="card mt-4">
                                    <div class="card-header">
                                        <h5>Inventory History</h5>
                                    </div>
                                    <div class="card-body">
                                        @if($product->inventoryLogs->count() > 0)
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Variant</th>
                                                            <th>Change</th>
                                                            <th>New Qty</th>
                                                            <th>Reference</th>
                                                            <th>User</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($product->inventoryLogs->take(5) as $log)
                                                        <tr>
                                                            <td>{{ $log->created_at->format('M d, Y H:i') }}</td>
                                                            <td>{{ $log->variant->name ? $log->variant->name .' ('. $log->variant->sku .') ' : 'N/A' }}</td>
                                                            <td class="{{ $log->quantity_change > 0 ? 'text-success' : 'text-danger' }}">
                                                                {{ $log->quantity_change > 0 ? '+' : '' }}{{ $log->quantity_change }}
                                                            </td>
                                                            <td>{{ $log->new_quantity }}</td>
                                                            <td>
                                                                @if($log->reference_type)
                                                                    {{ class_basename($log->reference_type) }} #{{ $log->reference_id }}
                                                                @else
                                                                    Manual
                                                                @endif
                                                            </td>
                                                            <td>{{ $log->user->name ?? 'System' }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            @if($product->inventoryLogs->count() > 5)
                                                <div class="text-center mt-2">
                                                    <a href="{{ route('products.inventory-history', $product->id) }}" 
                                                       class="btn btn-sm btn-outline-primary">
                                                        View All History
                                                    </a>
                                                </div>
                                            @endif
                                        @else
                                            <div class="alert alert-info">No inventory history available.</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
    <!-- app JavaScript -->
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>
    @endpush
</x-app-layout>