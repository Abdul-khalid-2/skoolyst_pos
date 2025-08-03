<x-app-layout>
    @push('css')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css')}}">
    <link rel="stylesheet" href="{{ asset('backend/assets/admin/custome-style/creater_order.css')}}">
    @endpush

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="card-title">Update Order #{{ $order->order_number }}</h4>
                        <div>
                            <span class="badge bg-primary me-2">Branch: {{ $currentBranch->name ?? 'Not Selected' }}</span>
                            <span class="badge bg-secondary">User: {{ auth()->user()->name }}</span>
                            <span class="order-status-badge status-{{ $order->status }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="orderForm" method="POST" action="{{ route('orders.update', $order->id) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="order_number" value="{{ $order->order_number }}">
                            <input type="hidden" name="branch_id" value="{{ $currentBranch->id ?? '' }}">
                            
                            <!-- Hidden fields for summary data -->
                            <input type="hidden" name="subtotal" id="formSubtotal" value="{{ $order->subtotal }}">
                            <input type="hidden" name="tax_amount" id="formTaxAmount" value="{{ $order->tax_amount }}">
                            <input type="hidden" name="discount_amount" id="formDiscountAmount" value="{{ $order->discount_amount }}">
                            <input type="hidden" name="total_amount" id="formTotalAmount" value="{{ $order->total_amount }}">
                            <input type="hidden" name="customer_id" id="formCustomerId" value="{{ $order->customer_id ?? 0 }}">
                            <input type="hidden" name="status" id="formStatus" value="{{ $order->status }}">
                            <input type="hidden" name="storage_type" id="formStorageType" value="{{ $order->storage_type }}">
                            
                            <div class="pos-container">
                                <!-- Product Selection Area -->
                                <div class="product-area">
                                    <!-- Barcode Scanner -->
                                    <div class="barcode-scanner mb-3">
                                        <div class="input-group">
                                            <input type="text" id="barcodeInput" class="form-control" 
                                                placeholder="Scan barcode or search product..." autofocus>
                                        </div>
                                    </div>
                                    
                                    <!-- Category Tabs -->
                                    <div class="category-tabs-container">
                                        <div class="category-nav-arrow left">
                                            <i class="las la-angle-left"></i>
                                        </div>
                                        <div class="category-tabs" id="categoryTabs">
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
                                            @php
                                                $hasVariants = $product->variants->count() > 1;
                                                $price = $hasVariants ? '' : 'Rs '.number_format($product->variants[0]->selling_price, 2);
                                                
                                                // Handle image path
                                                $imagePath = '/backend/assets/images/no_image.png';
                                                if ($product->image_paths) {
                                                    $parsedPaths = is_array($product->image_paths) ? $product->image_paths : json_decode($product->image_paths, true);
                                                    if (!empty($parsedPaths)) {
                                                        $imagePath = Str::startsWith($parsedPaths[0], 'http') ? $parsedPaths[0] : '/'.$parsedPaths[0];
                                                    }
                                                }
                                            @endphp
                                            <div class="product-card" data-product-id="{{ $product->id }}" 
                                                data-category-id="{{ $product->category_id}}"
                                                data-variants="{{ $hasVariants ? 'true' : 'false' }}">
                                                <img src="{{ $imagePath }}" alt="{{ $product->name }}" 
                                                    onerror="this.src='/backend/assets/images/no_image.png'">
                                                <div class="product-name">{{ $product->name }}</div>
                                                @if($hasVariants)
                                                    <div class="text-muted small">{{ $product->variants->count() }} variants</div>
                                                @else
                                                    <div class="product-price">{{ $price }}</div>
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
                                                    <option value="Walk-in-Customer" {{ !$order->customer_id ? 'selected' : '' }}>Walk-in Customer</option>
                                                    @foreach($customers as $customer)
                                                        <option value="{{ $customer->id }}" 
                                                            {{ $order->customer_id == $customer->id ? 'selected' : '' }}>
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
                                            <div id="customCustomerContainer" class="mt-2" style="display: {{ $order->walk_in_customer_info ? 'block' : 'none' }};">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input type="text" name="custom_customer_name" id="customCustomerName" 
                                                            class="form-control" placeholder="Customer Name"
                                                            value="{{ $order->walk_in_customer_info['name'] ?? '' }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" name="custom_customer_phone" id="customCustomerPhone" 
                                                            class="form-control" placeholder="Phone Number"
                                                            value="{{ $order->walk_in_customer_info['phone'] ?? '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="cart-items" id="cartItems">
                                        @if($order->items->count() > 0)
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
                                            <span id="cartSubtotal">Rs {{ number_format($order->subtotal, 2) }}</span>
                                        </div>
                                        <div class="summary-row">
                                            <span>Tax:</span>
                                            <span id="cartTax">Rs {{ number_format($order->tax_amount, 2) }}</span>
                                        </div>
                                        <div class="summary-row">
                                            <span>Discount:</span>
                                            <div class="input-group input-group-sm">
                                                <input type="number" step="0.01" min="0" id="cartDiscount" class="form-control" 
                                                    value="{{ number_format($order->discount_amount, 2) }}">
                                                <span class="input-group-text">Rs</span>
                                            </div>
                                        </div>
                                        <div class="summary-row fw-bold fs-5">
                                            <span>Total:</span>
                                            <span id="cartTotal">Rs {{ number_format($order->total_amount, 2) }}</span>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label>Notes</label>
                                            <textarea name="notes" class="form-control" rows="2">{{ $order->notes }}</textarea>
                                        </div>
                                        
                                        <div class="order-actions row g-1 g-lg-3">
                                            <div class="px-3 mb-2" style="width: 50%">
                                                <button type="button" class="btn btn-danger w-100" id="clearCartBtn">
                                                    <i class="las la-trash"></i> Clear
                                                </button>
                                            </div>

                                            <div class="px-3 mb-2" style="width: 50%">
                                                <button type="button" class="btn btn-secondary w-100" id="saveDraftBtn">
                                                    <i class="las la-save"></i> Save Draft
                                                </button>
                                            </div>

                                            <div class="col-6 mb-2 col-md-3 col-lg-12 col-xl-12">
                                                <button type="button" class="btn btn-primary w-100" id="confirmOrderBtn">
                                                    <i class="las la-check"></i> Confirm Order
                                                </button>
                                            </div>

                                            <div class="col-6 col-md-3 col-lg-12 col-xl-12">
                                                @if($order->status === 'confirmed')
                                                    <button type="button" class="btn btn-success w-100 mb-2" id="completeOrderBtn">
                                                        <i class="las la-check-circle"></i> Complete Sale
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-success w-100 mb-2" id="completeOrderBtn" disabled>
                                                        <i class="las la-check-circle"></i> Complete Sale
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="cartItemsData"></div>
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
            // Initialize cart with existing order items
            const cart = {
                items: [],

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

                orderId: "{{ $order->id }}",
                status: "{{ $order->status }}",
                storageType: "{{ $order->storage_type }}",
                
                // Initialize with existing items
                init: function() {
                    @foreach($order->items as $item)
                        this.items.push({
                            productId: "{{ $item->product_id }}",
                            variantId: "{{ $item->variant_id }}",
                            quantity: {{ $item->quantity }},
                            price: {{ $item->unit_price }},
                            costPrice: {{ $item->cost_price }},
                            name: "{{ $item->product->name }}",
                            variantName: "{{ $item->variant ? $item->variant->name : '' }}"
                        });
                    @endforeach
                    this.updateCart();
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
                // Save order (update existing)
                saveOrder: function() {
                    const formData = this.getFormData();
                    const url = "/orders/" + this.orderId;
                    const method = "PUT";
                    
                    return $.ajax({
                        url: url,
                        type: method,
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: (response) => {
                            if (response.order) {
                                this.status = response.order.status;
                                this.storageType = response.order.storage_type;
                                
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Order Updated',
                                    text: `Order #${response.order.order_number} has been updated`,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                
                                this.updateUI();
                            }
                        },
                        error: (xhr) => {
                            let errorMessage = 'An error occurred while updating the order';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            
                            Swal.fire({
                                icon: 'error',
                                title: 'Update Failed',
                                text: errorMessage,
                            });
                        }
                    });
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
                    $('#cartDiscount').val('0');
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
                
                // Complete order
                completeOrder: function() {
                    const $btn = $('#completeOrderBtn');
                    $btn.prop('disabled', true);
                    $btn.html('<i class="las la-spinner la-spin"></i> Processing...');
                    
                    $.ajax({
                        url: `/orders/${this.orderId}/complete`,
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: (response) => {
                            if (response.success) {
                                this.status = 'completed';
                                this.updateUI();
                                
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Order Completed',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => {
                                    window.location.href = "{{ route('orders.index') }}";
                                });
                            }
                        },
                        error: (xhr) => {
                            $btn.prop('disabled', false);
                            $btn.html('<i class="las la-check-circle"></i> Complete Sale');
                            
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
                }
            };
            
            // Initialize the cart with existing items
            cart.init();
            
            // Initialize event handlers
            function initializeEventHandlers() {
                // Category tab click
                $(document).on('click', '.category-tab', function() {
                    $('.category-tab').removeClass('active');
                    $(this).addClass('active');
                    
                    const categoryId = $(this).data('category-id');
                    filterProductsByCategory(categoryId);
                });
                
                // Product card click handler
                $(document).on('click', '.product-card', function() {
                    const productId = $(this).data('product-id');
                    const hasVariants = $(this).data('variants');
                    
                    if (hasVariants) {
                        showVariantModel(productId);
                    } else {
                        const product = getProductById(productId);
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
                    }
                });
                
                // Search functionality
                $('#barcodeInput').on('keyup', function(e) {
                    const searchTerm = $(this).val().trim();
                    $('.category-tab').removeClass('active');
                    $('.search_active').addClass('active');
                    filterProductsBySearch(searchTerm);
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
                    alert('testing increment button');
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
                    $(this).prop("disabled",true);
                    Swal.fire({
                        title: 'Confirm Order?',
                        text: 'This will mark the order as confirmed and ready for payment',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, confirm',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $(this).html('<i class="las la-spinner la-spin"></i> Processing...');
                            cart.setStatus('confirmed');
                            cart.setStorageType('database');
                            cart.saveOrder().then(() => {
                                $(this).prop('disabled', false);
                                $(this).html('<i class="las la-check"></i> Confirm Order');
                            }).catch(() => {
                                $(this).prop('disabled', true);
                                $(this).html('<i class="las la-check"></i> Confirm Order');
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
            }
            
            // Helper function to filter products by category
            function filterProductsByCategory(categoryId) {
                $('.product-card').each(function() {
                    const cardCategoryId = $(this).data('category-id');
                    if (!categoryId || cardCategoryId == categoryId) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            }
            
            // Helper function to filter products by search term
            function filterProductsBySearch(searchTerm) {
                const term = searchTerm.toLowerCase();
                
                $('.product-card').each(function() {
                    const productName = $(this).find('.product-name').text().toLowerCase();
                    const productPrice = $(this).find('.product-price').text().toLowerCase();
                    
                    if (productName.includes(term) || productPrice.includes(term)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            }
            
            // Helper function to get product by ID
            function getProductById(productId) {
                @foreach($products as $product)
                    if ("{{ $product->id }}" == productId) {
                        return {
                            id: "{{ $product->id }}",
                            name: "{{ $product->name }}",
                            variants: [
                                @foreach($product->variants as $variant)
                                {
                                    id: "{{ $variant->id }}",
                                    name: "{{ $variant->name }}",
                                    selling_price: {{ $variant->selling_price }},
                                    purchase_price: {{ $variant->purchase_price }},
                                    sku: "{{ $variant->sku }}",
                                    barcode: "{{ $variant->barcode }}"
                                },
                                @endforeach
                            ]
                        };
                    }
                @endforeach
                return null;
            }
            
            // Show variant modal
            function showVariantModel(productId) {
                // Create and show loader before making the request
                const loaderHtml = `
                    <div class="advanced-loader">
                        <div class="loader-backdrop"></div>
                        <div class="loader-content">
                            <div class="spinner-container">
                                <div class="spinner">
                                    <div class="spinner-circle spinner-circle-outer"></div>
                                    <div class="spinner-circle spinner-circle-inner"></div>
                                    <div class="spinner-circle spinner-circle-single-1"></div>
                                    <div class="spinner-circle spinner-circle-single-2"></div>
                                </div>
                            </div>
                            <div class="loader-text">Loading variants...</div>
                            <div class="progress-container">
                                <div class="progress-bar"></div>
                            </div>
                        </div>
                    </div>
                `;
                
                $('body').append(loaderHtml);
                
                // Start progress bar animation
                const progressBar = $('.progress-bar');
                let progress = 0;
                const progressInterval = setInterval(() => {
                    progress += 5;
                    progressBar.css('width', `${Math.min(progress, 90)}%`);
                }, 200);
                
                $.get(`/products/${productId}/variants_data`, function(variants) {
                    clearInterval(progressInterval);
                    progressBar.css('width', '100%');
                    
                    // Add slight delay for smooth transition
                    setTimeout(() => {
                        $('.advanced-loader').fadeOut(300, function() {
                            $(this).remove();
                        });
                        
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
                                $(this).toggle(searchText.includes(searchTerm));
                            });
                        });
                        
                        var modal = new bootstrap.Modal(document.getElementById('variantModal'));
                        modal.show();
                        
                        // Focus on search input when modal is shown
                        $('#variantModal').on('shown.bs.modal', function() {
                            $('#variantSearchInput').focus();
                        });
                        
                    }, 300);
                    
                }).fail(function(error) {
                    clearInterval(progressInterval);
                    $('.loader-text').text('Failed to load variants');
                    $('.spinner-container').html('<i class="fas fa-exclamation-circle error-icon"></i>');
                    progressBar.css('width', '100%').addClass('error');
                    
                    setTimeout(() => {
                        $('.advanced-loader').fadeOut(300, function() {
                            $(this).remove();
                        });
                        
                        console.error("Error loading variants:", error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to load product variants'
                        });
                    }, 1000);
                });
            }
            
            // Initialize event handlers
            initializeEventHandlers();
        });

        jQuery(document).ready(function() {
            jQuery(".wrapper-menu").addClass("open");
            jQuery("body").addClass("sidebar-main");
        });
    </script>
    @endpush
</x-app-layout>