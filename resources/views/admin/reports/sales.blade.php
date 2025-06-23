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
                        <h4 class="mb-3">Sales Report</h4>
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
                        <a href="{{ route('reports.sales.export', request()->all()) }}" class="btn btn-success ml-2">
                            <i class="fas fa-file-excel mr-2"></i>Export
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Filters -->
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="GET" action="{{ route('reports.sales') }}">
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
                                        @foreach($customerGroups as $group)
                                            <option value="{{ $group }}" 
                                                {{ $customerGroup == $group ? 'selected' : '' }}>
                                                {{ ucfirst($group) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary">Generate</button>
                                    <a href="{{ route('reports.sales') }}" class="btn btn-light ml-2">Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Summary Cards -->
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Sales</h4>
                                </div>
                                <div class="card-body">
                                    {{ number_format($totalSales, 2) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-success">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Items Sold</h4>
                                </div>
                                <div class="card-body">
                                    {{ number_format($totalItemsSold) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-info">
                                <i class="fas fa-receipt"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Transactions</h4>
                                </div>
                                <div class="card-body">
                                    {{ count($sales) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Charts -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Daily Sales Trend</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="salesTrendChart" height="300"></canvas>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Sales by Payment Method</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="paymentMethodChart" height="300"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- Detailed Tables -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Sales by Category</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th class="text-right">Quantity</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($salesByCategory as $category)
                                    <tr>
                                        <td>{{ $category['category'] }}</td>
                                        <td class="text-right">{{ number_format($category['quantity']) }}</td>
                                        <td class="text-right">{{ number_format($category['total'], 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Payment Methods</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Method</th>
                                        <th class="text-right">Transactions</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($salesByPaymentMethod as $method)
                                    <tr>
                                        <td>{{ $method['method'] }}</td>
                                        <td class="text-right">{{ $method['count'] }}</td>
                                        <td class="text-right">{{ number_format($method['total'], 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Transaction List -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Transaction Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Invoice</th>
                                        <th>Customer</th>
                                        <th>Branch</th>
                                        <th class="text-right">Items</th>
                                        <th class="text-right">Total</th>
                                        <th>Cashier</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sales as $sale)
                                    <tr>
                                        <td>{{ $sale->sale_date->format('M d, Y') }}</td>
                                        <td>{{ $sale->invoice_number }}</td>
                                        <td>{{ $sale->customer->name ?? 'Walk-in' }}</td>
                                        <td>{{ $sale->branch->name }}</td>
                                        <td class="text-right">{{ $sale->items->sum('quantity') }}</td>
                                        <td class="text-right">{{ number_format($sale->total_amount, 2) }}</td>
                                        <td>{{ $sale->user->name }}</td>
                                        <td>
                                            <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-sm btn-primary">
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
        // Sales Trend Chart
        const salesTrendCtx = document.getElementById('salesTrendChart').getContext('2d');
        const salesTrendChart = new Chart(salesTrendCtx, {
            type: 'line',
            data: {
                labels: @json(array_column($dailySalesTrend, 'date')),
                datasets: [
                    {
                        label: 'Sales Amount',
                        data: @json(array_column($dailySalesTrend, 'total_sales')),
                        borderColor: '#4e73df',
                        backgroundColor: 'rgba(78, 115, 223, 0.05)',
                        tension: 0.3,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Transactions',
                        data: @json(array_column($dailySalesTrend, 'transaction_count')),
                        borderColor: '#1cc88a',
                        backgroundColor: 'rgba(28, 200, 138, 0.05)',
                        tension: 0.3,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + 
                                    (context.datasetIndex === 0 ? 
                                        context.parsed.y.toFixed(2) : 
                                        context.parsed.y);
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Sales Amount'
                        },
                        ticks: {
                            callback: function(value) {
                                return value.toFixed(2);
                            }
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Transactions'
                        },
                        grid: {
                            drawOnChartArea: false
                        }
                    }
                }
            }
        });
        
        // Payment Method Chart
        const paymentMethodCtx = document.getElementById('paymentMethodChart').getContext('2d');
        const paymentMethodChart = new Chart(paymentMethodCtx, {
            type: 'doughnut',
            data: {
                labels: @json(array_column($salesByPaymentMethod, 'method')),
                datasets: [{
                    data: @json(array_column($salesByPaymentMethod, 'total')),
                    backgroundColor: [
                        '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', 
                        '#e74a3b', '#858796', '#5a5c69', '#f8f9fc'
                    ],
                    hoverBackgroundColor: [
                        '#2e59d9', '#17a673', '#2c9faf', '#dda20a', 
                        '#be2617', '#656776', '#42444e', '#d6d8df'
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