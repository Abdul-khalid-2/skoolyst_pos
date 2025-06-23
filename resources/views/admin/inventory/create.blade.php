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
                            <h4 class="card-title">Add Inventory Adjustment</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('inventory-logs.store') }}" method="POST">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Product *</label>
                                        <select name="product_id" id="product-select" class="selectpicker form-control" data-style="py-0" required>
                                            <option value="">Select Product</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('product_id') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Variant *</label>
                                        <select name="variant_id" id="variant-select" class="selectpicker form-control" data-style="py-0" required disabled>
                                            <option value="">Select Variant</option>
                                        </select>
                                        @error('variant_id') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Branch *</label>
                                        <select name="branch_id" class="selectpicker form-control" data-style="py-0" required>
                                            <option value="">Select Branch</option>
                                            @foreach($branches as $branch)
                                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('branch_id') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Adjustment Type *</label>
                                        <select name="quantity_change_type" id="quantity-change-type" class="selectpicker form-control" data-style="py-0" required>
                                            <option value="add">Add Stock</option>
                                            <option value="remove">Remove Stock</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Quantity *</label>
                                        <input type="number" name="quantity_change" class="form-control" min="1" value="1" required>
                                        @error('quantity_change') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Reference Type *</label>
                                        <select name="reference_type" class="selectpicker form-control" data-style="py-0" required>
                                            <option value="manual">Manual Adjustment</option>
                                            <option value="purchase">Purchase</option>
                                            <option value="sale">Sale</option>
                                            <option value="return">Return</option>
                                            <option value="damage">Damage</option>
                                        </select>
                                        @error('reference_type') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6" id="reference-id-container" style="display: none;">
                                    <div class="form-group">
                                        <label>Reference ID</label>
                                        <input type="number" name="reference_id" class="form-control">
                                        @error('reference_id') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Notes</label>
                                        <textarea name="notes" class="form-control" rows="3"></textarea>
                                        @error('notes') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Save Adjustment</button>
                            <a href="{{ route('inventory-logs.index') }}" class="btn btn-danger">Cancel</a>
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
    

    <script>
        $(document).ready(function() {
            // Load variants when product is selected
            $('#product-select').change(function() {
                const productId = $(this).val();
                const variantSelect = $('#variant-select');
                
                if (productId) {
                    $.get(`/inventory-logs/variants/${productId}`, function(variants) {
                        variantSelect.empty().append('<option value="">Select Variant</option>');
                        
                        variants.forEach(variant => {
                            variantSelect.append(`<option value="${variant.id}">${variant.name} (${variant.sku}) - Stock: ${variant.current_stock}</option>`);
                        });
                        
                        variantSelect.prop('disabled', false).selectpicker('refresh');
                    });
                } else {
                    variantSelect.empty().append('<option value="">Select Variant</option>')
                        .prop('disabled', true).selectpicker('refresh');
                }
            });

            // Show/hide reference ID field based on reference type
            $('select[name="reference_type"]').change(function() {
                if ($(this).val() === 'manual') {
                    $('#reference-id-container').hide();
                } else {
                    $('#reference-id-container').show();
                }
            });

            // Set quantity change value based on type
            $('#quantity-change-type').change(function() {
                const quantityInput = $('input[name="quantity_change"]');
                if ($(this).val() === 'remove') {
                    quantityInput.attr('max', '');
                } else {
                    quantityInput.attr('max', '');
                }
            });
        });
    </script>
    @endpush
</x-app-layout>