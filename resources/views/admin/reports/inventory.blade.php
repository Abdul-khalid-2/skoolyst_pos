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
                        <h4 class="mb-3">Inventory Report</h4>
                        <p class="mb-0">
                            @if($branchId)
                                Branch: {{ Branch::find($branchId)->name }}
                            @else
                                All Branches
                            @endif
                        </p>
                    </div>
                    <div>
                        <a href="#" class="btn btn-secondary" onclick="window.print()">
                            <i class="fas fa-print mr-2"></i>Print
                        </a>
                        <a href="{{ route('reports.inventory.export', request()->all()) }}" class="btn btn-success ml-2">
                            <i class="fas fa-file-excel mr-2"></i>Export
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Filters -->
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="GET" action="{{ route('reports.inventory') }}">
                            <div class="row">
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
                                <div class="col-md-3">
                                    <label for="category_id">Category</label>
                                    <select name="category_id" id="category_id" class="form-control">
                                        <option value="">All Categories</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" 
                                                {{ $categoryId == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="stock_level">Stock Level</label>
                                    <select name="stock_level" id="stock_level" class="form-control">
                                        <option value="all" {{ $stockLevel == 'all' ? 'selected' : '' }}>All Items</option>
                                        <option value="low" {{ $stockLevel == 'low' ? 'selected' : '' }}>Low Stock</option>
                                        <option value="out" {{ $stockLevel == 'out' ? 'selected' : '' }}>Out of Stock</option>
                                    </select>
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary">Generate</button>
                                    <a href="{{ route('reports.inventory') }}" class="btn btn-light ml-2">Reset</a>
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
                                <i class="fas fa-boxes"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Products</h4>
                                </div>
                                <div class="card-body">
                                    {{ $inventorySummary['total_products'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-success">
                                <i class="fas fa-box-open"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Variants</h4>
                                </div>
                                <div class="card-body">
                                    {{ $inventorySummary['total_variants'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-warning">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Low Stock</h4>
                                </div>
                                <div class="card-body">
                                    {{ $inventorySummary['low_stock'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-danger">
                                <i class="fas fa-times-circle"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Out of Stock</h4>
                                </div>
                                <div class="card-body">
                                    {{ $inventorySummary['out_of_stock'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Charts -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Stock Status</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="stockStatusChart" height="300"></canvas>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Recent Stock Movement</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="stockMovementChart" height="300"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- Inventory List -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Inventory Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Category</th>
                                        <th>Brand</th>
                                        <th>Variants</th>
                                        <th>Total Stock</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                    <tr>
                                        <td>{{ $product['name'] }}</td>
                                        <td>{{ $product['category'] }}</td>
                                        <td>{{ $product['brand'] }}</td>
                                        <td>
                                            @foreach($product['variants'] as $variant)
                                            <div class="mb-1">
                                                <strong>{{ $variant['name'] }}</strong> ({{ $variant['sku'] }})<br>
                                                Stock: {{ $variant['stock'] }} 
                                                <span class="badge badge-{{ $variant['status'] == 'Out of Stock' ? 'danger' : ($variant['status'] == 'Low Stock' ? 'warning' : 'success') }}">
                                                    {{ $variant['status'] }}
                                                </span>
                                            </div>
                                            @endforeach
                                        </td>
                                        <td>{{ $product['total_stock'] }}</td>
                                        <td>
                                            <span class="badge badge-{{ $product['status'] == 'Out of Stock' ? 'danger' : ($product['status'] == 'Low Stock' ? 'warning' : 'success') }}">
                                                {{ $product['status'] }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('products.show', $product['id']) }}" class="btn btn-sm btn-primary">
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
        // Stock Status Chart
        const stockStatusCtx = document.getElementById('stockStatusChart').getContext('2d');
        const stockStatusChart = new Chart(stockStatusCtx, {
            type: 'doughnut',
            data: {
                labels: ['In Stock', 'Low Stock', 'Out of Stock'],
                datasets: [{
                    data: [
                        {{ $inventorySummary['total_products'] - $inventorySummary['low_stock'] - $inventorySummary['out_of_stock'] }},
                        {{ $inventorySummary['low_stock'] }},
                        {{ $inventorySummary['out_of_stock'] }}
                    ],
                    backgroundColor: [
                        '#1cc88a',
                        '#f6c23e',
                        '#e74a3b'
                    ],
                    hoverBackgroundColor: [
                        '#17a673',
                        '#dda20a',
                        '#be2617'
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
                                return context.label + ': ' + context.raw;
                            }
                        }
                    }
                },
                cutout: '70%',
            },
        });
        
        // Stock Movement Chart
        const stockMovementCtx = document.getElementById('stockMovementChart').getContext('2d');
        const stockMovementChart = new Chart(stockMovementCtx, {
            type: 'bar',
            data: {
                labels: @json($stockMovement->pluck('date')),
                datasets: [
                    {
                        label: 'Items Added',
                        data: @json($stockMovement->pluck('items_added')),
                        backgroundColor: '#1cc88a',
                        borderColor: '#17a673',
                        borderWidth: 1
                    },
                    {
                        label: 'Items Removed',
                        data: @json($stockMovement->pluck('items_removed')),
                        backgroundColor: '#e74a3b',
                        borderColor: '#be2617',
                        borderWidth: 1
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
                                return context.dataset.label + ': ' + context.parsed.y;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>