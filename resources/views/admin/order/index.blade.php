<x-app-layout>
    @push('css')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        /* .order-card {
            transition: all 0.3s ease;
            cursor: pointer;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
        }
        .order-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .order-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(to bottom, #6777ef, #3b41e5);
        }
        .order-status {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }
        .status-draft {
            color: #6c757d;
        }
        .status-confirmed {
            color: #0dcaf0;
        }
        .status-completed {
            color: #198754;
        }
        .status-cancelled {
            color: #dc3545;
        }
        .advanced-loader {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.8);
            z-index: 9999;
        }
        .loader-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }
        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #6777ef;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 15px;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .empty-state {
            display: none;
            text-align: center;
            padding: 40px 0;
        }
        .empty-state i {
            font-size: 60px;
            color: #ddd;
            margin-bottom: 20px;
        }
        .filter-section {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .order-card .badge {
            font-size: 85%;
        }
        .order-total {
            font-weight: 600;
            color: #6777ef;
        }
        .order-item-count {
            background-color: #f0f2f5;
            border-radius: 10px;
            padding: 2px 8px;
            font-size: 0.8rem;
        } */
 /* Advanced Loader Styles start */
        

    </style>
    @endpush

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title">Order Management</h4>
                            <p class="card-subtitle mb-0 text-muted" id="orderCount">Loading orders...</p>
                        </div>
                        <div>
                            <a href="{{ route('orders.create') }}" class="btn btn-primary btn-lg shadow-sm">
                                <i class="las la-cash-register"></i> New Order
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="filter-section animate__animated animate__fadeIn">
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label class="form-label">Status</label>
                                    <select class="form-control" id="statusFilter">
                                        <option value="">All Statuses</option>
                                        <option value="draft">Draft</option>
                                        <option value="confirmed">Confirmed</option>
                                        <option value="completed">Completed</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Date Range</label>
                                    <select class="form-control" id="dateFilter">
                                        <option value="">All Time</option>
                                        <option value="today">Today</option>
                                        <option value="week">This Week</option>
                                        <option value="month">This Month</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Search</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="searchInput" placeholder="Search orders...">
                                        <button class="btn btn-outline-secondary" type="button" id="clearSearch">
                                            <i class="las la-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="empty-state animate__animated animate__fadeIn">
                            <i class="las la-search"></i>
                            <h4>No orders found</h4>
                            <p class="text-muted">Try adjusting your search or filter criteria</p>
                        </div>
                        
                        <div class="row" id="ordersContainer">
                            <!-- Orders will be loaded here via AJAX -->
                        </div>
                        
                        <div class="d-flex justify-content-center mt-4" id="loadMoreContainer">
                            <button class="btn btn-outline-primary" id="loadMoreBtn">Load More</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Details Modal -->
    <div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Order Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="orderDetailsContent">
                    <!-- Order details will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="printInvoiceBtn">Print Invoice</button>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
        <script>
        $(document).ready(function() {


            let allOrders = [];
            let displayedOrders = [];
            let currentPage = 1;
            const ordersPerPage = 10;
            let currentOrderDetails = null;
            
            // Initialize the page
            initOrders();
            // Initialize orders
            function initOrders() {
                showLoader('Loading orders...');
                $.ajax({
                    url: "{{ route('json.orders.index') }}",
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            allOrders = response.orders;
                            updateOrderCount(allOrders.length);
                            renderOrders(allOrders.slice(0, ordersPerPage));
                            displayedOrders = allOrders.slice(0, ordersPerPage);
                            
                            // Initialize event listeners
                            initEventListeners();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'Failed to load orders'
                            });
                        }
                        hideLoader();
                    },
                    error: function(xhr) {
                        console.error(xhr);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Failed to load orders. Please try again.'
                        });
                        hideLoader();
                    }
                });
            }
            
            // Render orders to the container
            function renderOrders(orders) {
                if (orders.length === 0) {
                    $('#ordersContainer').hide();
                    $('.empty-state').show();
                    $('#loadMoreContainer').hide();
                    return;
                }
                
                $('.empty-state').hide();
                $('#ordersContainer').show();
                
                let html = '';
                
                orders.forEach(order => {
                    // Ensure total_amount is treated as a number
                    const totalAmount = typeof order.total_amount === 'string' ? 
                        parseFloat(order.total_amount) : order.total_amount;
                    
                    html += `
                        <div class="col-md-6 col-lg-4 mb-4 animate__animated animate__fadeIn">
                            <div class="order-card card h-100" data-id="${order.id}">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h5 class="card-title mb-1">Order #${order.order_number}</h5>
                                            <p class="text-muted small mb-0">${moment(order.created_at).format('MMM D, YYYY h:mm A')}</p>
                                        </div>
                                        <span class="order-status status-${order.status}">${order.status}</span>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <p class="mb-1"><strong>Customer:</strong> ${order.customer ? order.customer.name : 'Walk-in'}</p>
                                        <p class="mb-1"><strong>Items:</strong> <span class="order-item-count">${order.items ? order.items.length : 0}</span></p>
                                        <p class="mb-0"><strong>Total:</strong> <span class="order-total">$${totalAmount.toFixed(2)}</span></p>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge bg-light text-dark">
                                            <i class="las la-user"></i> ${order.user ? order.user.name : 'System'}
                                        </span>
                                        <button class="btn btn-sm btn-outline-primary view-details" data-id="${order.id}">
                                            <i class="las la-eye"></i> View
                                        </button>
                                    </div>

                                    <div class="btn-group mt-3 w-100">
                                        ${['draft', 'confirmed'].includes(order.status) ? `
                                            <a href="{{ url('/orders/${order.id}/edit') }}" class="btn btn-sm btn-primary">
                                                <i class="las la-edit"></i> Edit
                                            </a>
                                        ` : ''}
                                        
                                        ${order.status === 'confirmed' ? `
                                            <button class="btn btn-sm btn-success complete-order-btn" data-order-id="${order.id}">
                                                <i class="las la-check-circle"></i> Complete
                                            </button>
                                        ` : ''}
                                        
                                        ${['draft', 'confirmed'].includes(order.status) ? `
                                            <button class="btn btn-sm btn-danger cancel-order-btn" data-order-id="${order.id}">
                                                <i class="las la-times"></i> Cancel
                                            </button>
                                        ` : ''}
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });
                
                if (currentPage === 1) {
                    $('#ordersContainer').html(html);
                } else {
                    $('#ordersContainer').append(html);
                }
                
                // Show/hide load more button
                if (displayedOrders.length < allOrders.length) {
                    $('#loadMoreContainer').show();
                } else {
                    $('#loadMoreContainer').hide();
                }
            }
            
            // Filter orders client-side
            function filterOrders() {
                showLoader('Filtering orders...');
                const status = $('#statusFilter').val().toLowerCase();
                const dateRange = $('#dateFilter').val().toLowerCase();
                const searchTerm = $('#searchInput').val().toLowerCase();
                
                let filtered = allOrders;
                
                // Apply status filter
                if (status) {
                    filtered = filtered.filter(order => order.status.toLowerCase() === status);
                }
                
                // Apply date range filter
                if (dateRange) {
                    const now = moment();
                    filtered = filtered.filter(order => {
                        const orderDate = moment(order.created_at);
                        
                        if (dateRange === 'today') {
                            return orderDate.isSame(now, 'day');
                        } else if (dateRange === 'week') {
                            return orderDate.isSame(now, 'week');
                        } else if (dateRange === 'month') {
                            return orderDate.isSame(now, 'month');
                        }
                        return true;
                    });
                }
                
                // Apply search filter
                if (searchTerm) {
                    filtered = filtered.filter(order => {
                        return (
                            (order.order_number && order.order_number.toLowerCase().includes(searchTerm)) ||
                            (order.customer && order.customer.name && order.customer.name.toLowerCase().includes(searchTerm)) ||
                            (order.user && order.user.name && order.user.name.toLowerCase().includes(searchTerm)) ||
                            (order.status && order.status.toLowerCase().includes(searchTerm)) ||
                            (order.total_amount && order.total_amount.toString().includes(searchTerm))
                        );
                    });
                }
                
                // Reset to first page
                currentPage = 1;
                displayedOrders = filtered.slice(0, ordersPerPage);
                renderOrders(displayedOrders);
                updateOrderCount(filtered.length);
                hideLoader();
            }
            
            // Load more orders
            function loadMoreOrders() {
                showLoader('Loading more orders...');
                const status = $('#statusFilter').val().toLowerCase();
                const dateRange = $('#dateFilter').val().toLowerCase();
                const searchTerm = $('#searchInput').val().toLowerCase();
                
                let filtered = allOrders;
                
                if (status) filtered = filtered.filter(order => order.status.toLowerCase() === status);
                
                if (dateRange) {
                    const now = moment();
                    filtered = filtered.filter(order => {
                        const orderDate = moment(order.created_at);
                        if (dateRange === 'today') return orderDate.isSame(now, 'day');
                        if (dateRange === 'week') return orderDate.isSame(now, 'week');
                        if (dateRange === 'month') return orderDate.isSame(now, 'month');
                        return true;
                    });
                }
                
                if (searchTerm) {
                    filtered = filtered.filter(order => {
                        return (
                            (order.order_number && order.order_number.toLowerCase().includes(searchTerm)) ||
                            (order.customer && order.customer.name && order.customer.name.toLowerCase().includes(searchTerm)) ||
                            (order.user && order.user.name && order.user.name.toLowerCase().includes(searchTerm)) ||
                            (order.status && order.status.toLowerCase().includes(searchTerm)) ||
                            (order.total_amount && order.total_amount.toString().includes(searchTerm))
                        );
                    });
                }
                
                currentPage++;
                const startIndex = (currentPage - 1) * ordersPerPage;
                const endIndex = startIndex + ordersPerPage;
                const moreOrders = filtered.slice(startIndex, endIndex);
                
                displayedOrders = [...displayedOrders, ...moreOrders];
                renderOrders(moreOrders);
                
                if (displayedOrders.length >= filtered.length) {
                    $('#loadMoreContainer').hide();
                }
                hideLoader();
            }
            
            // View order details
            function viewOrderDetails(orderId) {
                showLoader('Loading order details...');
                
                // Find the order in our cached data
                const order = allOrders.find(o => o.id == orderId);
                
                if (order) {
                    currentOrderDetails = order;
                    
                    let itemsHtml = '';
                    if (order.items && order.items.length > 0) {
                        order.items.forEach(item => {
                            const price = typeof item.unit_price === 'string' ? 
                                parseFloat(item.unit_price) : item.unit_price;
                            const quantity = typeof item.quantity === 'string' ? 
                                parseFloat(item.quantity) : item.quantity;
                            
                            itemsHtml += `
                                <tr>
                                    <td>${item.product ? item.product.name : 'N/A'} ${item.variant ? '(' + item.variant.name + ')' : ''}</td>
                                    <td>${quantity}</td>
                                    <td>$${price.toFixed(2)}</td>
                                    <td>$${(price * quantity).toFixed(2)}</td>
                                </tr>
                            `;
                        });
                    }
                    
                    // Convert amounts to numbers if they're strings
                    const subtotal = typeof order.subtotal === 'string' ? 
                        parseFloat(order.subtotal) : order.subtotal;
                    const taxAmount = typeof order.tax_amount === 'string' ? 
                        parseFloat(order.tax_amount) : order.tax_amount;
                    const discountAmount = typeof order.discount_amount === 'string' ? 
                        parseFloat(order.discount_amount) : order.discount_amount;
                    const totalAmount = typeof order.total_amount === 'string' ? 
                        parseFloat(order.total_amount) : order.total_amount;
                    
                    const modalContent = `
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Order Information</h6>
                                <p><strong>Order #:</strong> ${order.order_number}</p>
                                <p><strong>Date:</strong> ${moment(order.created_at).format('MMM D, YYYY h:mm A')}</p>
                                <p><strong>Status:</strong> <span class="status-${order.status}">${order.status}</span></p>
                                <p><strong>Payment Method:</strong> ${order.payment_method || 'N/A'}</p>
                                <p><strong>Payment Status:</strong> ${order.payment_status || 'N/A'}</p>
                            </div>
                            <div class="col-md-6">
                                <h6>Customer Information</h6>
                                <p><strong>Name:</strong> ${order.customer ? order.customer.name : 'Walk-in Customer'}</p>
                                <p><strong>Phone:</strong> ${order.customer ? order.customer.phone : 'N/A'}</p>
                                <p><strong>Email:</strong> ${order.customer ? order.customer.email : 'N/A'}</p>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <h6>Order Items</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${itemsHtml || '<tr><td colspan="4" class="text-center">No items found</td></tr>'}
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-end">Subtotal:</th>
                                        <td>$${subtotal.toFixed(2)}</td>
                                    </tr>
                                    <tr>
                                        <th colspan="3" class="text-end">Tax:</th>
                                        <td>$${taxAmount.toFixed(2)}</td>
                                    </tr>
                                    <tr>
                                        <th colspan="3" class="text-end">Discount:</th>
                                        <td>$${discountAmount.toFixed(2)}</td>
                                    </tr>
                                    <tr>
                                        <th colspan="3" class="text-end">Total:</th>
                                        <td>$${totalAmount.toFixed(2)}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    `;
                    
                    $('#orderDetailsContent').html(modalContent);
                    $('#orderDetailsModal').modal('show');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Order details not found.'
                    });
                }
                
                hideLoader();
            }
            
            // Print invoice
            function printInvoice() {
                if (!currentOrderDetails) return;
                
                // Create a printable version of the order details
                const printContent = `
                    <div style="padding: 20px; font-family: Arial, sans-serif;">
                        <h2 style="text-align: center; margin-bottom: 20px;">Invoice</h2>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 30px;">
                            <div>
                                <h3>Order Information</h3>
                                <p><strong>Order #:</strong> ${currentOrderDetails.order_number}</p>
                                <p><strong>Date:</strong> ${moment(currentOrderDetails.created_at).format('MMM D, YYYY h:mm A')}</p>
                                <p><strong>Status:</strong> ${currentOrderDetails.status}</p>
                            </div>
                            <div>
                                <h3>Customer Information</h3>
                                <p><strong>Name:</strong> ${currentOrderDetails.customer ? currentOrderDetails.customer.name : 'Walk-in Customer'}</p>
                                <p><strong>Phone:</strong> ${currentOrderDetails.customer ? currentOrderDetails.customer.phone : 'N/A'}</p>
                            </div>
                        </div>
                        
                        <h3>Order Items</h3>
                        <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px;">
                            <thead>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <th style="text-align: left; padding: 8px;">Product</th>
                                    <th style="text-align: right; padding: 8px;">Qty</th>
                                    <th style="text-align: right; padding: 8px;">Price</th>
                                    <th style="text-align: right; padding: 8px;">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${currentOrderDetails.items && currentOrderDetails.items.length > 0 ? 
                                    currentOrderDetails.items.map(item => {
                                        const price = typeof item.unit_price === 'string' ? 
                                            parseFloat(item.unit_price) : item.unit_price;
                                        const quantity = typeof item.quantity === 'string' ? 
                                            parseFloat(item.quantity) : item.quantity;
                                        return `
                                            <tr style="border-bottom: 1px solid #eee;">
                                                <td style="padding: 8px;">${item.product ? item.product.name : 'N/A'} ${item.variant ? '(' + item.variant.name + ')' : ''}</td>
                                                <td style="text-align: right; padding: 8px;">${quantity}</td>
                                                <td style="text-align: right; padding: 8px;">$${price.toFixed(2)}</td>
                                                <td style="text-align: right; padding: 8px;">$${(price * quantity).toFixed(2)}</td>
                                            </tr>
                                        `;
                                    }).join('') : 
                                    '<tr><td colspan="4" style="text-align: center; padding: 8px;">No items found</td></tr>'}
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" style="text-align: right; padding: 8px;">Subtotal:</th>
                                    <td style="text-align: right; padding: 8px;">$${(typeof currentOrderDetails.subtotal === 'string' ? 
                                        parseFloat(currentOrderDetails.subtotal) : currentOrderDetails.subtotal).toFixed(2)}</td>
                                </tr>
                                <tr>
                                    <th colspan="3" style="text-align: right; padding: 8px;">Tax:</th>
                                    <td style="text-align: right; padding: 8px;">$${(typeof currentOrderDetails.tax_amount === 'string' ? 
                                        parseFloat(currentOrderDetails.tax_amount) : currentOrderDetails.tax_amount).toFixed(2)}</td>
                                </tr>
                                <tr>
                                    <th colspan="3" style="text-align: right; padding: 8px;">Discount:</th>
                                    <td style="text-align: right; padding: 8px;">$${(typeof currentOrderDetails.discount_amount === 'string' ? 
                                        parseFloat(currentOrderDetails.discount_amount) : currentOrderDetails.discount_amount).toFixed(2)}</td>
                                </tr>
                                <tr>
                                    <th colspan="3" style="text-align: right; padding: 8px; border-top: 1px solid #ddd;">Total:</th>
                                    <td style="text-align: right; padding: 8px; border-top: 1px solid #ddd;">$${(typeof currentOrderDetails.total_amount === 'string' ? 
                                        parseFloat(currentOrderDetails.total_amount) : currentOrderDetails.total_amount).toFixed(2)}</td>
                                </tr>
                            </tfoot>
                        </table>
                        
                        <div style="margin-top: 40px; text-align: center; font-size: 0.9em; color: #666;">
                            <p>Thank you for your business!</p>
                            <p>Generated on ${moment().format('MMM D, YYYY h:mm A')}</p>
                        </div>
                    </div>
                `;
                
                // Open print window
                const printWindow = window.open('', '_blank');
                printWindow.document.write(`
                    <html>
                        <head>
                            <title>Invoice #${currentOrderDetails.order_number}</title>
                            <style>
                                @media print {
                                    body { -webkit-print-color-adjust: exact; }
                                }
                            </style>
                        </head>
                        <body>
                            ${printContent}
                            <script>
                                window.onload = function() {
                                    setTimeout(function() {
                                        window.print();
                                        window.close();
                                    }, 100);
                                };
                            <\/script>
                        </body>
                    </html>
                `);
                printWindow.document.close();
            }
            
            // Update order count display
            function updateOrderCount(count) {
                let text = `${count} order${count !== 1 ? 's' : ''} found`;
                $('#orderCount').text(text);
            }
            
            // Initialize event listeners
            function initEventListeners() {
                // Filter events
                $('#statusFilter, #dateFilter').change(function() {
                    filterOrders();
                });
                
                // Search event
                $('#searchInput').keyup(function() {
                    filterOrders();
                });
                
                // Clear search
                $('#clearSearch').click(function() {
                    $('#searchInput').val('');
                    filterOrders();
                });
                
                // Load more
                $('#loadMoreBtn').click(function() {
                    loadMoreOrders();
                });
                
                // View details
                $(document).on('click', '.view-details', function(e) {
                    e.stopPropagation();
                    const orderId = $(this).data('id');
                    viewOrderDetails(orderId);
                });
                
                // Print invoice
                $('#printInvoiceBtn').click(function() {
                    printInvoice();
                });

                // Complete order
                $(document).on('click', '.complete-order-btn', function(e) {
                    e.stopPropagation();
                    const orderId = $(this).data('order-id');
                    completeOrder(orderId);
                });
                
                // Cancel order
                $(document).on('click', '.cancel-order-btn', function(e) {
                    e.stopPropagation();
                    const orderId = $(this).data('order-id');
                    updateOrderStatus(orderId, 'cancelled');
                });
            }

            // Complete order function
            function completeOrder(orderId) {
                
                
                Swal.fire({
                    title: 'Complete Order',
                    text: 'Are you sure you want to complete this order? This will convert it to a sale.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, complete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        showLoader('Completing order...');
                        $.ajax({
                            url: "/orders/" + orderId + "/complete",
                            type: 'POST',
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                if (response.success) {
                                    // Update the order in our local data
                                    const orderIndex = allOrders.findIndex(o => o.id == orderId);
                                    if (orderIndex !== -1) {
                                        allOrders[orderIndex].status = 'completed';
                                        // Re-render the orders to reflect the change
                                        renderOrders(displayedOrders);
                                    }
                                    
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Order Completed',
                                        text: 'The order has been successfully completed and converted to a sale.',
                                        showConfirmButton: false,
                                        timer: 2000
                                    });

                                    // Optionally open print dialog
                                    if (response.print_url) {
                                        window.open(response.print_url, '_blank');
                                    }
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        response.message || 'Failed to complete order',
                                        'error'
                                    );
                                }
                                hideLoader();
                            },
                            error: function(xhr) {
                                hideLoader();
                                Swal.fire(
                                    'Error!',
                                    xhr.responseJSON?.message || 'Failed to complete order',
                                    'error'
                                );
                            }
                        });
                    } else {
                        hideLoader();
                    }
                });
            }

            // Update order status (cancel)
            function updateOrderStatus(orderId, status) {
                
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: `Do you want to ${status} this order?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: `Yes, ${status} it!`
                }).then((result) => {
                    if (result.isConfirmed) {
                        showLoader('Updating order status...');
                        $.ajax({
                            url: "{{ url('/orders') }}/" + orderId + "/cancel",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                status: status
                            },
                            success: function(response) {
                                if (response.success) {
                                    // Update the order in our local data
                                    const orderIndex = allOrders.findIndex(o => o.id == orderId);
                                    if (orderIndex !== -1) {
                                        allOrders[orderIndex].status = status;
                                        // Re-render the orders to reflect the change
                                        renderOrders(displayedOrders);
                                    }
                                    
                                    Swal.fire(
                                        'Success!',
                                        `Order has been ${status}.`,
                                        'success'
                                    );
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        response.message || 'Failed to update order status',
                                        'error'
                                    );
                                }
                                hideLoader();
                            },
                            error: function(xhr) {
                                hideLoader();
                                Swal.fire(
                                    'Error!',
                                    xhr.responseJSON?.message || 'Failed to update order status',
                                    'error'
                                );
                            }
                        });
                    } else {
                        hideLoader();
                    }
                });
            }
        });
        </script>
    @endpush
</x-app-layout>