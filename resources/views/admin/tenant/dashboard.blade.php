<x-app-layout>
    @push('css')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css')}}">
    @endpush

    @push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endpush

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex flex-wrap flex-wrap align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="mb-3">{{ $tenant->name }} Dashboard</h4>
                        <p class="mb-0">Track and analyze business performance.</p>
                    </div>
                    <div>
                        <a href="{{ route('tenants.show', $tenant->id) }}" class="btn btn-primary">
                            <i class="ri-arrow-left-line mr-2"></i>Back to Tenant
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Quick Stats -->
            <div class="col-lg-3 col-md-6">
                <div class="card card-block card-stretch card-height">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="mm-cart-image text-primary">
                                <i class="ri-store-2-line"></i>
                            </div>
                            <div class="mm-cart-text">
                                <h2 class="mb-1">{{ $metrics['total_businesses'] }}</h2>
                                <p class="mb-0">Businesses</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card card-block card-stretch card-height">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="mm-cart-image text-success">
                                <i class="ri-home-4-line"></i>
                            </div>
                            <div class="mm-cart-text">
                                <h2 class="mb-1">{{ $metrics['total_branches'] }}</h2>
                                <p class="mb-0">Total Branches</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card card-block card-stretch card-height">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="mm-cart-image text-warning">
                                <i class="ri-home-gear-line"></i>
                            </div>
                            <div class="mm-cart-text">
                                <h2 class="mb-1">{{ $metrics['active_branches'] }}</h2>
                                <p class="mb-0">Active Branches</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card card-block card-stretch card-height">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="mm-cart-image text-info">
                                <i class="ri-money-dollar-circle-line"></i>
                            </div>
                            <div class="mm-cart-text">
                                <h2 class="mb-1">{{ number_format($metrics['total_sales'], 2) }}</h2>
                                <p class="mb-0">Monthly Sales</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Sales Chart -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Sales Last 30 Days</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="salesChart" height="300"></canvas>
                    </div>
                </div>
            </div>

            <!-- Top Products -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Top Selling Products</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($topProducts->isEmpty())
                            <div class="alert alert-info">No sales data available.</div>
                        @else
                            <ul class="list-unstyled mb-0">
                                @foreach($topProducts as $product)
                                <li class="iq-media mb-3">
                                    <div class="iq-media-body">
                                        <div class="d-flex justify-content-between">
                                            <h6>{{ $product->name }}</h6>
                                            <span class="text-primary">{{ $product->total_quantity }} sold</span>
                                        </div>
                                        <div class="iq-progress-bar-linear d-inline-block w-100">
                                            <div class="iq-progress-bar">
                                                <span class="bg-primary" data-percent="{{ min(100, ($product->total_quantity / $topProducts->first()->total_quantity) * 100) }}"></span>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="text-dark">Revenue: {{ number_format($product->total_revenue, 2) }}</span>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Business List -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Business Overview</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($tenant->businesses->isEmpty())
                            <div class="alert alert-info">No businesses found for this tenant.</div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Business</th>
                                            <th>Branches</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tenant->businesses as $business)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($business->logo_url)
                                                        <img src="{{ $business->logo_url }}" alt="{{ $business->name }}" class="rounded avatar-40 mr-3">
                                                    @else
                                                        <div class="avatar-40 bg-primary rounded-circle d-flex align-items-center justify-content-center mr-3">
                                                            <span class="text-white">{{ strtoupper(substr($business->name, 0, 1)) }}</span>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <h6 class="mb-0">{{ $business->name }}</h6>
                                                        <small>{{ $business->tax_number ?? 'N/A' }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $business->branches_count }}</td>
                                            <td>{{ $business->phone }}</td>
                                            <td>{{ $business->email }}</td>
                                            <td>
                                                <span class="badge badge-success">Active</span>
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('businesses.show', $business->id) }}" class="btn btn-sm btn-icon btn-info mr-1" data-toggle="tooltip" title="View">
                                                        <i class="ri-eye-line"></i>
                                                    </a>
                                                    <a href="{{ route('branches.index', ['business_id' => $business->id]) }}" class="btn btn-sm btn-icon btn-secondary" data-toggle="tooltip" title="Branches">
                                                        <i class="ri-store-2-line"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
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
        // Sales Chart
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($salesData->pluck('date')) !!},
                datasets: [{
                    label: 'Sales Count',
                    data: {!! json_encode($salesData->pluck('sales_count')) !!},
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.1,
                    yAxisID: 'y'
                }, {
                    label: 'Sales Amount',
                    data: {!! json_encode($salesData->pluck('sales_total')) !!},
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    tension: 0.1,
                    yAxisID: 'y1'
                }]
            },
            options: {
                responsive: true,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Sales Count'
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Sales Amount'
                        },
                        grid: {
                            drawOnChartArea: false,
                        }
                    }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>