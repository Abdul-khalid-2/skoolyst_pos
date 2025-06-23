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
                        <h4 class="card-title">Edit Sale #{{ $sale->invoice_number }}</h4>
                        <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-light">Cancel</a>
                    </div>
                    <div class="card-body">
                        <form id="saleForm" action="{{ route('sales.update', $sale->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <!-- Basic Information -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Invoice Number *</label>
                                        <input type="text" name="invoice_number" class="form-control"
                                            value="{{ $sale->invoice_number }}" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Date *</label>
                                        <input type="date" name="sale_date" class="form-control" 
                                            value="{{ $sale->sale_date->format('Y-m-d') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Branch *</label>
                                        <select name="branch_id" class="form-control" required>
                                            <option value="">Select Branch</option>
                                            @foreach($branches as $branch)
                                                <option value="{{ $branch->id }}" {{ $sale->branch_id == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Customer Selection -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Customer</label>
                                        <select name="customer_id" class="form-control">
                                            <option value="">Walk-in Customer</option>
                                            @foreach($customers as $customer)
                                                <option value="{{ $customer->id }}" {{ $sale->customer_id == $customer->id ? 'selected' : '' }}>
                                                    {{ $customer->name }} ({{ $customer->phone }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Sale Items -->
                                <div class="col-md-12">
                                    <h5>Sale Items</h5>
                                    <div id="saleItems">
                                        @foreach($sale->items as $index => $item)
                                        <div class="row item-row mb-3">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <select name="items[{{ $index }}][product_id]" class="form-control product-select" required>
                                                        <option value="">Select Product</option>
                                                        @foreach($products as $product)
                                                            <option value="{{ $product->id }}" 
                                                                {{ $item->product_id == $product->id ? 'selected' : '' }}>
                                                                {{ $product->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <select name="items[{{ $index }}][variant_id]" class="form-control variant-select">
                                                        <option value="">Select Variant</option>
                                                        @if($item->variant_id)
                                                            @foreach($item->product->variants as $variant)
                                                                <option value="{{ $variant->id }}" 
                                                                    {{ $item->variant_id == $variant->id ? 'selected' : '' }}
                                                                    data-price="{{ $variant->selling_price }}"
                                                                    data-cost="{{ $variant->purchase_price }}">
                                                                    {{ $variant->name }} ({{ $variant->sku }}) - Stock: {{ $variant->current_stock }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <input type="number" name="items[{{ $index }}][quantity]" class="form-control" 
                                                        min="1" value="{{ $item->quantity }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <input type="number" step="0.01" name="items[{{ $index }}][unit_price]" 
                                                        class="form-control unit-price" min="0" value="{{ $item->unit_price }}" required>
                                                    <input type="hidden" name="items[{{ $index }}][cost_price]" 
                                                        class="cost-price" value="{{ $item->cost_price }}">
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-danger remove-item">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <button type="button" id="addItem" class="btn btn-primary">
                                        <i class="las la-plus mr-2"></i>Add Item
                                    </button>
                                </div>
                                
                                <!-- Discount Field -->
                                <div class="col-md-12 mt-3">
                                    <div class="form-group">
                                        <label>Discount Amount</label>
                                        <input type="number" step="0.01" name="discount_amount" class="form-control" 
                                            id="discountInput" min="0" value="{{ $sale->discount_amount }}">
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
                                                        <option value="{{ $method->id }}" 
                                                            {{ $sale->payments->first() && $sale->payments->first()->payment_method_id == $method->id ? 'selected' : '' }}>
                                                            {{ $method->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Amount Paid *</label>
                                                <input type="number" step="0.01" name="amount_paid" class="form-control" 
                                                    min="0" value="{{ $sale->amount_paid }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Reference</label>
                                                <input type="text" name="payment_reference" class="form-control"
                                                    value="{{ $sale->payments->first() ? $sale->payments->first()->reference : '' }}">
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
                                                    <p><strong>Subtotal:</strong> <span id="subtotal">{{ number_format($sale->subtotal, 2) }}</span></p>
                                                    <p><strong>Tax:</strong> <span id="taxAmount">{{ number_format($sale->tax_amount, 2) }}</span></p>
                                                    <p><strong>Discount:</strong> <span id="discountAmount">{{ number_format($sale->discount_amount, 2) }}</span></p>
                                                </div>
                                                <div class="col-md-4">
                                                    <p><strong>Total Amount:</strong> <span id="totalAmount">{{ number_format($sale->total_amount, 2) }}</span></p>
                                                    <p><strong>Amount Paid:</strong> <span id="displayAmountPaid">{{ number_format($sale->amount_paid, 2) }}</span></p>
                                                    <p><strong>Change Due:</strong> <span id="changeAmount">{{ number_format($sale->change_amount, 2) }}</span></p>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Notes</label>
                                                        <textarea name="notes" class="form-control" rows="3">{{ $sale->notes }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-12 mt-3">
                                    <button type="submit" class="btn btn-primary">Update Sale</button>
                                    <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-light">Cancel</a>
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
        let itemCount = {{ count($sale->items) }};
        
        // Add new item row
        $('#addItem').click(function() {
            const newRow = `
                <div class="row item-row mb-3">
                    <div class="col-md-5">
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
            const costPriceInput = $(this).closest('.item-row').find('.cost-price');
            
            if (productId) {
                $.get(`/inventory-logs/variants/${productId}`, function(variants) {
                    variantSelect.empty().append('<option value="">Select Variant</option>');
                    
                    variants.forEach(variant => {
                        variantSelect.append(`<option value="${variant.id}" 
                            data-price="${variant.selling_price}" 
                            data-cost="${variant.purchase_price}">
                            ${variant.name} (${variant.sku}) - Stock: ${variant.current_stock}
                        </option>`);
                    });
                    
                    // If there's only one variant, select it by default
                    if (variants.length === 1) {
                        variantSelect.val(variants[0].id).trigger('change');
                    }
                });
            } else {
                variantSelect.empty().append('<option value="">Select Variant</option>');
                unitPriceInput.val('');
                costPriceInput.val('');
            }
        });
        
        // Set unit price when variant changes
        $(document).on('change', '.variant-select', function() {
            const selectedOption = $(this).find('option:selected');
            const unitPriceInput = $(this).closest('.item-row').find('.unit-price');
            const costPriceInput = $(this).closest('.item-row').find('.cost-price');
            
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
    });
    </script>
    @endpush
</x-app-layout>