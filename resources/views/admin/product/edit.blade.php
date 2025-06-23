<x-app-layout>
    @push('css')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css')}}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/dropzone/dist/dropzone.css') }}">
    @endpush

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">{{ isset($product) ? 'Edit' : 'Add' }} Product</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ isset($product) ? route('products.update', $product->id) : route('products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if(isset($product)) @method('PUT') @endif
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Product Name *</label>
                                        <input type="text" name="name" class="form-control" value="{{ old('name', $product->name ?? '') }}" required>
                                        @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>SKU *</label>
                                        <input type="text" name="sku" class="form-control" value="{{ old('sku', $product->sku ?? '') }}" required>
                                        @error('sku') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Barcode</label>
                                        <input type="text" name="barcode" class="form-control" value="{{ old('barcode', $product->barcode ?? '') }}">
                                        @error('barcode') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select name="category_id" class="selectpicker form-control" data-style="py-0">
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Brand</label>
                                        <select name="brand_id" class="selectpicker form-control" data-style="py-0">
                                            <option value="">Select Brand</option>
                                            @foreach($brands as $brand)
                                                <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id ?? '') == $brand->id ? 'selected' : '' }}>
                                                    {{ $brand->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('brand_id') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Supplier</label>
                                        <select name="supplier_id" class="selectpicker form-control" data-style="py-0">
                                            <option value="">Select Supplier</option>
                                            @foreach($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}" {{ old('supplier_id', $product->supplier_id ?? '') == $supplier->id ? 'selected' : '' }}>
                                                    {{ $supplier->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('supplier_id') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea name="description" class="form-control" rows="3">{{ old('description', $product->description ?? '') }}</textarea>
                                        @error('description') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status *</label>
                                        <select name="status" class="selectpicker form-control" data-style="py-0" required>
                                            <option value="active" {{ old('status', $product->status ?? 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ old('status', $product->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        @error('status') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Taxable</label>
                                        <select name="is_taxable" class="selectpicker form-control" data-style="py-0">
                                            <option value="1" {{ old('is_taxable', $product->is_taxable ?? 1) ? 'selected' : '' }}>Yes</option>
                                            <option value="0" {{ !old('is_taxable', $product->is_taxable ?? 1) ? 'selected' : '' }}>No</option>
                                        </select>
                                        @error('is_taxable') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Track Inventory</label>
                                        <select name="track_inventory" class="selectpicker form-control" data-style="py-0">
                                            <option value="1" {{ old('track_inventory', $product->track_inventory ?? 1) ? 'selected' : '' }}>Yes</option>
                                            <option value="0" {{ !old('track_inventory', $product->track_inventory ?? 1) ? 'selected' : '' }}>No</option>
                                        </select>
                                        @error('track_inventory') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Reorder Level</label>
                                        <input type="number" name="reorder_level" class="form-control" 
                                               value="{{ old('reorder_level', $product->reorder_level ?? 5) }}" min="0">
                                        @error('reorder_level') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Product Images</label>
                                        <div class="dropzone" id="productImagesDropzone"></div>
                                        <input type="hidden" name="image_paths" id="imagePaths" value="{{ old('image_paths', $product->image_paths ?? '') }}">
                                        @error('image_paths') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Save Product</button>
                            <a href="{{ route('products.index') }}" class="btn btn-danger">Cancel</a>
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
    
    <!-- Dropzone JavaScript -->
    <script src="{{ asset('backend/assets/vendor/dropzone/dist/dropzone.js') }}"></script>
    
    <script>
        // Initialize Dropzone for image uploads
        Dropzone.autoDiscover = false;
        
        $(document).ready(function() {
            let uploadedImages = [];
            
            // Initialize dropzone
            let myDropzone = new Dropzone("#productImagesDropzone", {
                url: "{{ route('products.upload-image') }}",
                paramName: "image",
                maxFilesize: 2, // MB
                acceptedFiles: "image/*",
                addRemoveLinks: true,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(file, response) {
                    uploadedImages.push(response.path);
                    $('#imagePaths').val(JSON.stringify(uploadedImages));
                },
                removedfile: function(file) {
                    // Remove from server
                    $.ajax({
                        url: "{{ route('products.remove-image') }}",
                        type: 'DELETE',
                        data: {
                            path: file.name,
                            _token: "{{ csrf_token() }}"
                        }
                    });
                    
                    // Remove from local array
                    const index = uploadedImages.indexOf(file.name);
                    if (index !== -1) {
                        uploadedImages.splice(index, 1);
                        $('#imagePaths').val(JSON.stringify(uploadedImages));
                    }
                    
                    // Remove preview
                    return file.previewElement.remove();
                },
                init: function() {
                    // Load existing images if editing
                    @if(isset($product) && $product->image_paths)
                        let existingImages = JSON.parse('{!! $product->image_paths !!}');
                        existingImages.forEach(function(image) {
                            let mockFile = { name: image, size: 12345 };
                            this.emit("addedfile", mockFile);
                            this.emit("thumbnail", mockFile, "{{ asset('storage') }}/" + image);
                            this.emit("complete", mockFile);
                            uploadedImages.push(image);
                        }.bind(this));
                        $('#imagePaths').val(JSON.stringify(uploadedImages));
                    @endif
                }
            });
        });
    </script>
    @endpush
</x-app-layout>