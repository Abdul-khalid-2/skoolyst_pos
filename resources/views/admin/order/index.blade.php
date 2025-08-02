<x-app-layout>
    @push('css')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css')}}">
    <style>
        .order-card {
            transition: all 0.3s;
            cursor: pointer;
        }
        .order-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .order-status {
            font-weight: bold;
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
    </style>
    @endpush

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="card-title">Order Management</h4>
                        <div>
                            <a href="{{ route('orders.create') }}" class="btn btn-primary">
                                <i class="las la-cash-register"></i> New Order
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <select class="form-control" id="statusFilter">
                                    <option value="">All Statuses</option>
                                    <option value="draft">Draft</option>
                                    <option value="confirmed">Confirmed</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control" id="storageFilter">
                                    <option value="">All Types</option>
                                    <option value="session">Session Orders</option>
                                    <option value="database">Saved Orders</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="searchInput" placeholder="Search orders...">
                            </div>
                        </div>
                        
                        <div class="row" id="ordersContainer">
                            @foreach($orders as $order)
                                @include('admin.order.partial.order-card', ['order' => $order])
                            @endforeach
                        </div>
                    </div>
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
        // Filter orders by status
        $('#statusFilter').change(function() {
            filterOrders();
        });
        
        // Filter orders by storage type
        $('#storageFilter').change(function() {
            filterOrders();
        });
        
        // Search orders
        $('#searchInput').keyup(function() {
            filterOrders();
        });
        
        function filterOrders() {
            const status = $('#statusFilter').val();
            const storageType = $('#storageFilter').val();
            const searchTerm = $('#searchInput').val().toLowerCase();
            
            $.ajax({
                url: "{{ route('orders.filter') }}",
                type: "GET",
                data: {
                    status: status,
                    storage_type: storageType,
                    search: searchTerm
                },
                success: function(response) {
                    $('#ordersContainer').html(response);
                }
            });
        }
    });
    </script>
    @endpush
</x-app-layout>