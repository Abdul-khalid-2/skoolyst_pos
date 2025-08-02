<x-app-layout>
    @push('css')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css')}}">
    
    <!-- Reuse POS styles with some modifications -->
    <style>
        .pos-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            height: auto;
        }
        .product-area, .cart-container {
            width: 100%;
        }
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 10px;
            overflow-y: auto;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 5px;
            max-height: 400px;
        }        
        .product-card {
            background: white;
            border-radius: 5px;
            padding: 5px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            border: 1px solid #e9ecef;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }        
        .product-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }        
        .product-card img {
            max-width: 100%;
            width:100%;
            height:150px
        }
        .cart-container {
            background: white;
            border-radius: 5px;
            padding: 15px;
            display: flex;
            flex-direction: column;
            height: auto;
        }        
        .cart-items {
            flex-grow: 1;
            overflow-y: auto;
            margin-bottom: 15px;
            max-height: 300px;
        }        
        .cart-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
            flex-wrap: wrap;
            gap: 5px;
        }        
        .cart-item-controls {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
        }        
        .cart-item-controls input {
            width: 50px;
            text-align: center;
            margin: 0 5px;
        }
        
        /* Order-specific styles */
        .order-status-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 0.8rem;
            padding: 3px 8px;
            border-radius: 4px;
        }
        .status-draft {
            background-color: #6c757d;
            color: white;
        }
        .status-confirmed {
            background-color: #0dcaf0;
            color: white;
        }
        .status-completed {
            background-color: #198754;
            color: white;
        }
        .status-cancelled {
            background-color: #dc3545;
            color: white;
        }
        .order-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }
        
        @media (min-width: 992px) {
            .pos-container {
                flex-direction: row;
            }            
            .product-area {
                width: 70%;
            }            
            .cart-container {
                width: 30%;
                height: 100%;
            }            
            .product-grid {
                max-height: calc(100vh - 280px);
            }            
            .cart-items {
                max-height: calc(100vh - 550px);
            }
        }
        
        /* Add all other responsive styles from your POS */
    </style>
    @endpush

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="card-title">Create New Order</h4>
                        <div>
                            <span class="badge bg-primary me-2">Branch: {{ $currentBranch->name ?? 'Not Selected' }}</span>
                            <span class="badge bg-secondary">User: {{ auth()->user()->name }}</span>
                            @if(isset($order))
                            <span class="order-status-badge status-{{ $order->status }}">
                                {{ ucfirst($order->status) }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="orderForm" method="POST" 
                            action="{{ isset($order) ? route('orders.update', $order) : route('orders.store') }}">
                            @csrf
                            @if(isset($order))
                                @method('PUT')
                            @endif
                            
                            <input type="hidden" name="order_number" 
                                value="{{ isset($order) ? $order->order_number : 'ORD-'.\Carbon\Carbon::now()->format('Ymd-his') }}">
                            <input type="hidden" name="branch_id" value="{{ $currentBranch->id ?? '' }}">
                            
                            <!-- Hidden fields for summary data -->
                            <input type="hidden" name="subtotal" id="formSubtotal" value="0">
                            <input type="hidden" name="tax_amount" id="formTaxAmount" value="0">
                            <input type="hidden" name="discount_amount" id="formDiscountAmount" value="0">
                            <input type="hidden" name="total_amount" id="formTotalAmount" value="0">
                            <input type="hidden" name="customer_id" id="formCustomerId" value="0">
                            <input type="hidden" name="status" id="formStatus" value="{{ isset($order) ? $order->status : 'draft' }}">
                            <input type="hidden" name="storage_type" id="formStorageType" value="{{ isset($order) ? $order->storage_type : 'session' }}">
                            
                            <div class="pos-container">
                                <!-- Product Selection Area -->
                                <div class="product-area">
                                    <!-- Barcode Scanner -->
                                    <div class="barcode-scanner mb-3">
                                        <div class="input-group">
                                            <input type="text" id="barcodeInput" class="form-control" placeholder="Scan barcode or search product..." autofocus>
                                            <button class="btn btn-outline-secondary" type="button" id="searchProductBtn"><i class="las la-search"></i></button>
                                        </div>
                                    </div>
                                    
                                    <!-- Category Tabs -->
                                    <div class="category-tabs-container">
                                        <div class="category-nav-arrow left">
                                            <i class="las la-angle-left"></i>
                                        </div>
                                        <div class="category-tabs">
                                            <div class="category-tab search_active active" data-category-id="">All Products</div>
                                            @foreach($categories as $category)
                                                <div class="category-tab" data-category-id="{{ $category->id }}">{{ $category->name }}</div>
                                            @endforeach
                                        </div>
                                        <div class="category-nav-arrow right">
                                            <i class="las la-angle-right"></i>
                                        </div>
                                    </div>
                                    
                                    <!-- Product Grid -->
                                    <div class="product-grid" id="productGrid">
                                        @foreach($products as $product)
                                            <div class="product-card" data-product-id="{{ $product->id }}" 
                                                data-variants="{{ $product->variants->count() > 1 ? 'true' : 'false' }}">
                                                @if($product->image_paths)
                                                    <img src="{{ json_decode('backend/'.$product->image_paths)[0] ?? asset('backend/assets/images/no_image.png') }}" alt="{{ $product->name }}">
                                                @else
                                                    <img src="{{ asset('backend/assets/images/no_image.png') }}" alt="{{ $product->name }}">
                                                @endif
                                                <div class="product-name">{{ $product->name }}</div>
                                                @if($product->variants->count() > 1)
                                                    <div class="text-muted small">{{ $product->variants->count() }} variants</div>
                                                @else
                                                    <div class="product-price">Rs {{ $product->variants->first()->selling_price ?? '0.00' }}</div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                
                                <!-- Cart Container -->
                                <div class="cart-container">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Customer</label>
                                            <div class="input-group">
                                                <select name="customer_id" id="customerSelect" class="form-control select2-customer">
                                                    <option value="Walk-in-Customer" selected>Walk-in Customer</option>
                                                    @foreach($customers as $customer)
                                                        <option value="{{ $customer->id }}" 
                                                            {{ isset($order) && $order->customer_id == $customer->id ? 'selected' : '' }}>
                                                            {{ $customer->name }} ({{ $customer->phone }})
                                                        </option>
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
                                                            class="form-control" placeholder="Customer Name"
                                                            value="{{ isset($order) && $order->walk_in_customer_info ? $order->walk_in_customer_info['name'] : '' }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" name="custom_customer_phone" id="customCustomerPhone" 
                                                            class="form-control" placeholder="Phone Number"
                                                            value="{{ isset($order) && $order->walk_in_customer_info ? $order->walk_in_customer_info['phone'] : '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="cart-items" id="cartItems">
                                        @if(isset($order) && $order->items->count() > 0)
                                            @foreach($order->items as $index => $item)
                                                <div class="cart-item" data-index="{{ $index }}">
                                                    <div>
                                                        <div class="fw-bold">{{ $item->product->name }}</div>
                                                        @if($item->variant)
                                                            <div class="small text-muted">{{ $item->variant->name }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="cart-item-controls">
                                                        <button class="btn btn-sm btn-outline-secondary decrement">
                                                            <i class="las la-minus"></i>
                                                        </button>
                                                        <input type="number" min="1" class="form-control form-control-sm quantity-input" 
                                                            value="{{ $item->quantity }}" style="width:80px">
                                                        <button class="btn btn-sm btn-outline-secondary increment">
                                                            <i class="las la-plus"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-danger remove-item ms-2">
                                                            <i class="las la-times"></i>
                                                        </button>
                                                    </div>
                                                    <div class="text-end">
                                                        <div>Rs {{ number_format($item->unit_price * $item->quantity, 2) }}</div>
                                                        <div class="small text-muted">Rs {{ number_format($item->unit_price, 2) }} each</div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="text-muted text-center py-5">Your cart is empty</div>
                                        @endif
                                    </div>
                                    
                                    <div class="cart-summary">
                                        <div class="summary-row">
                                            <span>Subtotal:</span>
                                            <span id="cartSubtotal">Rs {{ isset($order) ? number_format($order->subtotal, 2) : '0.00' }}</span>
                                        </div>
                                        <div class="summary-row">
                                            <span>Tax:</span>
                                            <span id="cartTax">Rs {{ isset($order) ? number_format($order->tax_amount, 2) : '0.00' }}</span>
                                        </div>
                                        <div class="summary-row">
                                            <span>Discount:</span>
                                            <div class="input-group input-group-sm">
                                                <input type="number" step="0.01" min="0" id="cartDiscount" class="form-control" 
                                                    value="{{ isset($order) ? number_format($order->discount_amount, 2) : '0' }}">
                                                <span class="input-group-text">Rs</span>
                                            </div>
                                        </div>
                                        <div class="summary-row fw-bold fs-5">
                                            <span>Total:</span>
                                            <span id="cartTotal">Rs {{ isset($order) ? number_format($order->total_amount, 2) : '0.00' }}</span>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label>Notes</label>
                                            <textarea name="notes" class="form-control" rows="2">{{ isset($order) ? $order->notes : '' }}</textarea>
                                        </div>
                                        
                                        <div class="order-actions">
                                            <button type="button" class="btn btn-danger" id="clearCartBtn">
                                                <i class="las la-trash"></i> Clear
                                            </button>
                                            <button type="button" class="btn btn-secondary" id="saveDraftBtn">
                                                <i class="las la-save"></i> Save Draft
                                            </button>
                                            <button type="button" class="btn btn-primary" id="confirmOrderBtn">
                                                <i class="las la-check"></i> Confirm Order
                                            </button>
                                            @if(isset($order) && $order->status === 'confirmed')
                                                <button type="button" class="btn btn-success" id="completeOrderBtn">
                                                    <i class="las la-check-circle"></i> Complete Sale
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-success" id="completeOrderBtn" disabled>
                                                    <i class="las la-check-circle"></i> Complete Sale
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="cartItemsData"></div> <!-- Hidden fields for cart items -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Variant Selection Modal -->
    <div class="modal fade" id="variantModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="popup text-left">
                        <div class="modal-header">
                            <h5 class="modal-title">Select Variant</h5>
                            <div class="btn btn-primary" data-dismiss="modal" aria-label="Close">x</div>
                        </div>
                        <div class="content create-workform bg-body" >
                            <div class="px-3 pt-3">
                                <input type="text" id="variantSearchInput" class="form-control" placeholder="Search variants...">
                            </div>
                            <div class="py-3" id="variantModalBody">
                                <!-- Variant options will be loaded here -->
                            </div>
                            <div class="col-lg-12 mt-4">
                                <div class="d-flex flex-wrap">
                                    <div class="btn btn-primary mr-4" data-dismiss="modal">Close</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New Customer Modal -->
    <div class="modal fade" id="customerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" class="form-control" id="newCustomerName">
                    </div>
                    <div class="mb-3">
                        <label>Phone</label>
                        <input type="text" class="form-control" id="newCustomerPhone">
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" class="form-control" id="newCustomerEmail">
                    </div>
                    <div class="mb-3">
                        <label>Address</label>
                        <textarea class="form-control" id="newCustomerAddress"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveCustomerBtn">Save</button>
                </div>
            </div>
        </div>
    </div>

    @push('js')
    <script src="{{ asset('backend/assets/js/backend-bundle.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/table-treeview.js') }}"></script>
    <script src="{{ asset('backend/assets/js/customizer.js') }}"></script>
    <script async src="{{ asset('backend/assets/js/chart-custom.js') }}"></script>
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            // Initialize cart with existing order items if editing
            const cart = {
                    items: {!! json_encode(isset($order) ? $order->items->map(function($item) {
                    return [
                        'productId' => $item->product_id,
                        'variantId' => $item->variant_id,
                        'quantity' => $item->quantity,
                        'price' => $item->unit_price,
                        'costPrice' => $item->cost_price,
                        'name' => $item->product->name,
                        'variantName' => $item->variant ? $item->variant->name : null
                    ];
                })->toArray() : []) !!},
                orderId: {!! json_encode(isset($order) ? $order->id : null) !!},
                status: {!! json_encode(isset($order) ? $order->status : 'draft') !!},
                storageType: {!! json_encode(isset($order) ? $order->storage_type : 'session') !!},
                    
                
                // Add item to cart
                addItem: function(productId, variantId, quantity = 1, price, costPrice, name, variantName) {
                    price = typeof price === 'string' ? parseFloat(price) : price;
                    costPrice = typeof costPrice === 'string' ? parseFloat(costPrice) : costPrice;
                    
                    const existingItem = this.items.find(item => 
                        item.productId === productId && item.variantId === variantId
                    );
                    
                    if (existingItem) {
                        existingItem.quantity += quantity;
                    } else {
                        this.items.push({
                            productId,
                            variantId,
                            quantity,
                            price,
                            costPrice,
                            name,
                            variantName
                        });
                    }
                    
                    this.updateCart();
                },
                
                // Remove item from cart
                removeItem: function(index) {
                    this.items.splice(index, 1);
                    this.updateCart();
                },
                
                // Update item quantity
                updateQuantity: function(index, quantity) {
                    if (quantity <= 0) {
                        this.removeItem(index);
                    } else {
                        this.items[index].quantity = quantity;
                    }
                    this.updateCart();
                },
                
                // Clear cart
                clear: function() {
                    this.items = [];
                    this.updateCart();
                },
                
                // Calculate cart totals
                calculateTotals: function() {
                    let subtotal = 0;
                    let tax = 0;
                    
                    this.items.forEach(item => {
                        subtotal += item.price * item.quantity;
                    });
                    
                    const discount = parseFloat($('#cartDiscount').val()) || 0;
                    const total = subtotal + tax - discount;
                    
                    return { subtotal, tax, discount, total };
                },
                
                // Update cart UI
                updateCart: function() {
                    const cartItemsEl = $('#cartItems');
                    
                    if (this.items.length === 0) {
                        cartItemsEl.html('<div class="text-muted text-center py-5">Your cart is empty</div>');
                    } else {
                        let html = '';
                        
                        this.items.forEach((item, index) => {
                            html += `
                                <div class="cart-item" data-index="${index}">
                                    <div>
                                        <div class="fw-bold">${item.name}</div>
                                        ${item.variantName ? `<div class="small text-muted">${item.variantName}</div>` : ''}
                                    </div>
                                    <div class="cart-item-controls">
                                        <button class="btn btn-sm btn-outline-secondary decrement">
                                            <i class="las la-minus"></i>
                                        </button>
                                        <input type="number" min="1" class="form-control form-control-sm quantity-input" 
                                            value="${item.quantity}" style="width:80px">
                                        <button class="btn btn-sm btn-outline-secondary increment">
                                            <i class="las la-plus"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger remove-item ms-2">
                                            <i class="las la-times"></i>
                                        </button>
                                    </div>
                                    <div class="text-end">
                                        <div>Rs ${(item.price * item.quantity).toFixed(2)}</div>
                                        <div class="small text-muted">Rs ${item.price.toFixed(2)} each</div>
                                    </div>
                                </div>
                            `;
                        });
                        cartItemsEl.html(html);
                    }
                    
                    const totals = this.calculateTotals();
                    $('#cartSubtotal').text('Rs ' + totals.subtotal.toFixed(2));
                    $('#cartTax').text('Rs ' + totals.tax.toFixed(2));
                    $('#cartTotal').text('Rs ' + totals.total.toFixed(2));
                    
                    $('#formSubtotal').val(totals.subtotal);
                    $('#formTaxAmount').val(totals.tax);
                    $('#formDiscountAmount').val(totals.discount);
                    $('#formTotalAmount').val(totals.total);
                    
                    this.updateFormData();
                    this.updateUI();
                },
                
                // Update hidden form fields
                updateFormData: function() {
                    $('#formCustomerId').val($('#customerSelect').val());
                    
                    let itemsHtml = '';
                    this.items.forEach((item, index) => {
                        itemsHtml += `
                            <input type="hidden" name="items[${index}][product_id]" value="${item.productId}">
                            <input type="hidden" name="items[${index}][variant_id]" value="${item.variantId}">
                            <input type="hidden" name="items[${index}][quantity]" value="${item.quantity}">
                            <input type="hidden" name="items[${index}][unit_price]" value="${item.price}">
                            <input type="hidden" name="items[${index}][cost_price]" value="${item.costPrice}">
                        `;
                    });
                    $('#cartItemsData').html(itemsHtml);
                },
                
                // Set order status
                setStatus: function(status) {
                    this.status = status;
                    $('#formStatus').val(status);
                    this.updateUI();
                },
                
                // Set storage type
                setStorageType: function(type) {
                    this.storageType = type;
                    $('#formStorageType').val(type);
                },
                
                // Update UI based on status
                updateUI: function() {
                    $('#saveDraftBtn').prop('disabled', this.status === 'completed');
                    $('#confirmOrderBtn').prop('disabled', this.status === 'completed');
                    $('#completeOrderBtn').prop('disabled', this.status !== 'confirmed');
                    
                    if (this.status === 'confirmed') {
                        $('.order-status-badge').removeClass('status-draft status-confirmed status-completed status-cancelled')
                            .addClass('status-confirmed')
                            .text('Confirmed');
                    }
                },
                
                // Save order (create or update)
                saveOrder: function() {
                    const formData = this.getFormData();
                    const url = this.orderId ? `/orders/${this.orderId}` : '/orders';
                    const method = this.orderId ? 'PUT' : 'POST';
                    
                    return $.ajax({
                        url: url,
                        type: method,
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: (response) => {
                            if (response.order) {
                                this.orderId = response.order.id;
                                this.status = response.order.status;
                                this.storageType = response.order.storage_type;
                                
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Order Saved',
                                    text: `Order #${response.order.order_number} has been saved`,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                            this.updateUI();
                        },
                        error: (xhr) => {
                            let errorMessage = 'An error occurred while saving the order';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            
                            Swal.fire({
                                icon: 'error',
                                title: 'Save Failed',
                                text: errorMessage,
                            });
                        }
                    });
                },
                
                // Complete order (convert to sale)
                completeOrder: function() {
                    if (!this.orderId) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Please save the order first before completing'
                        });
                        return Promise.reject();
                    }
                    
                    return $.ajax({
                        url: `/orders/${this.orderId}/complete`,
                        type: 'POST',
                        success: (response) => {
                            if (response.success) {
                                this.status = 'completed';
                                this.updateUI();
                                
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Order Completed',
                                    text: `Sale completed for order #${response.order.order_number}`,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                
                                // Optionally redirect to invoice or clear the cart
                                window.location.href = `/sales/${response.sale.id}`;
                            }
                        },
                        error: (xhr) => {
                            let errorMessage = 'An error occurred while completing the order';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            
                            Swal.fire({
                                icon: 'error',
                                title: 'Completion Failed',
                                text: errorMessage,
                            });
                        }
                    });
                },
                
                // Get form data for submission
                getFormData: function() {
                    const form = $('#orderForm')[0];
                    const formData = new FormData(form);
                    
                    this.items.forEach((item, index) => {
                        formData.append(`items[${index}][product_id]`, item.productId);
                        formData.append(`items[${index}][variant_id]`, item.variantId);
                        formData.append(`items[${index}][quantity]`, item.quantity);
                        formData.append(`items[${index}][unit_price]`, item.price);
                        formData.append(`items[${index}][cost_price]`, item.costPrice);
                    });
                    
                    formData.append('status', this.status);
                    formData.append('storage_type', this.storageType);
                    
                    return formData;
                }
            };
        // Initialize order creation interface
            function initOrderCreation() {
                // Product card click handler
                 $('.product-card').on('click', function() {// Product card click handler on page relod show product variant model

                    const productId = $(this).data('product-id');
                    const hasVariants = $(this).data('variants');
                    
                    if (hasVariants) {
                        showVariantModel(productId);
                    } else {
                        const productName = $(this).find('.product-name').text();
                        const price = parseFloat($(this).find('.product-price').text().replace('Rs ', ''));
                        
                        $.get(`/products/${productId}`, function(product) {// Get product details via API to ensure we have cost price
                            const variant = product.variants[0];
                            cart.addItem(
                                productId, 
                                variant.id, 
                                1, 
                                variant.selling_price, 
                                variant.purchase_price,
                                product.name,
                                variant.name
                            );
                        });
                    }
                });
                
                // Variant selection in modal
                $(document).on('click', '.variant-option', function() {
                    cart.addItem(
                        $(this).data('product-id'),
                        $(this).data('variant-id'),
                        1,
                        $(this).data('price'),
                        $(this).data('cost'),
                        $(this).data('name'),
                        $(this).data('variant-name')
                    );
                    $('#variantModal').modal('hide');
                });
                
                // Cart item controls
                $(document).on('click', '.remove-item', function() {
                    const index = $(this).closest('.cart-item').data('index');
                    cart.removeItem(index);
                });
                
                $(document).on('click', '.increment', function() {
                    const index = $(this).closest('.cart-item').data('index');
                    const currentQty = parseInt($(this).siblings('.quantity-input').val());
                    cart.updateQuantity(index, currentQty + 1);
                });
                
                $(document).on('click', '.decrement', function() {
                    const index = $(this).closest('.cart-item').data('index');
                    const currentQty = parseInt($(this).siblings('.quantity-input').val());
                    cart.updateQuantity(index, currentQty - 1);
                });
                
                $(document).on('change', '.quantity-input', function() {
                    const index = $(this).closest('.cart-item').data('index');
                    const newQty = parseInt($(this).val());
                    cart.updateQuantity(index, newQty);
                });
                
                // Discount input
                $('#cartDiscount').on('change', function() {
                    cart.updateCart();
                });
                
                // Clear cart button
                $('#clearCartBtn').on('click', function() {
                    Swal.fire({
                        title: 'Clear Cart?',
                        text: 'Are you sure you want to clear all items from the cart?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, clear it!',
                        cancelButtonText: 'No, keep items'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            cart.clear();
                        }
                    });
                });
                
                // Save as draft button
                $('#saveDraftBtn').on('click', function() {
                    if (cart.items.length === 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Empty Cart',
                            text: 'Please add items to the order before saving'
                        });
                        return;
                    }
                    
                    cart.setStatus('draft');
                    cart.setStorageType('database');
                    cart.saveOrder();
                });
                
                // Confirm order button
                $('#confirmOrderBtn').on('click', function() {
                    if (cart.items.length === 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Empty Cart',
                            text: 'Please add items to the order before confirming'
                        });
                        return;
                    }
                    
                    Swal.fire({
                        title: 'Confirm Order?',
                        text: 'This will mark the order as confirmed and ready for payment',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, confirm',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            cart.setStatus('confirmed');
                            cart.setStorageType('database');
                            cart.saveOrder().then(() => {
                                $('#completeOrderBtn').prop('disabled', false);
                            });
                        }
                    });
                });
                
                // Complete order button
                $('#completeOrderBtn').on('click', function() {
                    Swal.fire({
                        title: 'Complete Order?',
                        text: 'This will convert the order to a sale and update inventory',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Complete Sale',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            cart.completeOrder();
                        }
                    });
                });
                
                // Customer selection
                $('#addCustomCustomer').click(function() {
                    $('#customCustomerContainer').toggle();
                    if ($('#customCustomerContainer').is(':visible')) {
                        $(this).html('<i class="las la-user-minus"></i> Cancel');
                        $('#customerSelect').val('Walk-in-Customer').trigger('change');
                    } else {
                        $(this).html('<i class="las la-user-plus"></i> New Customer');
                        $('#customCustomerName').val('');
                        $('#customCustomerPhone').val('');
                    }
                });
                
                $('#customerSelect').on('change', function() {
                    if ($(this).val() !== 'Walk-in-Customer') {
                        $('#customCustomerContainer').hide();
                        $('#addCustomCustomer').html('<i class="las la-user-plus"></i> New Customer');
                        $('#customCustomerName').val('');
                        $('#customCustomerPhone').val('');
                    }
                    $('#formCustomerId').val($(this).val());
                });
                
                // Barcode scanner
                $('#barcodeInput').on('keypress', function(e) {
                    if (e.which === 13) { // Enter key
                        const barcode = $(this).val().trim();
                        if (barcode) {
                            $.get(`/products/barcode/${barcode}`, function(productVariant) {
                                if (productVariant) {
                                    cart.addItem(
                                        productVariant.product_id,
                                        productVariant.id,
                                        1,
                                        productVariant.selling_price,
                                        productVariant.purchase_price,
                                        productVariant.product.name,
                                        productVariant.name
                                    );
                                    $('#barcodeInput').val('');
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Product Not Found',
                                        text: 'No product found with this barcode'
                                    });
                                }
                            }).fail(function() {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Error looking up product'
                                });
                            });
                        }
                    }
                });
                
                // Search product button
                $('#searchProductBtn').on('click', function() {
                    const searchTerm = $('#barcodeInput').val().trim();
                    $('.category-tab').removeClass('active');
                    $('.search_active').addClass('active');
                    
                    if (searchTerm) {
                        $.get(`/products/search/${searchTerm}`, function(products) {
                            let html = '';
                            
                            if (products.length === 0) {
                                html = '<div class="text-muted text-center py-5">No products found</div>';
                            } else {
                                products.forEach(product => {
                                    const hasVariants = product.variants.length > 1;
                                    const price = hasVariants ? '' : `Rs ${product.variants[0].selling_price.toFixed(2)}`;
                                    
                                    html += `
                                        <div class="product-card" data-product-id="${product.id}" 
                                            data-variants="${hasVariants ? 'true' : 'false'}">
                                            <img src="${product.image_paths ? JSON.parse(product.image_paths)[0] : 'backend/assets/images/no_image.png'}" 
                                                alt="${product.name}">
                                            <div class="product-name">${product.name}</div>
                                            ${hasVariants ? 
                                                `<div class="text-muted small">${product.variants.length} variants</div>` : 
                                                `<div class="product-price">${price}</div>`}
                                        </div>
                                    `;
                                });
                            }                            
                            $('#productGrid').html(html);
                            $('#barcodeInput').val('');
                        });
                    }
                });
                
                // Category tabs
                $('.category-tab').on('click', function() {
                    $('.category-tab').removeClass('active');
                    $(this).addClass('active');
                    const categoryId = $(this).data('category-id');
                    
                    if (categoryId) {
                        $.get(`/categories/${categoryId}/products`, function(products) {
                            updateProductGrid(products);
                        });
                    } else {
                        $.get('/pos_products', function(products) {
                            updateProductGrid(products);
                        });
                    }
                });
                
                // New customer modal
                $('#saveCustomerBtn').on('click', function() {
                    const customerData = {
                        name: $('#newCustomerName').val(),
                        phone: $('#newCustomerPhone').val(),
                        email: $('#newCustomerEmail').val(),
                        address: $('#newCustomerAddress').val()
                    };
                    
                    $.ajax({
                        url: '/customers',
                        type: 'POST',
                        data: customerData,
                        success: function(response) {
                            $('#customerModal').modal('hide');
                            
                            // Add new customer to select
                            const newOption = new Option(
                                `${response.name} (${response.phone})`, 
                                response.id, 
                                true, 
                                true
                            );
                            $('#customerSelect').append(newOption).trigger('change');
                            
                            // Clear form
                            $('#newCustomerName').val('');
                            $('#newCustomerPhone').val('');
                            $('#newCustomerEmail').val('');
                            $('#newCustomerAddress').val('');
                            
                            Swal.fire({
                                icon: 'success',
                                title: 'Customer Added',
                                text: 'New customer has been added successfully',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        },
                        error: function(xhr) {
                            let errorMessage = 'An error occurred while saving the customer';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            
                            Swal.fire({
                                icon: 'error',
                                title: 'Save Failed',
                                text: errorMessage,
                            });
                        }
                    });
                });
                
                // Initialize cart UI if editing existing order
                if (cart.items.length > 0) {
                    cart.updateCart();
                }
            }
            
            // Show variant selection modal
            function showVariantModel(productId) {
                $.get(`/products/${productId}/variants_data`, function(variants) {
                    let modalBody = '';
                    variants.forEach(variant => {
                        modalBody += `
                            <div class="mb-2 variant-option" 
                                data-product-id="${productId}"
                                data-variant-id="${variant.id}"
                                data-price="${variant.selling_price}"
                                data-cost="${variant.purchase_price}"
                                data-name="${variant.product?.name || ''}"
                                data-variant-name="${variant.name}"
                                data-search-text="${(variant.name + ' ' + variant.sku + ' ' + variant.selling_price).toLowerCase()}">
                                <div class="d-flex justify-content-between align-items-center p-2 border rounded">
                                    <div>
                                        <strong>${variant.name}</strong>
                                        <div class="small" style="font-size:20px"> ${variant.sku}</div>
                                    </div>
                                    <div>
                                        <div>Rs ${parseFloat(variant.selling_price).toFixed(2)}</div>
                                        <div class="small text-muted">Stock: ${variant.current_stock}</div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    $('#variantModalBody').html(modalBody);
                    
                    // Initialize search functionality
                    $('#variantSearchInput').on('input', function() {
                        const searchTerm = $(this).val().toLowerCase();
                        $('.variant-option').each(function() {
                            const searchText = $(this).data('search-text');
                            if (searchText.includes(searchTerm)) {
                                $(this).show();
                            } else {
                                $(this).hide();
                            }
                        });
                    });
                    
                    var modal = new bootstrap.Modal(document.getElementById('variantModal'));
                    modal.show();
                    
                    // Focus on search input when modal is shown
                    $('#variantModal').on('shown.bs.modal', function() {
                        $('#variantSearchInput').focus();
                    });
                    
                }).fail(function(error) {
                    console.error("Error loading variants:", error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to load product variants'
                    });
                });
            }
            
            // Update product grid
            function updateProductGrid(products) {
                let html = '';
                
                if (products.length === 0) {
                    html = '<div class="text-muted text-center py-5">No products found in this category</div>';
                } else {
                    products.forEach(product => {
                        const variants = product.variants || [];
                        const hasAnyVariants = variants.length > 0;
                        const hasMultipleVariants = variants.length > 1;
                        
                        // Handle image path
                        let imagePath = 'backend/assets/images/no_image.png';
                        try {
                            if (product.image_paths) {
                                const parsedPaths = typeof product.image_paths === 'string' 
                                    ? JSON.parse(product.image_paths) 
                                    : product.image_paths;
                                if (Array.isArray(parsedPaths)) {
                                    imagePath = parsedPaths[0] || imagePath;
                                }
                            }
                        } catch (e) {
                            console.error("Error parsing image paths:", e);
                        }

                        // Price display logic
                        let priceDisplay = 'Rs 0.00';
                        if (hasAnyVariants && !hasMultipleVariants) {
                            const price = variants[0].selling_price;
                            priceDisplay = `Rs ${parseFloat(price).toFixed(2)}`;
                        }

                        html += `
                            <div class="product-card" data-product-id="${product.id}" 
                                data-variants="${hasMultipleVariants ? 'true' : 'false'}">
                                <img src="${imagePath.startsWith('http') ? imagePath : '/' + imagePath}" 
                                    alt="${product.name}" onerror="this.src='backend/assets/images/no_image.png'">
                                <div class="product-name">${product.name}</div>
                                ${hasMultipleVariants ? 
                                    `<div class="text-muted small">${variants.length} variants</div>` : 
                                    `<div class="product-price">${priceDisplay}</div>`}
                            </div>
                        `;
                    });
                }
                $('#productGrid').html(html);
            }
            
            // Initialize the order creation interface
            initOrderCreation();
        });
    </script>
    @endpush
</x-app-layout>