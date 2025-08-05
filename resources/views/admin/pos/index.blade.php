<x-app-layout>
    @push('css')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css')}}">
    <link rel="stylesheet" href="{{ asset('backend/assets/admin/custome-style/pos_terminal.css')}}">
    @endpush

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="card-title">POS Terminal</h4>
                        <div>
                            <span class="badge bg-primary me-2">Branch: {{ $currentBranch->name ?? 'Not Selected' }}</span>
                            <span class="badge bg-secondary">User: {{ auth()->user()->name }}</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="posForm" method="POST">
                            @csrf
                            <input type="hidden" name="invoice_number" value="MD-{{ \Carbon\Carbon::now()->format('Ymd-his') }}">
                            <input type="hidden" name="sale_date" value="{{ date('Y-m-d') }}">
                            <input type="hidden" name="branch_id" value="{{ $currentBranch->id ?? '' }}">
                            
                            <!-- Hidden fields for summary data -->
                            <input type="hidden" name="subtotal" id="formSubtotal" value="0">
                            <input type="hidden" name="tax_amount" id="formTaxAmount" value="0">
                            <input type="hidden" name="discount_amount" id="formDiscountAmount" value="0">
                            <input type="hidden" name="total_amount" id="formTotalAmount" value="0">
                            <input type="hidden" name="customer_id" id="formCustomerId" value="0">
                            <input type="hidden" name="due_balance" id="formDueBalance" value="0">
                            
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
                                        <div class="text-center py-5">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </div>
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
                                    
                                    <div class="cart-items" id="cartItems">
                                        <div class="text-muted text-center py-5">Your cart is empty</div>
                                    </div>
                                    
                                    <div class="cart-summary">
                                        <div class="summary-row">
                                            <span>Subtotal:</span>
                                            <span id="cartSubtotal">Rs 0.00</span>
                                        </div>
                                        <div class="summary-row">
                                            <span>Tax:</span>
                                            <span id="cartTax">Rs 0.00</span>
                                        </div>
                                        <div class="summary-row">
                                            <span>Discount:</span>
                                            <div class="input-group input-group-sm">
                                                <input type="number" step="0.01" min="0" id="cartDiscount" class="form-control" value="0">
                                                <span class="input-group-text">Rs</span>
                                            </div>
                                        </div>
                                        <div class="summary-row fw-bold fs-5">
                                            <span>Total:</span>
                                            <span id="cartTotal">Rs 0.00</span>
                                        </div>
                                        
                                        <div class="payment-methods">
                                            @foreach($paymentMethods as $method)
                                                <button type="button" class="payment-method-btn" data-method-id="{{ $method->id }}">
                                                    {{ $method->name }}
                                                </button>
                                            @endforeach
                                        </div>
                                        <input type="hidden" name="payment_method_id" id="paymentMethodId">
                                        
                                        <div class="mb-3">
                                            <label>Payment Reference</label>
                                            <input type="text" class="form-control" name="payment_reference" id="paymentReference" placeholder="Optional reference">
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label>Amount Paid</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rs</span>
                                                <input type="number" step="0.01" min="0" class="form-control" name="amount_paid" id="amountPaid" value="0">
                                            </div>
                                        </div>
                                        
                                        <div class="quick-cash-buttons">
                                            <button type="button" class="quick-cash-btn" data-amount="500">500</button>
                                            <button type="button" class="quick-cash-btn" data-amount="1000">1000</button>
                                            <button type="button" class="quick-cash-btn" data-amount="2000">2000</button>
                                            <button type="button" class="quick-cash-btn" data-amount="5000">5000</button>
                                            <button type="button" class="quick-cash-btn" data-amount="10000">10000</button>
                                            <button type="button" class="quick-cash-btn" data-amount="total">Exact</button>
                                        </div>
                                        
                                        <div class="summary-row mb-3">
                                            <span>Change Due:</span>
                                            <span id="changeDue">Rs 0.00</span>
                                        </div>
                                        
                                        <div class="summary-row mb-3">
                                            <span>Due Balance:</span>
                                            <span id="dueBalance">Rs 0.00</span>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label>Notes</label>
                                            <textarea name="notes" class="form-control" rows="2"></textarea>
                                        </div>
                                        
                                        <div class="d-grid gap-2">
                                            <button type="button" class="btn btn-danger" id="clearCartBtn">
                                                <i class="las la-trash"></i> Clear
                                            </button>
                                            <button type="submit" class="btn btn-success" id="completeSaleBtn">
                                                <i class="las la-check-circle"></i> Complete Sale
                                            </button>
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
                        <div class="content create-workform bg-body">
                            <div class="px-3 pt-3">
                                <input type="text" id="variantSearchInput" class="form-control" placeholder="Search variants...">
                            </div>
                            <div class="py-3" id="variantModalBody">
                                <!-- Variants will be loaded here -->
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

    <!-- Print Modal -->
    <div class="modal fade" id="printModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Print Bill</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <iframe id="billIframe" src="" style="width:100%; height:70vh; border:none;"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="printIframe()">Print</button>
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
            // Global variables to store products and categories
            let allPosProducts = [];
            let allCategories = [];
            let currentBranch = null;
            let allCustomers = [];

            // Cart object to manage cart operations
            const cart = {
                items: [],
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
                removeItem: function(index) {
                    this.items.splice(index, 1);
                    this.updateCart();
                },
                updateQuantity: function(index, quantity) {
                    if (quantity <= 0) {
                        this.removeItem(index);
                    } else {
                        this.items[index].quantity = quantity;
                    }
                    this.updateCart();
                },
                clear: function() {
                    this.items = [];
                    $('#cartDiscount').val('0');
                    this.updateCart();
                },
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
                         updateChangeDue: function() {
                    const total = parseFloat($('#cartTotal').text().replace('Rs ', '')) || 0;
                    const amountPaid = parseFloat($('#amountPaid').val()) || 0;
                    const changeDue = Math.max(0, amountPaid - total);                    
                    const dueBalance = Math.max(0, total - amountPaid);
                    
                    $('#changeDue').text('Rs ' + changeDue.toFixed(2));
                    $('#dueBalance').text('Rs ' + dueBalance.toFixed(2));
                    $('#formDueBalance').val(dueBalance.toFixed(2));
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
                                }).then(() => {
                                    cart.clear();
                                    $btn.prop('disabled', false);
                                    $btn.html('<i class="las la-check"></i> Confirm Order');
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

            // Initialize the POS system
            function initializePOS() {
                loadAllData().then(() => {
                    renderCategories();
                    renderProducts();
                    initializeEventHandlers();
                });
            }

            // Load all initial data
            function loadAllData() {
                return $.get('/allPosProducts', function(response) {
                    allPosProducts = response.products;
                    allCategories = response.categories;
                    currentBranch = response.currentBranch;
                    allCustomers = response.customers;
                    
                    // Update customer dropdown
                    updateCustomerDropdown();
                    
                    // Update branch info in header
                    updateBranchInfo();
                }).fail(function(error) {
                    console.error("Error loading data:", error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Loading Failed',
                        text: 'Failed to load products and categories'
                    });
                });
            }

            // Render categories in the tabs
            function renderCategories() {
                let html = '<div class="category-tab search_active active" data-category-id="">All Products</div>';
                
                allCategories.forEach(category => {
                    html += `<div class="category-tab" data-category-id="${category.id}">${category.name}</div>`;
                });
                
                $('#categoryTabs').html(html);
            }

            // Render products in the grid
            function renderProducts(filterCategoryId = '', searchTerm = '') {
                let filteredProducts = allPosProducts;
                
                // Filter by category if specified
                if (filterCategoryId) {
                    filteredProducts = allPosProducts.filter(product => product.category_id == filterCategoryId);
                }
                
                // Filter by search term if specified
                if (searchTerm) {
                    const term = searchTerm.toLowerCase();
                    filteredProducts = filteredProducts.filter(product => {
                        // Check product name
                        if (product.name.toLowerCase().includes(term)) return true;
                        
                        // Check variants
                        return product.variants.some(variant => {
                            // Check variant name or barcode
                            return variant.name.toLowerCase().includes(term) || 
                                (variant.barcode && variant.barcode.toLowerCase().includes(term));
                        });
                    });
                }
                
                let html = '';
                
                if (filteredProducts.length === 0) {
                    html = '<div class="text-muted text-center py-5">No products found</div>';
                } else {
                    filteredProducts.forEach(product => {
                        const hasVariants = product.variants.length > 1;
                        const price = hasVariants ? '' : `Rs ${product.variants[0].selling_price.toFixed(2)}`;
                        
                        // Handle image path
                        let imagePath = '/backend/assets/images/no_image.png';
                        try {
                            if (product.image_paths) {
                                const parsedPaths = typeof product.image_paths === 'string' 
                                    ? JSON.parse(product.image_paths) 
                                    : product.image_paths;
                                if (Array.isArray(parsedPaths) && parsedPaths.length > 0) {
                                    imagePath = parsedPaths[0].startsWith('http') ? parsedPaths[0] : '/' + parsedPaths[0];
                                }
                            }
                        } catch (e) {
                            console.error("Error parsing image paths:", e);
                        }

                        html += `
                            <div class="product-card" data-product-id="${product.id}" 
                                data-category-id="${product.category_id}"
                                data-variants="${hasVariants ? 'true' : 'false'}">
                                <img src="${imagePath}" alt="${product.name}" 
                                    onerror="this.src='/backend/assets/images/no_image.png'">
                                <div class="product-name">${product.name}</div>
                                ${hasVariants ? 
                                    `<div class="text-muted small">${product.variants.length} variants</div>` : 
                                    `<div class="product-price">${price}</div>`}
                            </div>
                        `;
                    });
                }
                
                $('#productGrid').html(html);
            }

            // Update customer dropdown
            function updateCustomerDropdown() {
                let html = '<option value="Walk-in-Customer" selected>Walk-in Customer</option>';
                
                allCustomers.forEach(customer => {
                    html += `<option value="${customer.id}">${customer.name} (${customer.phone})</option>`;
                });
                
                $('#customerSelect').html(html);
            }

            // Update branch info in header
            function updateBranchInfo() {
                if (currentBranch) {
                    $('.branch-info').text(`Branch: ${currentBranch.name}`);
                }
            }

            // Initialize event handlers
            function initializeEventHandlers() {
                // Category tab click
                $(document).on('click', '.category-tab', function() {
                    $('.category-tab').removeClass('active');
                    $(this).addClass('active');
                    
                    const categoryId = $(this).data('category-id');
                    renderProducts(categoryId);
                });
                

                // Product card click handler
                 $(document).on('click', '.product-card', function() {// Product card click handler on page relod show product variant model

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
                
                $('.payment-method-btn').on('click', function() { // Payment method selection
                    $('.payment-method-btn').removeClass('active');
                    $(this).addClass('active');
                    $('#paymentMethodId').val($(this).data('method-id'));
                });
                // Search button click
                $('#barcodeInput').on('keyup', function(e) {
                    const searchTerm = $(this).val().trim();
                    $('.category-tab').removeClass('active');
                    $('.search_active').addClass('active');
                    renderProducts('', searchTerm);
                });
                
                // Barcode scanner enter key
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
                
                $(document).on('click', '.remove-item', function() { // Cart item controls
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
                $('#clearCartBtn').on('click', function() {// Clear cart button
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
                            document.getElementById('posForm').reset();                            
                            $('#customerSelect').val('Walk-in-Customer').trigger('change');
                            $('#changeDue').text('Rs 0.00');
                            $('#dueBalance').text('Rs 0.00');
                        }
                    });
                    
                });
                $('#cartDiscount').on('change', function() {// Discount input
                    cart.updateCart();
                });
                $('#amountPaid').on('input', function() {// Amount paid input
                    cart.updateChangeDue();
                });
                $('.quick-cash-btn').on('click', function() {// Quick cash buttons
                    const amount = $(this).data('amount');
                    if (amount === 'total') {
                        $('#amountPaid').val($('#cartTotal').text().replace('Rs ', ''));
                    } else {
                        const currentAmount = parseFloat($('#amountPaid').val()) || 0;
                        $('#amountPaid').val(currentAmount + parseFloat(amount));
                    }
                    cart.updateChangeDue();
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
                
                $('#posForm').on('submit', function(e) {
                    e.preventDefault();
                    
                    if (cart.items.length === 0) {
                        alert('Please add items to the cart before completing the sale');
                        return;
                    }
                    
                    if (!$('#paymentMethodId').val()) {
                        alert('Please select a payment method');
                        return;
                    }
                    
                    const form = this;
                    const formData = new FormData(form);
                    showLoader("new sale creating..");
                    // Disable the submit button to prevent multiple submissions
                    $('#completeSaleBtn').prop('disabled', true).html('<i class="las la-spinner la-spin"></i> Processing...');
                    
                    $.ajax({
                        url: $(form).attr('action'),
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            $('#completeSaleBtn').prop('disabled', false).html('<i class="las la-check-circle"></i> Complete Sale');
                            
                            if (response.success) {
                                // Clear the cart
                                cart.clear();
                                document.getElementById('posForm').reset();
                                
                                // Reset payment displays
                                $('#changeDue').text('Rs 0.00');
                                $('#dueBalance').text('Rs 0.00');
                                $('#amountPaid').val('0');
                                $('#cartDiscount').val('0');
                                
                                const newInvoiceNumber = 'MD-' + new Date().toISOString().replace(/[^0-9]/g, '').slice(0, -5);
                                $('input[name="invoice_number"]').val(newInvoiceNumber);

                                $('#customerSelect').val('Walk-in-Customer').trigger('change');
                                $('#paymentMethodId').val('');
                                $('.payment-method-btn').removeClass('active');
                                
                                // Show success message
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sale Completed',
                                    text: 'Invoice #' + response.invoice_number + ' has been created',
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                                
                                // Inject and show invoice
                                $('body').append(response.invoice_html);
                                var invoiceModal = new bootstrap.Modal(document.getElementById('invoiceModal'));
                                invoiceModal.show();
                                
                                // Remove modal when closed
                                $('#invoiceModal').on('hidden.bs.modal', function() {
                                    $(this).remove();
                                });
                            }
                            hideLoader();
                        },
                        error: function(xhr) {
                            $('#completeSaleBtn').prop('disabled', false).html('<i class="las la-check-circle"></i> Complete Sale');
                            
                            let errorMessage = 'An error occurred while processing the sale';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            } else if (xhr.responseText) {
                                try {
                                    const errorResponse = JSON.parse(xhr.responseText);
                                    if (errorResponse.message) {
                                        errorMessage = errorResponse.message;
                                    }
                                } catch (e) {
                                    errorMessage = xhr.responseText;
                                }
                            }
                            
                            Swal.fire({
                                icon: 'error',
                                title: 'Sale Failed',
                                text: errorMessage,
                            });
                        }
                    });
                });
            }
            function showVariantModel(productId) {
                showLoader("Loading variants..");
                
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
                                $(this).toggle(searchText.includes(searchTerm));
                            });
                        });
                        
                        var modal = new bootstrap.Modal(document.getElementById('variantModal'));
                        modal.show();
                        
                        // Focus on search input when modal is shown
                        $('#variantModal').on('shown.bs.modal', function() {
                            $('#variantSearchInput').focus();
                        });
                        
                    hideLoader();
                    
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
            // Initialize the POS system
            initializePOS();
        });

        jQuery(document).ready(function() {
            jQuery(".wrapper-menu").addClass("open");
            jQuery("body").addClass("sidebar-main");
        });

    </script>
    @endpush
</x-app-layout>