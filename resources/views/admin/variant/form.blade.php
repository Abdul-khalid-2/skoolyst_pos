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
                            <h4 class="card-title">
                                {{ isset($variant) ? 'Edit' : 'Add' }} Variant for {{ $product->name }}
                            </h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ isset($variant) ? route('product-variants.update', ['product' => $product->id, 'variant' => $variant->id]) : route('product-variants.store', $product->id) }}" method="POST">
                            @csrf
                            @if(isset($variant)) @method('PUT') @endif
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Variant Name *</label>
                                        <input type="text" name="name" class="form-control" 
                                               value="{{ old('name', $variant->name ?? '') }}" required>
                                        @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>SKU *</label>
                                        <input type="text" name="sku" class="form-control" 
                                               value="{{ old('sku', $variant->sku ?? '') }}" required>
                                        @error('sku') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Barcode</label>
                                        <input type="text" name="barcode" class="form-control" 
                                               value="{{ old('barcode', $variant->barcode ?? '') }}">
                                        @error('barcode') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Purchase Price *</label>
                                        <input type="number" step="0.01" name="purchase_price" class="form-control" 
                                               value="{{ old('purchase_price', $variant->purchase_price ?? 0) }}" required>
                                        @error('purchase_price') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Selling Price *</label>
                                        <input type="number" step="0.01" name="selling_price" class="form-control" 
                                               value="{{ old('selling_price', $variant->selling_price ?? 0) }}" required>
                                        @error('selling_price') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Current Stock *</label>
                                        <input type="number" name="current_stock" class="form-control" 
                                               value="{{ old('current_stock', $variant->current_stock ?? 0) }}" required>
                                        @error('current_stock') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Unit Type *</label>
                                        <select name="unit_type" class="selectpicker form-control" data-style="py-0" required>
                                            <option value="pcs" {{ old('unit_type', $variant->unit_type ?? 'pcs') == 'pcs' ? 'selected' : '' }}>Pieces</option>
                                            <option value="kg" {{ old('unit_type', $variant->unit_type ?? '') == 'kg' ? 'selected' : '' }}>Kilograms</option>
                                            <option value="g" {{ old('unit_type', $variant->unit_type ?? '') == 'g' ? 'selected' : '' }}>Grams</option>
                                            <option value="l" {{ old('unit_type', $variant->unit_type ?? '') == 'l' ? 'selected' : '' }}>Liters</option>
                                            <option value="ml" {{ old('unit_type', $variant->unit_type ?? '') == 'ml' ? 'selected' : '' }}>Milliliters</option>
                                            <option value="m" {{ old('unit_type', $variant->unit_type ?? '') == 'm' ? 'selected' : '' }}>Meters</option>
                                        </select>
                                        @error('unit_type') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Weight (kg)</label>
                                        <input type="number" step="0.001" name="weight" class="form-control" 
                                               value="{{ old('weight', $variant->weight ?? '') }}">
                                        @error('weight') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status *</label>
                                        <select name="status" class="selectpicker form-control" data-style="py-0" required>
                                            <option value="active" {{ old('status', $variant->status ?? 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ old('status', $variant->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        @error('status') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">
                                {{ isset($variant) ? 'Update' : 'Save' }} Variant
                            </button>
                            
                            <a href="{{ route('product-variants.index', $product->id) }}" class="btn btn-danger">
                                Cancel
                            </a>
                        </form>
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

    <!-- Chart Custom JavaScript -->
    <script async src="{{ asset('backend/assets/js/chart-custom.js') }}"></script>

    <!-- app JavaScript -->
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>
    @endpush
</x-app-layout>