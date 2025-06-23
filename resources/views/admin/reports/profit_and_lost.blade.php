<x-app-layout>
    @push('css')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css')}}">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endpush

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex flex-wrap justify-content-between mb-4">
                    <div>
                        <h4 class="mb-3">Profit & Loss Report</h4>
                        <p class="mb-0">From {{ $startDate }} to {{ $endDate }} 
                            @if($branchId)
                                - Branch: {{ $branchName }}
                            @endif
                        </p>
                    </div>
                    <div>
                        <a href="#" class="btn btn-secondary" onclick="window.print()">
                            <i class="fas fa-print mr-2"></i>Print
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Filters -->
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="GET" action="{{ route('reports.profit-loss') }}">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="start_date">Start Date</label>
                                    <input type="date" name="start_date" id="start_date" 
                                        value="{{ $startDate }}" class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="end_date">End Date</label>
                                    <input type="date" name="end_date" id="end_date" 
                                        value="{{ $endDate }}" class="form-control" required>
                                </div>
                                <div class="col-md-3">
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
                                <div class="col-md-3 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary">Generate</button>
                                    <a href="{{ route('reports.profit-loss') }}" class="btn btn-light ml-2">Reset</a>
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
                                    <h4>Total Revenue</h4>
                                </div>
                                <div class="card-body">
                                    {{ number_format($revenue, 2) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-success">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Gross Profit</h4>
                                </div>
                                <div class="card-body">
                                    {{ number_format($grossProfit, 2) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-statistic-1">
                            <div class="card-icon {{ $netProfit >= 0 ? 'bg-info' : 'bg-danger' }}">
                                <i class="fas fa-coins"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Net Profit</h4>
                                </div>
                                <div class="card-body">
                                    {{ number_format($netProfit, 2) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Profit Trend Chart -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Profit Trend</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="profitTrendChart" height="300"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- Expense Breakdown -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Expense Breakdown</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="expenseChart" height="300"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- Detailed Report -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Detailed Profit & Loss Statement</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td><strong>Total Sales</strong></td>
                                        <td class="text-right">{{ number_format($totalSales, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Less: Returns</strong></td>
                                        <td class="text-right text-danger">({{ number_format($totalReturns, 2) }})</td>
                                    </tr>
                                    <tr class="table-primary">
                                        <td><strong>Net Revenue</strong></td>
                                        <td class="text-right"><strong>{{ number_format($revenue, 2) }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Cost of Goods Sold</strong></td>
                                        <td class="text-right text-danger">({{ number_format($cogs, 2) }})</td>
                                    </tr>
                                    <tr class="table-success">
                                        <td><strong>Gross Profit</strong></td>
                                        <td class="text-right"><strong>{{ number_format($grossProfit, 2) }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><strong>Operating Expenses</strong></td>
                                    </tr>
                                    @foreach($expenseBreakdown as $expense)
                                    <tr>
                                        <td>&nbsp;&nbsp;&nbsp;{{ $expense['category'] }}</td>
                                        <td class="text-right text-danger">({{ number_format($expense['total'], 2) }})</td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td><strong>Total Expenses</strong></td>
                                        <td class="text-right text-danger">({{ number_format($totalExpenses, 2) }})</td>
                                    </tr>
                                    <tr class="{{ $netProfit >= 0 ? 'table-info' : 'table-danger' }}">
                                        <td><strong>Net Profit</strong></td>
                                        <td class="text-right"><strong>{{ number_format($netProfit, 2) }}</strong></td>
                                    </tr>
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


    <!-- Chart Custom JavaScript -->
    <script async src="{{ asset('backend/assets/js/chart-custom.js') }}"></script>

    <!-- app JavaScript -->
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>

    <!-- Chart Custom JavaScript -->
    <script>
        // Profit Trend Chart
        const profitTrendCtx = document.getElementById('profitTrendChart').getContext('2d');
        const profitTrendChart = new Chart(profitTrendCtx, {
            type: 'line',
            data: {
                labels: @json(array_column($profitTrend, 'period')),
                datasets: [
                    {
                        label: 'Revenue',
                        data: @json(array_column($profitTrend, 'revenue')),
                        borderColor: '#4e73df',
                        backgroundColor: 'rgba(78, 115, 223, 0.05)',
                        tension: 0.3,
                        fill: true
                    },
                    {
                        label: 'Gross Profit',
                        data: @json(array_column($profitTrend, 'gross_profit')),
                        borderColor: '#1cc88a',
                        backgroundColor: 'rgba(28, 200, 138, 0.05)',
                        tension: 0.3,
                        fill: true
                    },
                    {
                        label: 'Net Profit',
                        data: @json(array_column($profitTrend, 'net_profit')),
                        borderColor: '#36b9cc',
                        backgroundColor: 'rgba(54, 185, 204, 0.05)',
                        tension: 0.3,
                        fill: true
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
                                return context.dataset.label + ': ' + context.parsed.y.toFixed(2);
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: false,
                        ticks: {
                            callback: function(value) {
                                return value.toFixed(2);
                            }
                        }
                    }
                }
            }
        });
        
        // Expense Breakdown Chart
        const expenseCtx = document.getElementById('expenseChart').getContext('2d');
        const expenseChart = new Chart(expenseCtx, {
            type: 'doughnut',
            data: {
                labels: @json(array_column($expenseBreakdown, 'category')),
                datasets: [{
                    data: @json(array_column($expenseBreakdown, 'total')),
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