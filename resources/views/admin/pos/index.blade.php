<x-app-layout>
    @push('css')
    <link rel="stylesheet" href="{{ asset('Backend/assets/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Backend/assets/css/backend.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('Backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Backend/assets/vendor/remixicon/fonts/remixicon.css')}}">
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
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
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
        @media (max-width: 768px) {
            .product-grid {
                grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            }            
            .payment-methods, .quick-cash-buttons {
                grid-template-columns: repeat(2, 1fr);
            }            
            .category-tabs {
                overflow-x: auto;
                white-space: nowrap;
                display: block;
                padding-bottom: 5px;
            }            
            .category-tab {
                display: inline-block;
            }
        }        
        @media (max-width: 576px) {
            .product-grid {
                grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
            }            
            .cart-item {
                flex-direction: column;
            }            
            .cart-item-controls {
                justify-content: flex-end;
            }            
            .product-card img {
                height: 50px;
            }            
            .product-name {
                font-size: 0.9rem;
            }
        }
        .category-tabs {
            display: flex;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            flex-wrap: nowrap;
        }        
        .category-tab {
            padding: 8px 15px;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            white-space: nowrap;
        }        
        .category-tab.active {
            border-bottom: 2px solid #0d6efd;
            color: #0d6efd;
        }        
        .payment-methods {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 5px;
            margin: 10px 0;
        }        
        .payment-method-btn {
            padding: 8px;
            text-align: center;
            background: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }        
        .payment-method-btn.active {
            background: #0d6efd;
            color: white;
            border-color: #0d6efd;
        }        
        .quick-cash-buttons {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 5px;
            margin: 10px 0;
        }        
        .quick-cash-btn {
            padding: 8px;
            text-align: center;
            background: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
        }  
        ::-webkit-scrollbar {/* Scrollbar styling */
            width: 8px;
            height: 8px;
        }        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }        
        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }        
        ::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
            .category-tabs-container { /* Updated Category Tabs Styles */
                position: relative;
                margin-bottom: 15px;
            }            
            .category-tabs {
                display: flex;
                overflow-x: auto;
                scrollbar-width: none; /* Firefox */
                -ms-overflow-style: none; /* IE/Edge */
                padding-bottom: 5px;
                margin-bottom: -5px; /* Compensate for padding */
            }        
            .category-tabs::-webkit-scrollbar {
                display: none; /* Chrome/Safari */
            }            
            .category-tab {
                flex: 0 0 auto;
                padding: 8px 15px;
                cursor: pointer;
                border-bottom: 2px solid transparent;
                white-space: nowrap;
                position: relative;
            }            
            .category-tab.active {
                border-bottom: 2px solid #0d6efd;
                color: #0d6efd;
            }
            .category-nav-arrow { /* Navigation arrows for foldable devices */
                position: absolute;
                top: 0;
                bottom: 0;
                width: 30px;
                background: rgba(255,255,255,0.8);
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                z-index: 10;
                opacity: 0;
                transition: opacity 0.3s;
            }            
            .category-nav-arrow.left {
                left: 0;
                background: linear-gradient(90deg, rgba(255,255,255,0.9) 0%, rgba(255,255,255,0) 100%);
            }            
            .category-nav-arrow.right {
                right: 0;
                background: linear-gradient(270deg, rgba(255,255,255,0.9) 0%, rgba(255,255,255,0) 100%);
            }            
            .category-tabs-container:hover .category-nav-arrow {
                opacity: 1;
            }                        
            @media (max-width: 1200px) {/* Responsive adjustments */
                .category-tab {
                    padding: 8px 12px;
                    font-size: 0.9rem;
                }
            }            
            @media (max-width: 768px) {
                .category-tab {
                    padding: 8px 10px;
                    font-size: 0.85rem;
                }                
                .category-nav-arrow {
                    opacity: 1; /* Always show on mobile */
                    width: 25px;
                }
            }
    </style>
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
                        <form id="posForm" action="{{ route('sales.store') }}" method="POST">
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
                                    <div class="category-tabs-container">
                                        <div class="category-nav-arrow left">
                                            <i class="las la-angle-left"></i>
                                        </div>
                                        <div class="category-tabs">
                                            <div class="category-tab active" data-category-id="">All Products</div>
                                            @foreach($categories as $category)
                                                <div class="category-tab" data-category-id="{{ $category->id }}">{{ $category->name }}</div>
                                            @endforeach
                                        </div>
                                        <div class="category-nav-arrow right">
                                            <i class="las la-angle-right"></i>
                                        </div>
                                    </div>
                                    <div class="product-grid" id="productGrid">
                                        @foreach($products as $product)
                                            <div class="product-card" data-product-id="{{ $product->id }}" 
                                                data-variants="{{ $product->variants->count() > 1 ? 'true' : 'false' }}">
                                                @if($product->image_paths)
                                                    <img src="{{ json_decode('Backend/'.$product->image_paths)[0] ?? asset('Backend/assets/images/brake_system.jpg') }}" alt="{{ $product->name }}">
                                                @else
                                                    <img src="{{ asset('Backend/assets/images/brake_system.jpg') }}" alt="{{ $product->name }}">
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
                                <div class="cart-container">
                                    <div class="mb-3">
                                        <select id="customerSelect" class="form-control">
                                            <option value="0">Walk-in Customer</option>
                                            @foreach($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->phone }})</option>
                                            @endforeach
                                        </select>
                                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="addCustomerBtn"><i class="las la-user-plus"></i> New Customer</button>
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
                                        <div class="payment-methods"><!-- Payment Methods -->
                                            @foreach($paymentMethods as $method)
                                                <div class="payment-method-btn" data-method-id="{{ $method->id }}">
                                                    {{ $method->name }}
                                                </div>
                                            @endforeach
                                        </div>
                                        <input type="hidden" name="payment_method_id" id="paymentMethodId"> 
                                        <div class="mb-3"><!-- Payment Reference -->
                                            <label>Payment Reference</label>
                                            <input type="text" class="form-control" name="payment_reference" id="paymentReference" placeholder="Optional reference">
                                        </div>
                                        <div class="mb-3"><!-- Amount Paid -->
                                            <label>Amount Paid</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rs</span>
                                                <input type="number" step="0.01" min="0" class="form-control" name="amount_paid" id="amountPaid" value="0">
                                            </div>
                                        </div>
                                        <div class="quick-cash-buttons"><!-- Quick Cash Buttons -->
                                            <button type="button" class="quick-cash-btn" data-amount="500">500</button>
                                            <button type="button" class="quick-cash-btn" data-amount="1000">1000</button>
                                            <button type="button" class="quick-cash-btn" data-amount="2000">2000</button>
                                            <button type="button" class="quick-cash-btn" data-amount="5000">5000</button>
                                            <button type="button" class="quick-cash-btn" data-amount="10000">10000</button>
                                            <button type="button" class="quick-cash-btn" data-amount="total">Exact</button>
                                        </div>
                                        <div class="summary-row mb-3"> <!-- Change Due -->
                                            <span>Change Due:</span>
                                            <span id="changeDue">Rs 0.00</span>
                                        </div>
                                        <div class="mb-3"><!-- Notes -->
                                            <label>Notes</label>
                                            <textarea name="notes" class="form-control" rows="2"></textarea>
                                        </div>
                                        <div class="d-grid gap-2"><!-- Action Buttons -->
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
                            <div id="cartItemsData"></div> <!-- Hidden fields for cart items -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="variantModal" tabindex="-1" aria-hidden="true"> <!-- Variant Selection Modal -->
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select Variant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="variantModalBody"><!-- Variant options will be loaded here --></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="customerModal" tabindex="-1" aria-hidden="true"> <!-- New Customer Modal -->
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
        <script src="{{ asset('Backend/assets/js/backend-bundle.min.js') }}"></script>
        <script src="{{ asset('Backend/assets/js/table-treeview.js') }}"></script>
        <script src="{{ asset('Backend/assets/js/customizer.js') }}"></script>
        <script async src="{{ asset('Backend/assets/js/chart-custom.js') }}"></script>
        <script src="{{ asset('Backend/assets/js/app.js') }}"></script>
        
        <script>
        $(document).ready(function() {
            const cart = {
                items: [],
                addItem: function(productId, variantId, quantity = 1, price, costPrice, name, variantName) {
                    price = typeof price === 'string' ? parseFloat(price) : price; // Convert prices to numbers if they're strings
                    costPrice = typeof costPrice === 'string' ? parseFloat(costPrice) : costPrice;                    
                    
                    const existingItem = this.items.find(item =>  // Check if item already exists in cart
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
                    const cartItemsEl = $('#cartItems');// Update cart UI
                    
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
                    
                    const totals = this.calculateTotals();// Update totals
                    $('#cartSubtotal').text('Rs ' + totals.subtotal.toFixed(2));
                    $('#cartTax').text('Rs ' + totals.tax.toFixed(2));
                    $('#cartTotal').text('Rs ' + totals.total.toFixed(2));
                    
                    $('#formSubtotal').val(totals.subtotal);// Update hidden form fields
                    $('#formTaxAmount').val(totals.tax);
                    $('#formDiscountAmount').val(totals.discount);
                    $('#formTotalAmount').val(totals.total);
                    
                    if ($('#amountPaid').val() === $('#cartTotal').text().replace('Rs ', '')) { // Update amount paid if set to "total"
                        $('#amountPaid').val(totals.total.toFixed(2));
                        this.updateChangeDue();
                    } else {
                        this.updateChangeDue();
                    }
                    this.updateFormData();// Update hidden fields for form submission
                },
                updateChangeDue: function() {
                    const total = parseFloat($('#cartTotal').text().replace('Rs ', '')) || 0;
                    const amountPaid = parseFloat($('#amountPaid').val()) || 0;
                    const changeDue = Math.max(0, amountPaid - total);                    
                    $('#changeDue').text('Rs ' + changeDue.toFixed(2));
                },
                updateFormData: function() {
                    $('#formCustomerId').val($('#customerSelect').val());// Update customer ID                    
                    
                    let itemsHtml = ''; // Update cart items data
                    this.items.forEach((item, index) => {
                        itemsHtml += `
                            <input type="hidden" name="items[${index}][product_id]" value="${item.productId}">
                            <input type="hidden" name="items[${index}][variant_id]" value="${item.variantId}">
                            <input type="hidden" name="items[${index}][quantity]" value="${item.quantity}">
                            <input type="hidden" name="items[${index}][unit_price]" value="${item.price}">
                            <input type="hidden" name="items[${index}][cost_price]" value="${item.costPrice}">
                            <input type="hidden" name="items[${index}][tax_rate]" value="0">
                            <input type="hidden" name="items[${index}][discount_rate]" value="0">
                        `;
                    });
                    $('#cartItemsData').html(itemsHtml);
                }
            };
            function initPOS() {        // Initialize POS functionality         
                $('.product-card').on('click', function() {// Product card click handler on page relod show product variant model

                    const productId = $(this).data('product-id');
                    const hasVariants = $(this).data('variants');
                    
                    if (hasVariants) {
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
                                        data-variant-name="${variant.name}">
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
                            
                            var modal = new bootstrap.Modal(document.getElementById('variantModal'));// Initialize and show modal
                            modal.show();
                            
                        }).fail(function(error) {
                            console.error("Error loading variants:", error);
                        });
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
                
                $(document).on('click', '.variant-option', function() { // Variant selection in modal
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
                    if (confirm('Are you sure you want to clear the cart?')) {
                        cart.clear();
                    }
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
                $('.payment-method-btn').on('click', function() { // Payment method selection
                    $('.payment-method-btn').removeClass('active');
                    $(this).addClass('active');
                    $('#paymentMethodId').val($(this).data('method-id'));
                });
                $('#barcodeInput').on('keypress', function(e) { // Barcode scanner input
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
                                    alert('Product not found!');
                                }
                            }).fail(function() {
                                alert('Error looking up product');
                            });
                        }
                    }
                });
                $('#searchProductBtn').on('click', function() { // Search product button
                    const searchTerm = $('#barcodeInput').val().trim();
                    
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
                                            <img src="${product.image_paths ? JSON.parse(product.image_paths)[0] : 'Backend/assets/images/brake_system.jpg'}" 
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
                            $('.product-card').on('click', function() {// Rebind click events for new product cards
                                alert('new Product')
                                const productId = $(this).data('product-id');
                                const hasVariants = $(this).data('variants');
                                
                                if (hasVariants) {
                                    $.get(`/products/${productId}/variants_data`, function(variants) {// Show variant selection modal
                                        let modalBody = '';
                                        
                                        variants.forEach(variant => {
                                            modalBody += `
                                                <div class="mb-2 variant-option" 
                                                    data-product-id="${productId}"
                                                    data-variant-id="${variant.id}"
                                                    data-price="${variant.selling_price}"
                                                    data-cost="${variant.purchase_price}"
                                                    data-name="${variant.product.name}"
                                                    data-variant-name="${variant.name}">
                                                    <div class="d-flex justify-content-between align-items-center p-2 border rounded">
                                                        <div>
                                                            <strong>${variant.name}</strong>
                                                            <div class="small">SKU: ${variant.sku}</div>
                                                        </div>
                                                        <div>
                                                            <div>Rs ${variant.selling_price.toFixed(2)}</div>
                                                            <div class="small text-muted">Stock: ${variant.current_stock}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            `;
                                        });
                                        
                                        $('#variantModalBody').html(modalBody);
                                        $('#variantModal').modal('show');
                                    });
                                } else {                                    
                                    const productName = $(this).find('.product-name').text();// Add directly to cart (single variant)
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
                        });
                    }
                });
                
                $('.category-tab').on('click', function() {// Category tabs

                    $('.category-tab').removeClass('active');
                    $(this).addClass('active');
                    const categoryId = $(this).data('category-id');                    
                    if (categoryId) {
                        $.get(`/categories/${categoryId}/products`, function(products) {
                            updateProductGrid(products);
                        });
                    } else {
                        $.get('/pos_products', function(products) {// Show all products
                            updateProductGrid(products);
                        });
                    }
                });
                $('#addCustomerBtn').on('click', function() { // Add customer button
                    $('#customerModal').modal('show');
                });
                $('#saveCustomerBtn').on('click', function() { // Save customer button
                    const customerData = {
                        name: $('#newCustomerName').val(),
                        phone: $('#newCustomerPhone').val(),
                        email: $('#newCustomerEmail').val(),
                        address: $('#newCustomerAddress').val(),
                        tenant_id: {{ auth()->user()->tenant_id }}
                    };
                    if (!customerData.name || !customerData.phone) {
                        alert('Name and phone are required');
                        return;
                    }
                    $.post('/customers', customerData, function(response) {                        
                        $('#customerSelect').append( // Add new customer to dropdown
                            `<option value="${response.id}">${response.name} (${response.phone})</option>`
                        ).val(response.id);
                        $('#newCustomerName').val(''); // Clear form
                        $('#newCustomerPhone').val('');
                        $('#newCustomerEmail').val('');
                        $('#newCustomerAddress').val('');
                        $('#customerModal').modal('hide');
                    }).fail(function() {
                        alert('Error saving customer');
                    });
                });
                
                $('#customerSelect').on('change', function() { // Customer select change
                    $('#formCustomerId').val($(this).val());
                });
                
                $('#posForm').on('submit', function(e) { // Form submission
                    if (cart.items.length === 0) {
                        e.preventDefault();
                        alert('Please add items to the cart before completing the sale');
                        return;
                    }
                    
                    if (!$('#paymentMethodId').val()) {
                        e.preventDefault();
                        alert('Please select a payment method');
                        return;
                    }
                    
                    const formData = new FormData(this); // Debug: Log form data before submission
                    const formDataObj = {};
                    formData.forEach((value, key) => {
                        formDataObj[key] = value;
                    });
                    console.log('Form data being submitted:', formDataObj);
                    
                    const amountPaid = parseFloat($('#amountPaid').val()) || 0;
                    const total = parseFloat($('#cartTotal').text().replace('Rs ', '')) || 0;
                    
                    if (amountPaid < total) {
                        if (!confirm('Amount paid is less than total. This will create a partial payment. Continue?')) {
                            e.preventDefault();
                            return;
                        }
                    }
                });
            }
            function updateProductGrid(products) {
                console.log(products);
                let html = '';                
                if (products.length === 0) {
                    html = '<div class="text-muted text-center py-5">No products found in this category</div>';
                } else {
                    products.forEach(product => {
                        const hasAnyVariants = product.variants && product.variants.length > 0;  // Check if product has any variants at all                       
                        const hasMultipleVariants = hasAnyVariants && product.variants.length > 1; // Check if product has multiple variants (for modal)
                        
                        let priceDisplay = ''; // Price display logic
                        if (hasAnyVariants && !hasMultipleVariants) {
                            priceDisplay = `Rs ${product.variants[0].selling_price.toFixed(2)}`;
                        } else if (!hasAnyVariants) {
                            priceDisplay = 'Rs 0.00'; // Default for products with no variants
                        }
                        
                        html += `
                            <div class="product-card" data-product-id="${product.id}" 
                                data-has-variants="${hasAnyVariants ? 'true' : 'false'}"
                                data-multiple-variants="${hasMultipleVariants ? 'true' : 'false'}">
                                <img src="${product.image_paths ? JSON.parse(product.image_paths)[0] : 'Backend/assets/images/download.jpeg'}" 
                                    alt="${product.name}">
                                <div class="product-name">${product.name}</div>
                                ${hasMultipleVariants ? 
                                    `<div class="text-muted small">${product.variants.length} variants</div>` : 
                                    `<div class="product-price">${priceDisplay}</div>`}
                            </div>
                        `;
                    });
                }
                
                $('#productGrid').html(html);
                $('.product-card').on('click', function() { // Rebind click events for new product cards
                    const productId = $(this).data('product-id');
                    const hasVariants = $(this).data('has-variants');
                    const hasMultipleVariants = $(this).data('multiple-variants');
                    
                    if (hasMultipleVariants) {
                        $.get(`/products/${productId}/variants_data`, function(variants) { // Show variant selection modal for products with multiple variants
                            if (variants && variants.length > 0) {
                                let modalBody = '';
                                
                                variants.forEach(variant => {
                                    modalBody += `
                                        <div class="mb-2 variant-option" 
                                            data-product-id="${productId}"
                                            data-variant-id="${variant.id}"
                                            data-price="${variant.selling_price}"
                                            data-cost="${variant.purchase_price}"
                                            data-name="${variant.product?.name || ''}"
                                            data-variant-name="${variant.name}">
                                            <div class="d-flex justify-content-between align-items-center p-2 border rounded">
                                                <div>
                                                    <strong>${variant.name}</strong>
                                                    <div class="small">SKU: ${variant.sku}</div>
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
                                var modal = new bootstrap.Modal(document.getElementById('variantModal'));// Initialize and show modal
                                modal.show();
                            } else {
                                alert('No variants found for this product');
                            }
                        }).fail(function(error) {
                            console.error("Error loading variants:", error);
                            alert('Error loading variants');
                        });
                    } else if (hasVariants) {
                        const productName = $(this).find('.product-name').text(); // Single variant case - add directly to cart
                        const priceText = $(this).find('.product-price').text();
                        const price = parseFloat(priceText.replace('Rs ', '')) || 0;
                        
                        $.get(`/products/${productId}`, function(product) {  // Get product details via API
                            if (product.variants && product.variants.length === 1) {
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
                            } else {
                                cart.addItem(// Fallback for unexpected cases
                                    productId, 
                                    null, 
                                    1, 
                                    price, 
                                    price * 0.8, // Default cost price
                                    productName,
                                    'Default'
                                );
                            }
                        }).fail(function() {
                            cart.addItem( // Fallback if API fails
                                productId, 
                                null, 
                                1, 
                                price, 
                                price * 0.8, // Default cost price
                                productName,
                                'Default'
                            );
                        });
                    } else {
                        const productName = $(this).find('.product-name').text(); // No variants case
                        const priceText = $(this).find('.product-price').text();
                        const price = parseFloat(priceText.replace('Rs ', '')) || 0;
                        
                        cart.addItem(
                            productId, 
                            null, 
                            1, 
                            price, 
                            price * 0.8, // Default cost price
                            productName,
                            'Default'
                        );
                    }
                });
            }
            initPOS();
        });
        </script>
        <script>
            $(document).ready(function() {
                const tabsContainer = $('.category-tabs');
                const leftArrow = $('.category-nav-arrow.left');
                const rightArrow = $('.category-nav-arrow.right');
                updateArrowVisibility();// Check scroll position on load                
                tabsContainer.on('scroll', updateArrowVisibility);// Update arrow visibility on scroll                
                leftArrow.on('click', function() { // Navigation arrow click handlers
                    tabsContainer.animate({scrollLeft: tabsContainer.scrollLeft() - 200}, 300);
                });
                rightArrow.on('click', function() {
                    tabsContainer.animate({scrollLeft: tabsContainer.scrollLeft() + 200}, 300);
                });
                $(window).on('resize', updateArrowVisibility); // Handle window resize
                function updateArrowVisibility() {
                    const scrollLeft = tabsContainer.scrollLeft();
                    const scrollWidth = tabsContainer[0].scrollWidth;
                    const clientWidth = tabsContainer[0].clientWidth;
                    
                    leftArrow.toggle(scrollLeft > 0);
                    rightArrow.toggle(scrollLeft < (scrollWidth - clientWidth - 1));
                }
            });
            </script>
    @endpush
</x-app-layout>