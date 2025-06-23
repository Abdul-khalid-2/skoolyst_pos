<x-app-layout>
    @push('css')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css')}}">

    
<style>
.income-expense-chart {
    font-family: Arial, sans-serif;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    background: white;
    height: 100%;
}

.chart-bars {
    margin: 20px 0;
}

.bar-container {
    margin-bottom: 15px;
}

.bar-label {
    margin-bottom: 5px;
    font-size: 14px;
}

.bar {
    height: 40px;
    border-radius: 4px;
    display: flex;
    align-items: center;
    padding-left: 10px;
    color: white;
    font-weight: bold;
    transition: width 0.5s ease;
}

.bar.income {
    background-color: #4CAF50;
}

.bar.expense {
    background-color: #F44336;
}

.chart-summary {
    border-top: 1px solid #eee;
    padding-top: 15px;
}

.summary-item {
    display: flex;
    align-items: center;
    margin-bottom: 8px;
    font-size: 14px;
}

.dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    margin-right: 8px;
}

.income-dot {
    background-color: #4CAF50;
}

.expense-dot {
    background-color: #F44336;
}

.summary-item.net {
    font-weight: bold;
    margin-top: 10px;
    color: #2196F3;
}
</style>
    @endpush

    <div class="container-fluid">
        <div class="row">
            <!-- Welcome Card -->
            <div class="col-lg-4">
                <div class="card card-transparent card-block card-stretch card-height border-none">
                    <div class="card-body p-0 mt-lg-2 mt-0">
                        <h3 class="mb-3">Hi {{ auth()->user()->name }}, Good 
                            @if(now()->hour > 6 && now()->hour <12)
                                Morning
                            @elseif(now()->hour < 17)
                                Afternoon
                            @elseif(now()->hour < 21)
                                Evening
                            @else
                                Night see you tommarow
                            @endif
                        </h3>
                        <p class="mb-0 mr-4">Your dashboard gives you views of key performance or business process.</p>
                    </div>
                </div>
            </div>
            
            <!-- Summary Cards -->
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-4 col-md-4">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-4 card-total-sale">
                                    <div class="icon iq-icon-box-2 bg-info-light">
                                        <img src="{{ asset('backend/assets/images/product/1.png') }}" class="img-fluid" alt="image">
                                    </div>
                                    <div>
                                        <p class="mb-2">Total Sales</p>
                                        <h4>Rs {{ number_format($totalSales, 2) }}</h4>
                                    </div>
                                </div>
                                <div class="iq-progress-bar mt-2">
                                    <span class="bg-info iq-progress progress-1" 
                                          data-percent="{{ min(100, ($totalSales / max(1, $totalSales + $totalCost)) * 100) }}"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-4 card-total-sale">
                                    <div class="icon iq-icon-box-2 bg-danger-light">
                                        <img src="{{ asset('backend/assets/images/product/2.png') }}" class="img-fluid" alt="image">
                                    </div>
                                    <div>
                                        <p class="mb-2">Total Cost</p>
                                        <h4>Rs {{ number_format($totalCost, 2) }}</h4>
                                    </div>
                                </div>
                                <div class="iq-progress-bar mt-2">
                                    <span class="bg-danger iq-progress progress-1" 
                                          data-percent="{{ min(100, ($totalCost / max(1, $totalSales + $totalCost)) * 100) }}"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-4 card-total-sale">
                                    <div class="icon iq-icon-box-2 bg-success-light">
                                        <img src="{{ asset('backend/assets/images/product/3.png') }}" class="img-fluid" alt="image">
                                    </div>
                                    <div>
                                        <p class="mb-2">Products Sold</p>
                                        <h4>{{ number_format($productsSold) }}</h4>
                                    </div>
                                </div>
                                <div class="iq-progress-bar mt-2">
                                    <span class="bg-success iq-progress progress-1" 
                                          data-percent="{{ min(100, $productsSold / max(1, $productsSold + 100) * 100) }}"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sales Overview Chart -->
            <div class="col-lg-6">
                <div class="card card-block card-stretch card-height">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title sales-overview-title">Sales Overview (Last 30 Days)</h4>
                        </div>
                        <div class="card-header-toolbar d-flex align-items-center">
                            <div class="dropdown">
                                <span class="dropdown-toggle dropdown-bg btn" id="dropdownMenuButton001" data-toggle="dropdown">
                                    <span class="current-period-sales">This Month</span><i class="ri-arrow-down-s-line ml-1"></i>
                                </span>
                                <div class="dropdown-menu dropdown-menu-right shadow-none" aria-labelledby="dropdownMenuButton001">
                                    <a class="dropdown-item sales-period-selector" href="#" data-period="year">Year</a>
                                    <a class="dropdown-item sales-period-selector" href="#" data-period="month">Month</a>
                                    <a class="dropdown-item sales-period-selector" href="#" data-period="week">Week</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="sales-overview-chart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>


            <!-- Revenue vs Cost Chart -->
            <div class="col-lg-6">
                <div class="card card-block card-stretch card-height">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title revenue-cost-title">Revenue vs Cost (Last 30 Days)</h4>
                        </div>
                        <div class="card-header-toolbar d-flex align-items-center">
                            <div class="dropdown">
                                <span class="dropdown-toggle dropdown-bg btn" id="dropdownMenuButton002" data-toggle="dropdown">
                                    <span class="current-period-revenue">This Month</span><i class="ri-arrow-down-s-line ml-1"></i>
                                </span>
                                <div class="dropdown-menu  shadow-none" aria-labelledby="dropdownMenuButton002">
                                    <a class="dropdown-item period-selector-revenue-cost" href="#" data-period="year">Year</a>
                                    <a class="dropdown-item period-selector-revenue-cost" href="#" data-period="month">Month</a>
                                    <a class="dropdown-item period-selector-revenue-cost" href="#" data-period="week">Week</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="revenue-cost-chart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
            
            
            <!-- Top Products -->
            <div class="col-lg-8">
                <div class="card card-block card-stretch card-height">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Top Products</h4>
                        </div>
                        <div class="card-header-toolbar d-flex align-items-center">
                            <div class="dropdown">
                                <span class="dropdown-toggle dropdown-bg btn" id="dropdownMenuButton006" data-toggle="dropdown">
                                    <span class="current-period-top">This Month</span><i class="ri-arrow-down-s-line ml-1"></i>
                                </span>
                                <div class="dropdown-menu dropdown-menu-right shadow-none" aria-labelledby="dropdownMenuButton006">
                                    <a class="dropdown-item period-selector-top" href="#" data-period="year">Year</a>
                                    <a class="dropdown-item period-selector-top" href="#" data-period="month">Month</a>
                                    <a class="dropdown-item period-selector-top" href="#" data-period="week">Week</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mb-0 table-borderless">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Sold</th>
                                        <th>Revenue</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="top-products-body">
                                    @foreach($topProducts as $product)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $product->image }}" class="rounded img-fluid avatar-40 mr-3" alt="{{ $product->name }}">
                                                <span>{{ $product->name }}</span>
                                            </div>
                                        </td>
                                        <td>{{ number_format($product->total_sold) }}</td>
                                        <td>Rs {{ number_format($product->total_revenue, 2) }}</td>
                                        <td>
                                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-primary">View</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            
            <!-- Best Selling Products -->
            <div class="col-lg-4">
                <div class="card card-transparent card-block card-stretch mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between p-0">
                        <div class="header-title">
                            <h4 class="card-title mb-0">Best Selling Products</h4>
                        </div>
                        <div class="card-header-toolbar d-flex align-items-center">
                            <div><a href="{{ route('products.index') }}" class="btn btn-primary view-btn font-size-14">View All</a></div>
                        </div>
                    </div>
                </div>
                
                @foreach($bestProducts as $index => $product)
                <div class="card card-block card-stretch card-height-helf">
                    <div class="card-body card-item-right">
                        <div class="d-flex align-items-top">
                            <div class="rounded" style="background-color: {{ $index === 0 ? '#fce9e6' : '#e6f3ff' }};">
                                <img src="{{ $product->image }}" class="style-img img-fluid m-auto" alt="{{ $product->name }}">
                            </div>
                            <div class="style-text text-left">
                                <h5 class="mb-2">{{ $product->name }}</h5>
                                <p class="mb-2">Total Sold: {{ number_format($product->total_sold) }}</p>
                                <p class="mb-0">Total Revenue: Rs {{ number_format($product->total_revenue, 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="col-lg-4">
                <div class="income-expense-chart">
                    <div class="chart-container">
                        <div class="d-flex align-items-top justify-content-between">
                            <div class="">
                                <p class="mb-0">Income vs Expenses</p>
                            </div>
                            <div class="card-header-toolbar d-flex align-items-center">
                                <div class="dropdown">
                                    <span class="dropdown-toggle dropdown-bg btn" id="dropdownMenuButton003"
                                        data-toggle="dropdown">
                                        <span class="current-period">This Month</span><i class="ri-arrow-down-s-line ml-1"></i>
                                    </span>
                                    <div class="dropdown-menu dropdown-menu-right shadow-none"
                                        aria-labelledby="dropdownMenuButton003">
                                        <a class="dropdown-item period-selector_income_and_expenses" href="#" data-period="year">Year</a>
                                        <a class="dropdown-item period-selector_income_and_expenses" href="#" data-period="month">Month</a>
                                        <a class="dropdown-item period-selector_income_and_expenses" href="#" data-period="week">Week</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="chart-bars">
                            <div class="bar-container">
                                <div class="bar-label">Income</div>
                                <div class="bar income" style="width: 100%">
                                    <span>Rs {{ number_format($income, 2) }}</span>
                                </div>
                            </div>
                            <div class="bar-container">
                                <div class="bar-label">Expenses</div>
                                <div class="bar expense" style="width: {{ $income > 0 ? ($expenses/$income)*100 : 0 }}%">
                                    <span>Rs {{ number_format($expenses, 2) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="chart-summary">
                            <div class="summary-item">
                                <span class="dot income-dot"></span>
                                <span>Income: Rs {{ number_format($income, 2) }}</span>
                            </div>
                            <div class="summary-item">
                                <span class="dot expense-dot"></span>
                                <span>Expenses: Rs {{ number_format($expenses, 2) }}</span>
                            </div>
                            <div class="summary-item net">
                                <span>Net: Rs {{ number_format(($income - $expenses), 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Recent Sales -->
            <div class="col-lg-8">
                <div class="card card-block card-stretch card-height">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Recent Sales</h4>
                        </div>
                        <div class="card-header-toolbar d-flex align-items-center">
                            <div class="dropdown">
                                <span class="dropdown-toggle dropdown-bg btn" id="dropdownMenuButton005" data-toggle="dropdown">
                                    <span class="current-period">This Month</span><i class="ri-arrow-down-s-line ml-1"></i>
                                </span>
                                <div class="dropdown-menu dropdown-menu-right shadow-none" aria-labelledby="dropdownMenuButton005">
                                    <a class="dropdown-item period-selector_recent_sale" href="#" data-period="year">Year</a>
                                    <a class="dropdown-item period-selector_recent_sale" href="#" data-period="month">Month</a>
                                    <a class="dropdown-item period-selector_recent_sale" href="#" data-period="week">Week</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mb-0 table-borderless">
                                <thead>
                                    <tr>
                                        <th>Invoice</th>
                                        <th>Customer</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="recent-sales-body">
                                    @foreach($recentSales as $sale)
                                    <tr>
                                        <td>{{ $sale->invoice_number }}</td>
                                        <td>
                                            @if($sale->customer)
                                                {{ $sale->customer->name }}
                                            @else
                                                Walk-in Customer
                                            @endif
                                        </td>
                                        <td>{{ $sale->created_at->format('M d, Y') }}</td>
                                        <td>Rs {{ number_format($sale->total_amount, 2) }}</td>
                                        <td>
                                            <span class="badge badge-{{ $sale->status === 'completed' ? 'success' : 'warning' }}">
                                                {{ ucfirst($sale->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-sm btn-primary">View</a>
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

    <!-- Apex Charts -->
    <script src="{{ asset('backend/assets/js/apexcharts.js') }}"></script>

    <!-- Chart Custom JavaScript -->
    {{-- <script async src="{{ asset('backend/assets/js/chart-custom.js') }}"></script> --}}

    <!-- app JavaScript -->
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>
   
    
    <script>
    $(document).ready(function() {
        $('.period-selector_income_and_expenses').click(function(e) {
            e.preventDefault();
            const period = $(this).data('period');
            $('.current-period').text(
                period === 'year' ? 'This Year' : 
                period === 'month' ? 'This Month' : 'This Week'
            );
            
            // AJAX call to fetch data for the selected period
            $.ajax({
                url: '/dashboard/financial-data',
                type: 'GET',
                data: { period: period },
                success: function(response) {
                    // Update the chart with new data
                    updateChart(response.income, response.expenses);
                },
                error: function(xhr) {
                    console.error('Error fetching data');
                }
            });
        });
        
        function updateChart(income, expenses) {
            // Update bars
            $('.bar.income').css('width', '100%').find('span').text('Rs ' + income.toLocaleString('en-IN'));
            const expenseWidth = income > 0 ? (expenses/income)*100 : 0;
            $('.bar.expense').css('width', expenseWidth + '%').find('span').text('Rs ' + expenses.toLocaleString('en-IN'));
            
            // Update summary
            $('.summary-item:nth-child(1) span:last').text('Income: Rs ' + income.toLocaleString('en-IN'));
            $('.summary-item:nth-child(2) span:last').text('Expenses: Rs ' + expenses.toLocaleString('en-IN'));
            $('.summary-item.net span').text('Net: Rs ' + (income - expenses).toLocaleString('en-IN'));
        }
    });
    </script>
    <script>
        $(document).ready(function() {
            $('.period-selector_recent_sale').click(function(e) {
                e.preventDefault();
                const period = $(this).data('period');
                $('.current-period').text(
                    period === 'year' ? 'This Year' : 
                    period === 'month' ? 'This Month' : 'This Week'
                );
                
                // AJAX call to fetch data for the selected period
                $.ajax({
                    url: '/dashboard/recent-sales',
                    type: 'GET',
                    data: { period: period },
                    success: function(response) {
                        updateRecentSalesTable(response.sales);
                    },
                    error: function(xhr) {
                        console.error('Error fetching recent sales data');
                    }
                });
            });
            
            function updateRecentSalesTable(sales) {
                let html = '';
                
                sales.forEach(function(sale) {
                    html += `
                    <tr>
                        <td>${sale.invoice_number}</td>
                        <td>${sale.customer ? sale.customer.name : 'Walk-in Customer'}</td>
                        <td>${new Date(sale.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}</td>
                        <td>$${parseFloat(sale.total_amount).toFixed(2)}</td>
                        <td>
                            <span class="badge badge-${sale.status === 'completed' ? 'success' : 'warning'}">
                                ${sale.status.charAt(0).toUpperCase() + sale.status.slice(1)}
                            </span>
                        </td>
                        <td>
                            <a href="/sales/${sale.id}" class="btn btn-sm btn-primary">View</a>
                        </td>
                    </tr>
                    `;
                });
                
                $('#recent-sales-body').html(html);
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.period-selector_top_product').click(function(e) {
                e.preventDefault();
                const period = $(this).data('period');
                $('.current-period').text(
                    period === 'year' ? 'This Year' : 
                    period === 'month' ? 'This Month' : 'This Week'
                );
                
                // AJAX call to fetch data for the selected period
                $.ajax({
                    url: '/dashboard/top-product',
                    type: 'GET',
                    data: { period: period },
                    success: function(response) {
                        updateRecentSalesTable(response.sales);
                    },
                    error: function(xhr) {
                        console.error('Error fetching top product data');
                    }
                });
            });
            
            function updateRecentSalesTable(sales) {
                let html = '';
                
                sales.forEach(function(sale) {
                    html += `
                   
                    `;
                });
                
                $('#top-product-body').html(html);
            }
        });
    </script>


    <script>
        $(document).ready(function() {
            $('.period-selector-top').click(function(e) {
                e.preventDefault();
                const period = $(this).data('period');
                $('.current-period-top').text(
                    period === 'year' ? 'This Year' : 
                    period === 'month' ? 'This Month' : 'This Week'
                );
                
                // AJAX call to fetch data for the selected period
                $.ajax({
                    url: '/dashboard/top-products',
                    type: 'GET',
                    data: { period: period, limit: 4 }, // Match your initial limit
                    success: function(response) {
                        updateTopProductsTable(response.products);
                    },
                    error: function(xhr) {
                        console.error('Error fetching top products data');
                    }
                });
            });
            
            function updateTopProductsTable(products) {
                let html = '';
                
                products.forEach(function(product) {
                    html += `
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="${product.image}" class="rounded img-fluid avatar-40 mr-3" alt="${product.name}">
                                <span>${product.name}</span>
                            </div>
                        </td>
                        <td>${parseInt(product.total_sold).toLocaleString()}</td>
                        <td>$${parseFloat(product.total_revenue).toFixed(2)}</td>
                        <td>
                            <a href="/products/${product.id}" class="btn btn-sm btn-primary">View</a>
                        </td>
                    </tr>
                    `;
                });
                
                $('#top-products-body').html(html);
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let salesChart;
            
            function initSalesChart(data) {
                const dates = data.map(item => new Date(item.date).toLocaleDateString('en-US', { month: 'short', day: 'numeric' }));
                const totals = data.map(item => parseFloat(item.total));
                
                const options = {
                    chart: {
                        height: 300,
                        type: 'line',
                        zoom: { enabled: false },
                        toolbar: { show: true },
                        animations: { enabled: true }
                    },
                    series: [{ name: "Sales", data: totals }],
                    dataLabels: { enabled: false },
                    stroke: { curve: 'smooth', width: 2 },
                    colors: ['#6571ff'],
                    xaxis: { categories: dates },
                    yaxis: {
                        labels: {
                            formatter: function(val) { return "Rs " + val.toFixed(2); }
                        }
                    },
                    tooltip: {
                        y: {
                            formatter: function(val) { return "Rs " + val.toFixed(2); }
                        }
                    }
                };
                
                if (salesChart) {
                    salesChart.destroy();
                }
                
                salesChart = new ApexCharts(document.querySelector("#sales-overview-chart"), options);
                salesChart.render();
            }
            
            // Initialize with default data
            initSalesChart(@json($salesOverview));
            
            // Handle period change
            document.querySelectorAll('.sales-period-selector').forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    const period = this.getAttribute('data-period');
                    document.querySelector('.current-period-sales').textContent = 
                        period === 'year' ? 'This Year' : period === 'month' ? 'This Month' : 'This Week';
                    
                    fetch('/dashboard/sales-overview?period=' + period)
                        .then(response => response.json())
                        .then(data => {
                            document.querySelector('.sales-overview-title').textContent = 
                                `Sales Overview (Last ${period === 'year' ? 'Year' : period === 'month' ? '30 Days' : '7 Days'})`;
                            initSalesChart(data.sales);
                        })
                        .catch(error => console.error('Error:', error));
                });
            });
        });
    </script>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let revenueCostChart;
            
            // Initialize the chart
            function initRevenueCostChart(data) {
                const dates = data.map(item => new Date(item.date).toLocaleDateString('en-US', { month: 'short', day: 'numeric' }));
                const revenue = data.map(item => parseFloat(item.revenue));
                const cost = data.map(item => parseFloat(item.cost));
                
                const options = {
                    chart: {
                        height: 300,
                        type: 'bar',
                        stacked: false,
                        toolbar: { show: true },
                        animations: { enabled: true }
                    },
                    dataLabels: { enabled: false },
                    series: [
                        { name: 'Revenue', data: revenue },
                        { name: 'Cost', data: cost }
                    ],
                    colors: ['#6571ff', '#ff7c5f'],
                    xaxis: { 
                        categories: dates,
                        labels: {
                            rotate: -45,
                            style: {
                                fontSize: '12px'
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            formatter: function(val) { 
                                return "Rs " + val.toFixed(2); 
                            }
                        }
                    },
                    tooltip: {
                        y: {
                            formatter: function(val) { 
                                return "Rs " + val.toFixed(2); 
                            }
                        }
                    },
                    legend: {
                        position: 'top'
                    }
                };
                
                if (revenueCostChart) {
                    revenueCostChart.destroy();
                }
                
                revenueCostChart = new ApexCharts(document.querySelector("#revenue-cost-chart"), options);
                revenueCostChart.render();
            }
            
            // Initialize with default data
            initRevenueCostChart(@json($revenueVsCost));
            
            // Handle period change
            document.querySelectorAll('.period-selector-revenue-cost').forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    const period = this.getAttribute('data-period');
                    
                    // Update dropdown text
                    const periodText = period === 'year' ? 'This Year' : 
                                    period === 'month' ? 'This Month' : 'This Week';
                    document.querySelector('.current-period-revenue').textContent = periodText;
                    
                    // Update chart title
                    const titleText = period === 'year' ? 'Revenue vs Cost (Last Year)' :
                                    period === 'month' ? 'Revenue vs Cost (Last 30 Days)' :
                                    'Revenue vs Cost (Last 7 Days)';
                    document.querySelector('.revenue-cost-title').textContent = titleText;
                    
                    // Show loading state
                    const chartElement = document.querySelector('#revenue-cost-chart');
                    chartElement.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"></div></div>';
                    
                    // Fetch new data
                    fetch(`/dashboard/revenue-cost?period=${period}`)
                        .then(response => response.json())
                        .then(data => {
                            initRevenueCostChart(data.data);
                        })
                        .catch(error => {
                            console.error('Error fetching revenue vs cost data:', error);
                            chartElement.innerHTML = '<div class="text-center py-5 text-danger">Error loading data</div>';
                        });
                });
            });
        });
    </script>
    @endpush
</x-app-layout>