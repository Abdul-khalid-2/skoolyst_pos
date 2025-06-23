<x-app-layout>
    @push('css')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css')}}">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--single {
            height: calc(2.25rem + 2px);
            padding: .375rem .75rem;
            font-size: 1rem;
            line-height: 1.5;
            border: 1px solid #ced4da;
            border-radius: .25rem;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: calc(2.25rem + 2px);
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 1.5;
        }
    </style>
    @endpush

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="card-title">New Sale</h4>
                        <a href="{{ route('sales.index') }}" class="btn btn-light">Back</a>
                    </div>
                    <div class="card-body">
                        <form id="saleForm" action="{{ route('sales.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <!-- Basic Information -->
                                 <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Invoice Number *</label>
                                        <input type="text" name="invoice_number" class="form-control"
                                            value="MD-{{ \Carbon\Carbon::now()->format('Ymd-his') }}" required readonly>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Date *</label>
                                        <input type="date" name="sale_date" class="form-control" 
                                            value="{{ date('Y-m-d') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Branch *</label>
                                        <select name="branch_id" class="form-control" required>
                                            <option value="">Select Branch</option>
                                            @foreach($branches as $branch)
                                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Customer Selection -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Customer</label>
                                        <div class="input-group">
                                            <select name="customer_id" id="customerSelect" class="form-control select2-customer">
                                                <option value="Walk-in-Customer" selected>Walk-in Customer</option>
                                                @foreach($customers as $customer)
                                                    <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->phone }})</option>
                                                @endforeach
                                            </select>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-outline-secondary" id="addCustomCustomer">
                                                    <i class="las la-user-plus"></i> New Customer
                                                </button>
                                            </div>
                                        </div>
                                        <div id="customCustomerContainer" class="mt-2" style="display: none;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="text" name="custom_customer_name" id="customCustomerName" 
                                                        class="form-control" placeholder="Customer Name">
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" name="custom_customer_phone" id="customCustomerPhone" 
                                                        class="form-control" placeholder="Phone Number">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Sale Items -->
                                <div class="col-md-12">
                                    <h5>Sale Items</h5>
                                    <div id="saleItems">
                                        <div class="row item-row mb-3">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <select name="items[0][product_id]" class="form-control product-select select2-product" required>
                                                        <option value="">Select Product</option>
                                                        @foreach($products as $product)
                                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <select name="items[0][variant_id]" class="form-control variant-select">
                                                        <option value="">Select Variant</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <input type="number" name="items[0][quantity]" class="form-control" min="1" value="1" required>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <input type="number" step="0.01" name="items[0][unit_price]" class="form-control unit-price" min="0" required>
                                                    <input type="hidden" step="0.01" name="items[0][cost_price]" class="form-control cost-price" min="0" required>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-danger remove-item">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" id="addItem" class="btn btn-primary">
                                        <i class="las la-plus mr-2"></i>Add Item
                                    </button>
                                </div>
                                <!-- Discount Field -->
                                <div class="col-md-12 mt-3">
                                    <div class="form-group">
                                        <label>Discount Amount</label>
                                        <input type="number" step="0.01" name="discount_amount" class="form-control" id="discountInput" min="0" value="0">
                                    </div>
                                </div>
                                
                                <!-- Payment Information -->
                                <div class="col-md-12 mt-4">
                                    <h5>Payment Information</h5>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Payment Method *</label>
                                                <select name="payment_method_id" class="form-control" required>
                                                    <option value="">Select Method</option>
                                                    @foreach($paymentMethods as $method)
                                                        <option value="{{ $method->id }}">{{ $method->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Amount Paid *</label>
                                                <input type="number" step="0.01" name="amount_paid" class="form-control" min="0" value="0" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Reference</label>
                                                <input type="text" name="payment_reference" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Summary -->
                                <div class="col-md-12 mt-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p><strong>Subtotal:</strong> <span id="subtotal">0.00</span></p>
                                                    <p><strong>Tax:</strong> <span id="taxAmount">0.00</span></p>
                                                    <p><strong>Discount:</strong> <span id="discountAmount">0.00</span></p>
                                                </div>
                                                <div class="col-md-4">
                                                    <p><strong>Total Amount:</strong> <span id="totalAmount">0.00</span></p>
                                                    <p><strong>Amount Paid:</strong> <span id="displayAmountPaid">0.00</span></p>
                                                    <p><strong>Change Due:</strong> <span id="changeAmount">0.00</span></p>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Notes</label>
                                                        <textarea name="notes" class="form-control" rows="3"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-12 mt-3">
                                    <button type="submit" class="btn btn-primary">Complete Sale</button>
                                    <a href="{{ route('sales.index') }}" class="btn btn-light">Cancel</a>
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
    
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @endpush
    @push('js')
    <script>
    $(document).ready(function() {
        let itemCount = 1;
        
        // Initialize Select2 for customer dropdown
        $('.select2-customer').select2({
            placeholder: "Search customer...",
            allowClear: false
        });
        
        // Initialize Select2 for product dropdowns
        $('.select2-product').select2({
            placeholder: "Search product...",
            allowClear: true
        });
        
        // Toggle custom customer fields
        $('#addCustomCustomer').click(function() {
            $('#customCustomerContainer').toggle();
            if ($('#customCustomerContainer').is(':visible')) {
                $(this).html('<i class="las la-user-minus"></i> Cancel');
                // Set to Walk-in Customer when showing custom fields
                $('#customerSelect').val('Walk-in-Customer').trigger('change');
            } else {
                $(this).html('<i class="las la-user-plus"></i> New Customer');
                $('#customCustomerName').val('');
                $('#customCustomerPhone').val('');
            }
        });
        
        // When customer is selected, hide custom fields
        $('#customerSelect').on('change', function() {
            if ($(this).val() !== 'Walk-in-Customer') {
                $('#customCustomerContainer').hide();
                $('#addCustomCustomer').html('<i class="las la-user-plus"></i> New Customer');
                $('#customCustomerName').val('');
                $('#customCustomerPhone').val('');
            }
        });
        
        // Add new item row
        $('#addItem').click(function() {
            const newRow = `
                <div class="row item-row mb-3">
                    <div class="col-md-5">
                        <div class="form-group">
                            <select name="items[${itemCount}][product_id]" class="form-control product-select select2-product" required>
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
                    <div class="col-md-1">
                        <div class="form-group">
                            <input type="number" name="items[${itemCount}][quantity]" class="form-control" min="1" value="1" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="number" step="0.01" name="items[${itemCount}][unit_price]" class="form-control unit-price" min="0" required>
                            <input type="hidden" name="items[${itemCount}][cost_price]" class="cost-price">
                        </div>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger remove-item">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </div>
                </div>`;
            
            $('#saleItems').append(newRow);
            
            // Initialize Select2 for the new product dropdown
            $('#saleItems .item-row:last .product-select').select2({
                placeholder: "Search product...",
                allowClear: true
            });
            
            itemCount++;
        });
        
        // Remove item row
        $(document).on('click', '.remove-item', function() {
            if ($('.item-row').length > 1) {
                $(this).closest('.item-row').remove();
                calculateTotals();
            }
        });
        
        // Load variants when product changes
        $(document).on('change', '.product-select', function() {
            const productId = $(this).val();
            const variantSelect = $(this).closest('.item-row').find('.variant-select');
            const unitPriceInput = $(this).closest('.item-row').find('.unit-price');
            
            if (productId) {
               $.get(`/inventory-logs/variants/${productId}`, function(variants) {
                    variantSelect.empty().append('<option value="">Select Variant</option>');
                    
                    variants.forEach(variant => {
                        variantSelect.append(`<option value="${variant.id}" data-price="${variant.selling_price}" data-cost="${variant.purchase_price}">${variant.name} (${variant.sku}) - Stock: ${variant.current_stock}</option>`);
                    });
                    
                    // If there's only one variant, select it by default
                    if (variants.length === 1) {
                        variantSelect.val(variants[0].id).trigger('change');
                    }
                });
            } else {
                variantSelect.empty().append('<option value="">Select Variant</option>');
                unitPriceInput.val('');
            }
        });
        
        // Set unit price when variant changes
        $(document).on('change', '.variant-select', function() {
            const selectedOption = $(this).find('option:selected');
            const unitPriceInput = $(this).closest('.item-row').find('input[name*="unit_price"]');
            const costPriceInput = $(this).closest('.item-row').find('input[name*="cost_price"]');
            
            if (selectedOption.data('price')) {
                unitPriceInput.val(selectedOption.data('price'));
                costPriceInput.val(selectedOption.data('cost'));
            } else {
                unitPriceInput.val('');
                costPriceInput.val('');
            }
            
            calculateTotals();
        });
        
        // Calculate totals when quantity, price or discount changes
        $(document).on('input', 'input[name*="quantity"], input[name*="unit_price"], #discountInput', function() {
            calculateTotals();
        });
        
        // Update display when amount paid changes
        $('input[name="amount_paid"]').on('input', function() {
            const amountPaid = parseFloat($(this).val()) || 0;
            const totalAmount = parseFloat($('#totalAmount').text()) || 0;
            const changeDue = Math.max(0, amountPaid - totalAmount);
            
            $('#displayAmountPaid').text(amountPaid.toFixed(2));
            $('#changeAmount').text(changeDue.toFixed(2));
        });
        
        // Calculate all totals
        function calculateTotals() {
            let subtotal = 0;
            let taxAmount = 0;
            
            $('.item-row').each(function() {
                const quantity = parseFloat($(this).find('input[name*="quantity"]').val()) || 0;
                const unitPrice = parseFloat($(this).find('input[name*="unit_price"]').val()) || 0;
                const itemTotal = quantity * unitPrice;
                subtotal += itemTotal;
            });
            
            const discountAmount = parseFloat($('#discountInput').val()) || 0;
            const totalAmount = subtotal + taxAmount - discountAmount;
            const amountPaid = parseFloat($('input[name="amount_paid"]').val()) || 0;
            const changeDue = Math.max(0, amountPaid - totalAmount);
            
            $('#subtotal').text(subtotal.toFixed(2));
            $('#taxAmount').text(taxAmount.toFixed(2));
            $('#discountAmount').text(discountAmount.toFixed(2));
            $('#totalAmount').text(totalAmount.toFixed(2));
            $('#changeAmount').text(changeDue.toFixed(2));
        }
        
        // Form submission handling
        $('#saleForm').on('submit', function(e) {
            // If custom customer is being used and has a name
            if ($('#customCustomerContainer').is(':visible') && $('#customCustomerName').val()) {
                // Ensure customer_id is set to Walk-in-Customer
                $('#customerSelect').val('Walk-in-Customer').prop('disabled', false);
            }
        });
    });
    </script>
    @endpush
</x-app-layout>