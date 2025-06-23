<x-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css')}}">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endpush

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex flex-wrap justify-content-between mb-4">
                    <div>
                        <h4 class="mb-3">Customer Report</h4>
                        <p class="mb-0">
                            From {{ $startDate }} to {{ $endDate }}
                            @if($branchId)
                                - Branch: {{ Branch::find($branchId)->name }}
                            @endif
                            @if($customerGroup)
                                - Customer Group: {{ ucfirst($customerGroup) }}
                            @endif
                        </p>
                    </div>
                    <div>
                        <a href="#" class="btn btn-secondary" onclick="window.print()">
                            <i class="fas fa-print mr-2"></i>Print
                        </a>
                        <a href="{{ route('reports.customer.export', request()->all()) }}" class="btn btn-success ml-2">
                            <i class="fas fa-file-excel mr-2"></i>Export
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Filters -->
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="GET" action="{{ route('reports.customer') }}">
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="start_date">Start Date</label>
                                    <input type="date" name="start_date" id="start_date" 
                                        value="{{ $startDate }}" class="form-control" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="end_date">End Date</label>
                                    <input type="date" name="end_date" id="end_date" 
                                        value="{{ $endDate }}" class="form-control" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="branch_id">Branch</label>
                                    <select name="branch_id" id="branch_id" class="form-control">
                                        <option value="">All Branches</option>
                                        @foreach($branches as $branch)
                                            <option value="{{ $branch->id }}" 
                                                {{ $branchId == $branch->id ? 'selected' : '' }}>
                                                {{ $branch->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="customer_group">Customer Group</label>
                                    <select name="customer_group" id="customer_group" class="form-control">
                                        <option value="">All Groups</option>
                                        @foreach($availableGroups as $group)
                                            <option value="{{ $group }}" 
                                                {{ $customerGroup == $group ? 'selected' : '' }}>
                                                {{ ucfirst($group) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary">Generate</button>
                                    <a href="{{ route('reports.customer') }}" class="btn btn-light ml-2">Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Summary Cards -->
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Customers</h4>
                                </div>
                                <div class="card-body">
                                    {{ count($customers) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-success">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Sales</h4>
                                </div>
                                <div class="card-body">
                                    {{ number_format($customers->sum('total_sales'), 2) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-info">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Avg. Purchase Value</h4>
                                </div>
                                <div class="card-body">
                                    {{ number_format($customers->avg('avg_purchase_value'), 2) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-warning">
                                <i class="fas fa-coins"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Due Balance</h4>
                                </div>
                                <div class="card-body">
                                    {{ number_format($sale->sum('total_amount') - $sale->sum('amount_paid'), 2) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-md-3">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-warning">
                                <i class="fas fa-coins"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Outstanding Balance</h4>
                                </div>
                                <div class="card-body">
                                    {{ number_format($customers->sum('balance'), 2) }}
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
            
            <!-- Charts -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Top Customers by Sales</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="topCustomersChart" height="300"></canvas>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Sales by Customer Group</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="customerGroupsChart" height="300"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- Customer List -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Customer Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Contact</th>
                                        <th>Group</th>
                                        <th class="text-right">Total Sales</th>
                                        <th class="text-right">Purchases</th>
                                        <th class="text-right">Avg. Purchase</th>
                                        <th class="text-right">Balance</th>
                                        <th>Last Purchase</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customers as $customer)
                                    <tr>
                                        <td>{{ $customer['name'] }}</td>
                                        <td>
                                            {{ $customer['phone'] }}<br>
                                            <small>{{ $customer['email'] }}</small>
                                        </td>
                                        <td>{{ ucfirst($customer['customer_group']) }}</td>
                                        <td class="text-right">{{ number_format($customer['total_sales'], 2) }}</td>
                                        <td class="text-right">{{ $customer['total_purchases'] }}</td>
                                        <td class="text-right">{{ number_format($customer['avg_purchase_value'], 2) }}</td>
                                        <td class="text-right {{ $customer['balance'] < 0 ? 'text-danger' : '' }}">
                                            {{ number_format($customer['balance'], 2) }}
                                        </td>
                                        <td>{{ $customer['last_purchase_date'] ?? 'Never' }}</td>
                                        <td>
                                            <a href="{{ route('customers.show', $customer['id']) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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

    <!-- app JavaScript -->
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>

    <script>
        // Top Customers Chart
        const topCustomersCtx = document.getElementById('topCustomersChart').getContext('2d');
        const topCustomersChart = new Chart(topCustomersCtx, {
            type: 'bar',
            data: {
                labels: @json($topCustomers->pluck('name')),
                datasets: [{
                    label: 'Total Sales',
                    data: @json($topCustomers->pluck('total_sales')),
                    backgroundColor: '#4e73df',
                    borderColor: '#2e59d9',
                    borderWidth: 1
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Sales: ' + context.parsed.y.toFixed(2);
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value.toFixed(2);
                            }
                        }
                    }
                }
            }
        });
        
        // Customer Groups Chart
        const customerGroupsCtx = document.getElementById('customerGroupsChart').getContext('2d');
        const customerGroupsChart = new Chart(customerGroupsCtx, {
            type: 'doughnut',
            data: {
                labels: @json($customerGroups->pluck('name')),
                datasets: [{
                    data: @json($customerGroups->pluck('total_sales')),
                    backgroundColor: [
                        '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e'
                    ],
                    hoverBackgroundColor: [
                        '#2e59d9', '#17a673', '#2c9faf', '#dda20a'
                    ],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += context.parsed.toFixed(2);
                                return label;
                            }
                        }
                    }
                },
                cutout: '70%',
            },
        });
    </script>
    @endpush
</x-app-layout>