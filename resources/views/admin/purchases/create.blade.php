
<x-app-layout>

    @push('css')
        <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.ico') }}" />
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet"
            href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css') }}">
    @endpush

    <div class="container-fluid add-form-list">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Create Purchase Order</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('purchases.store') }}" method="POST" id="purchaseForm">
                            @csrf
                            <div class="row">
                                <!-- Branch Selection -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Branch *</label>
                                        <select name="branch_id" class="form-control selectpicker" required>
                                            <option value="">Select Branch</option>
                                            @foreach($branches as $branch)
                                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Supplier Selection -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Supplier *</label>
                                        <select name="supplier_id" class="form-control selectpicker" required>
                                            <option value="">Select Supplier</option>
                                            @foreach($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Invoice Number (auto-generated but editable) -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Invoice Number *</label>
                                        <input type="text" name="invoice_number" class="form-control" 
                                            value="{{ $invoiceNumber }}" required>
                                    </div>
                                </div>
                                
                                <!-- Dates -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Purchase Date *</label>
                                        <input type="date" name="purchase_date" class="form-control" 
                                            value="{{ date('Y-m-d') }}" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Expected Delivery Date</label>
                                        <input type="date" name="expected_delivery_date" class="form-control">
                                    </div>
                                </div>
                                
                                <!-- Additional Costs -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Shipping Amount</label>
                                        <input type="number" step="0.01" name="shipping_amount" 
                                            class="form-control" min="0" value="0">
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Tax Amount</label>
                                        <input type="number" step="0.01" name="tax_amount" 
                                            class="form-control" min="0" value="0">
                                    </div>
                                </div>
                                
                                <!-- Purchase Items Section -->
                                <div class="col-md-12">
                                    <h5>Purchase Items</h5>
                                    <div id="purchaseItems">
                                        <div class="row item-row mb-3">
                                            <!-- Product, Variant, Qty, Price fields as before -->
                                        </div>
                                    </div>
                                    <button type="button" id="addItem" class="btn btn-primary">Add Item</button>
                                </div>
                                
                                <!-- Notes -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Notes</label>
                                        <textarea name="notes" class="form-control" rows="3"></textarea>
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary mr-2">Submit Purchase</button>
                                    <a href="{{ route('purchases.index') }}" class="btn btn-light">Cancel</a>
                                </div>
                            </div>
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
    @push('js')
        <script>
            $(document).ready(function() {
                let itemCount = 1;
                
                // Add new item row
                $('#addItem').click(function() {
                    const newRow = `
                        <div class="row item-row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select name="items[${itemCount}][product_id]" class="form-control product-select" required>
                                        <option value="">Select Product</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="items[${itemCount}][variant_id]" class="form-control variant-select">
                                        <option value="">Select Variant</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="number" name="items[${itemCount}][quantity]" class="form-control" min="1" value="1" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="number" step="0.01" name="items[${itemCount}][unit_price]" class="form-control" min="0" required placeholder="Unit price">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger remove-item" style="margin-top: 30px;">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        </div>`;
                    
                    $('#purchaseItems').append(newRow);
                    itemCount++;
                });
                
                // Remove item row
                $(document).on('click', '.remove-item', function() {
                    if ($('.item-row').length > 1) {
                        $(this).closest('.item-row').remove();
                        // Reindex items if needed
                    }
                });
                
                // Load variants when product changes
                $(document).on('change', '.product-select', function() {
                    const productId = $(this).val();
                    const variantSelect = $(this).closest('.item-row').find('.variant-select');
                    
                    if (productId) {
                        $.get(`/inventory-logs/variants/${productId}`, function(variants) {
                            variantSelect.empty().append('<option value="">Select Variant</option>');
                            
                            variants.forEach(variant => {
                                variantSelect.append(`<option value="${variant.id}">${variant.name} (${variant.sku}) - Stock: ${variant.current_stock}</option>`);
                            });
                        });
                    } else {
                        variantSelect.empty().append('<option value="">Select Variant</option>')
                            .prop('disabled', true).selectpicker('refresh');
                    }
                });
            });
        </script>
    @endpush
    
</x-app-layout>