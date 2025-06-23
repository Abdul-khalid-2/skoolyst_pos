<x-app-layout>
    @push('css')
        <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.ico') }}" />
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css') }}">
    @endpush

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Customer Details</h4>
                        </div>
                        <div>
                            <a href="{{ route('customers.index') }}" class="btn btn-primary">
                                <i class="fas fa-arrow-left"></i> Back to Customers
                            </a>
                            <a href="{{ route('customers.invoice', $customer->id) }}" class="btn btn-info ms-2">
                                <i class="fas fa-file-invoice"></i> Generate Invoice
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0">Basic Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-borderless mb-0">
                                                <tbody>
                                                    <tr>
                                                        <th width="30%">Name:</th>
                                                        <td>{{ $customer->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Email:</th>
                                                        <td>{{ $customer->email ?? 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Phone:</th>
                                                        <td>{{ $customer->phone }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Customer Group:</th>
                                                        <td>
                                                            <span class="badge bg-{{ $customer->customer_group == 'vip' ? 'danger' : ($customer->customer_group == 'wholesale' ? 'info' : 'primary') }}">
                                                                {{ ucfirst($customer->customer_group) }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Tax Number:</th>
                                                        <td>{{ $customer->tax_number ?? 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Credit Limit:</th>
                                                        <td>{{ number_format($customer->credit_limit, 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Current Balance:</th>
                                                        <td>
                                                            <span class="badge bg-{{ $customer->balance >= 0 ? 'success' : 'danger' }}">
                                                                {{ number_format($customer->balance, 2) }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0">Address</h5>
                                    </div>
                                    <div class="card-body">
                                        <p>{{ $customer->address ?? 'No address provided' }}</p>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0">Purchase Summary</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-borderless mb-0">
                                                <tbody>
                                                    <tr>
                                                        <th width="50%">Total Orders:</th>
                                                        <td>{{ $sales->count() }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total Spent:</th>
                                                        <td>{{ number_format($totalSpent, 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Last Order:</th>
                                                        <td>
                                                            @if($sales->count() > 0)
                                                                {{ $sales->first()->created_at->format('M d, Y') }}
                                                            @else
                                                                N/A
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header bg-primary text-white d-flex justify-content-between">
                                        <h5 class="mb-0">Recent Orders</h5>
                                    </div>
                                    <div class="card-body">
                                        @if($sales->count() > 0)
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Invoice #</th>
                                                            <th>Date</th>
                                                            <th>Items</th>
                                                            <th>Total</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($sales as $sale)
                                                            <tr>
                                                                <td>{{ $sale->invoice_number }}</td>
                                                                <td>{{ $sale->created_at->format('M d, Y') }}</td>
                                                                <td>{{ $sale->items->count() }}</td>
                                                                <td>{{ number_format($sale->total_amount, 2) }}</td>
                                                                <td>
                                                                    <span class="badge bg-{{ $sale->status == 'completed' ? 'success' : ($sale->status == 'pending' ? 'warning' : 'danger') }}">
                                                                        {{ ucfirst($sale->status) }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-sm btn-primary">
                                                                        <i class="fas fa-eye"></i> View
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="alert alert-info">
                                                This customer hasn't made any purchases yet.
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
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
</x-app-layout>