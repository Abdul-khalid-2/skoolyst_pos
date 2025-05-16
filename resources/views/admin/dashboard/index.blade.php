<x-app-layout>
    @push('css')
    <link rel="stylesheet" href="{{ asset('Backend/assets/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Backend/assets/css/backend.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('Backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Backend/assets/vendor/remixicon/fonts/remixicon.css')}}">
    @endpush

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4">
                <div class="card card-transparent card-block card-stretch card-height border-none">
                    <div class="card-body p-0 mt-lg-2 mt-0">
                        <h3 class="mb-3">Hi {{ auth()->user()->name }}, Good </h3>
                        <p class="mb-0 mr-4">Your dashboard gives you views of key performance or business process.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-4 col-md-4">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-4 card-total-sale">
                                    <div class="icon iq-icon-box-2 bg-info-light">
                                        <img src="{{ asset('Backend/assets/images/product/1.png') }}" class="img-fluid" alt="image">
                                    </div>
                                    <div>
                                        <p class="mb-2">Total Sales</p>
                                        <h4>${{ number_format($totalSales, 2) }}</h4>
                                    </div>
                                </div>
                                <div class="iq-progress-bar mt-2">
                                    <span class="bg-info iq-progress progress-1" data-percent="85"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-4 card-total-sale">
                                    <div class="icon iq-icon-box-2 bg-danger-light">
                                        <img src="{{ asset('Backend/assets/images/product/2.png') }}" class="img-fluid" alt="image">
                                    </div>
                                    <div>
                                        <p class="mb-2">Total Cost</p>
                                        <h4>${{ number_format($totalCost, 2) }}</h4>
                                    </div>
                                </div>
                                <div class="iq-progress-bar mt-2">
                                    <span class="bg-danger iq-progress progress-1" data-percent="70"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-4 card-total-sale">
                                    <div class="icon iq-icon-box-2 bg-success-light">
                                        <img src="{{ asset('Backend/assets/images/product/3.png') }}" class="img-fluid" alt="image">
                                    </div>
                                    <div>
                                        <p class="mb-2">Products Sold</p>
                                        <h4>{{ number_format($productsSold) }}</h4>
                                    </div>
                                </div>
                                <div class="iq-progress-bar mt-2">
                                    <span class="bg-success iq-progress progress-1" data-percent="75"></span>
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
                            <h4 class="card-title">Sales Overview</h4>
                        </div>
                        <div class="card-header-toolbar d-flex align-items-center">
                            <div class="dropdown">
                                <span class="dropdown-toggle dropdown-bg btn" id="dropdownMenuButton001" data-toggle="dropdown">
                                    This Month<i class="ri-arrow-down-s-line ml-1"></i>
                                </span>
                                <div class="dropdown-menu dropdown-menu-right shadow-none" aria-labelledby="dropdownMenuButton001">
                                    <a class="dropdown-item" href="#">Year</a>
                                    <a class="dropdown-item" href="#">Month</a>
                                    <a class="dropdown-item" href="#">Week</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="sales-overview-chart" style="height: 300px;"></div>
                        @push('js')
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const salesData = @json($salesOverview);
                                
                                const dates = salesData.map(item => item.date);
                                const totals = salesData.map(item => parseFloat(item.total));
                                
                                const options = {
                                    chart: {
                                        height: 300,
                                        type: 'line',
                                        zoom: {
                                            enabled: false
                                        },
                                        toolbar: {
                                            show: false
                                        }
                                    },
                                    series: [{
                                        name: "Sales",
                                        data: totals
                                    }],
                                    dataLabels: {
                                        enabled: false
                                    },
                                    stroke: {
                                        curve: 'smooth',
                                        width: 2
                                    },
                                    colors: ['#6571ff'],
                                    xaxis: {
                                        categories: dates,
                                    },
                                    tooltip: {
                                        y: {
                                            formatter: function(val) {
                                                return "$" + val.toFixed(2);
                                            }
                                        }
                                    }
                                };
                                
                                const chart = new ApexCharts(document.querySelector("#sales-overview-chart"), options);
                                chart.render();
                            });
                        </script>
                        @endpush
                    </div>
                </div>
            </div>
            
            <!-- Revenue vs Cost Chart -->
            <div class="col-lg-6">
                <div class="card card-block card-stretch card-height">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Revenue Vs Cost</h4>
                        </div>
                        <div class="card-header-toolbar d-flex align-items-center">
                            <div class="dropdown">
                                <span class="dropdown-toggle dropdown-bg btn" id="dropdownMenuButton002" data-toggle="dropdown">
                                    This Month<i class="ri-arrow-down-s-line ml-1"></i>
                                </span>
                                <div class="dropdown-menu dropdown-menu-right shadow-none" aria-labelledby="dropdownMenuButton002">
                                    <a class="dropdown-item" href="#">Yearly</a>
                                    <a class="dropdown-item" href="#">Monthly</a>
                                    <a class="dropdown-item" href="#">Weekly</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="revenue-cost-chart" style="height: 300px;"></div>
                        @push('js')
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const revenueCostData = @json($revenueVsCost);
                                
                                // Process data to group by date
                                const groupedData = {};
                                revenueCostData.forEach(item => {
                                    if (!groupedData[item.date]) {
                                        groupedData[item.date] = { date: item.date, revenue: 0, cost: 0 };
                                    }
                                    if (item.revenue) {
                                        groupedData[item.date].revenue = parseFloat(item.revenue);
                                    } else if (item.cost) {
                                        groupedData[item.date].cost = parseFloat(item.cost);
                                    }
                                });
                                
                                const dates = Object.keys(groupedData).sort();
                                const revenue = dates.map(date => groupedData[date].revenue);
                                const cost = dates.map(date => groupedData[date].cost);
                                
                                const options = {
                                    chart: {
                                        height: 300,
                                        type: 'bar',
                                        stacked: false,
                                        toolbar: {
                                            show: false
                                        }
                                    },
                                    dataLabels: {
                                        enabled: false
                                    },
                                    series: [
                                        {
                                            name: 'Revenue',
                                            data: revenue
                                        },
                                        {
                                            name: 'Cost',
                                            data: cost
                                        }
                                    ],
                                    colors: ['#6571ff', '#ff7c5f'],
                                    xaxis: {
                                        categories: dates,
                                    },
                                    yaxis: {
                                        labels: {
                                            formatter: function(val) {
                                                return "$" + val.toFixed(2);
                                            }
                                        }
                                    },
                                    tooltip: {
                                        y: {
                                            formatter: function(val) {
                                                return "$" + val.toFixed(2);
                                            }
                                        }
                                    }
                                };
                                
                                const chart = new ApexCharts(document.querySelector("#revenue-cost-chart"), options);
                                chart.render();
                            });
                        </script>
                        @endpush
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
                                    This Month<i class="ri-arrow-down-s-line ml-1"></i>
                                </span>
                                <div class="dropdown-menu dropdown-menu-right shadow-none" aria-labelledby="dropdownMenuButton006">
                                    <a class="dropdown-item" href="#">Year</a>
                                    <a class="dropdown-item" href="#">Month</a>
                                    <a class="dropdown-item" href="#">Week</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled row top-product mb-0">
                            @foreach($topProducts as $index => $product)
                            <li class="col-lg-3">
                                <div class="card card-block card-stretch card-height mb-0">
                                    <div class="card-body">
                                        <div class="rounded {{ ['bg-warning-light', 'bg-danger-light', 'bg-info-light', 'bg-success-light'][$index] }}">
                                            <img src="{{ asset('Backend/assets/images/product/0'.($index+1).'.png') }}" 
                                                class="style-img img-fluid m-auto p-3" alt="{{ $product->name }}">
                                        </div>
                                        <div class="style-text text-left mt-3">
                                            <h5 class="mb-1">{{ $product->name }}</h5>
                                            <p class="mb-0">{{ number_format($product->total_sold) }} Sold</p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
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
                            <div><a href="#" class="btn btn-primary view-btn font-size-14">View All</a></div>
                        </div>
                    </div>
                </div>
                
                @if($bestProduct)
                <div class="card card-block card-stretch card-height-helf">
                    <div class="card-body card-item-right">
                        <div class="d-flex align-items-top">
                            <div class="bg-warning-light rounded">
                                <img src="{{ asset('Backend/assets/images/product/04.png') }}" class="style-img img-fluid m-auto" alt="{{ $bestProduct->name }}">
                            </div>
                            <div class="style-text text-left">
                                <h5 class="mb-2">{{ $bestProduct->name }}</h5>
                                <p class="mb-2">Total Sold: {{ number_format($bestProduct->total_sold) }}</p>
                                <p class="mb-0">Total Revenue: ${{ number_format($bestProduct->total_revenue, 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                
                @if($secondBestProduct)
                <div class="card card-block card-stretch card-height-helf">
                    <div class="card-body card-item-right">
                        <div class="d-flex align-items-top">
                            <div class="bg-danger-light rounded">
                                <img src="{{ asset('Backend/assets/images/product/05.png') }}" class="style-img img-fluid m-auto" alt="{{ $secondBestProduct->name }}">
                            </div>
                            <div class="style-text text-left">
                                <h5 class="mb-2">{{ $secondBestProduct->name }}</h5>
                                <p class="mb-2">Total Sold: {{ number_format($secondBestProduct->total_sold) }}</p>
                                <p class="mb-0">Total Revenue: ${{ number_format($secondBestProduct->total_revenue, 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            
            <!-- Income and Expenses -->
            <div class="col-lg-4">
                <div class="card card-block card-stretch card-height-helf">
                    <div class="card-body">
                        <div class="d-flex align-items-top justify-content-between">
                            <div class="">
                                <p class="mb-0">Income</p>
                                <h5>${{ number_format($income, 2) }}</h5>
                            </div>
                            <div class="card-header-toolbar d-flex align-items-center">
                                <div class="dropdown">
                                    <span class="dropdown-toggle dropdown-bg btn" id="dropdownMenuButton003" data-toggle="dropdown">
                                        This Month<i class="ri-arrow-down-s-line ml-1"></i>
                                    </span>
                                    <div class="dropdown-menu dropdown-menu-right shadow-none" aria-labelledby="dropdownMenuButton003">
                                        <a class="dropdown-item" href="#">Year</a>
                                        <a class="dropdown-item" href="#">Month</a>
                                        <a class="dropdown-item" href="#">Week</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="income-chart" style="height: 150px;"></div>
                        @push('js')
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const incomeChart = new ApexCharts(document.querySelector("#income-chart"), {
                                    chart: {
                                        height: 150,
                                        type: 'radialBar',
                                    },
                                    series: [Math.min(100, Math.round(({{ $income }} / ({{ $income }} + {{ $expenses }})) * 100))],
                                    colors: ['#6571ff'],
                                    plotOptions: {
                                        radialBar: {
                                            hollow: {
                                                size: '60%',
                                            }
                                        },
                                    },
                                    labels: ['Income'],
                                });
                                incomeChart.render();
                            });
                        </script>
                        @endpush
                    </div>
                </div>
                
                <div class="card card-block card-stretch card-height-helf">
                    <div class="card-body">
                        <div class="d-flex align-items-top justify-content-between">
                            <div class="">
                                <p class="mb-0">Expenses</p>
                                <h5>${{ number_format($expenses, 2) }}</h5>
                            </div>
                            <div class="card-header-toolbar d-flex align-items-center">
                                <div class="dropdown">
                                    <span class="dropdown-toggle dropdown-bg btn" id="dropdownMenuButton004" data-toggle="dropdown">
                                        This Month<i class="ri-arrow-down-s-line ml-1"></i>
                                    </span>
                                    <div class="dropdown-menu dropdown-menu-right shadow-none" aria-labelledby="dropdownMenuButton004">
                                        <a class="dropdown-item" href="#">Year</a>
                                        <a class="dropdown-item" href="#">Month</a>
                                        <a class="dropdown-item" href="#">Week</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="expenses-chart" style="height: 150px;"></div>
                        @push('js')
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const expensesChart = new ApexCharts(document.querySelector("#expenses-chart"), {
                                    chart: {
                                        height: 150,
                                        type: 'radialBar',
                                    },
                                    series: [Math.min(100, Math.round(({{ $expenses }} / ({{ $income }} + {{ $expenses }})) * 100))],
                                    colors: ['#ff7c5f'],
                                    plotOptions: {
                                        radialBar: {
                                            hollow: {
                                                size: '60%',
                                            }
                                        },
                                    },
                                    labels: ['Expenses'],
                                });
                                expensesChart.render();
                            });
                        </script>
                        @endpush
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
                                    This Month<i class="ri-arrow-down-s-line ml-1"></i>
                                </span>
                                <div class="dropdown-menu dropdown-menu-right shadow-none" aria-labelledby="dropdownMenuButton005">
                                    <a class="dropdown-item" href="#">Year</a>
                                    <a class="dropdown-item" href="#">Month</a>
                                    <a class="dropdown-item" href="#">Week</a>
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
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentSales as $sale)
                                    <tr>
                                        <td>{{ $sale->invoice_number }}</td>
                                        <td>
                                            @if($sale->customer_id)
                                                {{ DB::table('customers')->where('id', $sale->customer_id)->value('name') }}
                                            @else
                                                Walk-in Customer
                                            @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($sale->created_at)->format('M d, Y') }}</td>
                                        <td>${{ number_format($sale->total_amount, 2) }}</td>
                                        <td>
                                            <span class="badge badge-{{ $sale->status === 'completed' ? 'success' : 'warning' }}">
                                                {{ ucfirst($sale->status) }}
                                            </span>
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
        <!-- Page end  -->
    </div>

    @push('js')
    <!-- Backend Bundle JavaScript -->
    <script src="{{ asset('Backend/assets/js/backend-bundle.min.js') }}"></script>

    <!-- Table Treeview JavaScript -->
    <script src="{{ asset('Backend/assets/js/table-treeview.js') }}"></script>

    <!-- Chart Custom JavaScript -->
    <script src="{{ asset('Backend/assets/js/customizer.js') }}"></script>

    <!-- Apex Charts -->
    <script src="{{ asset('Backend/assets/js/apexcharts.js') }}"></script>

    <!-- Chart Custom JavaScript -->
    <script async src="{{ asset('Backend/assets/js/chart-custom.js') }}"></script>

    <!-- app JavaScript -->
    <script src="{{ asset('Backend/assets/js/app.js') }}"></script>
    @endpush
</x-app-layout>