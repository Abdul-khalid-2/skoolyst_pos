<x-app-layout>
    @push('css')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css')}}">
    @endpush

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex flex-wrap justify-content-between mb-4">
                    <div>
                        <h4 class="mb-3">Sales</h4>
                        <p class="mb-0">Manage all customer sales transactions</p>
                    </div>
                    <a href="{{ route('sales.create') }}" class="btn btn-primary add-list">
                        <i class="las la-plus mr-3"></i>New Sale
                    </a>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="table-responsive rounded mb-3">
                    <table class="data-tables table mb-0 tbl-server-info">
                        <thead class="bg-white text-uppercase">
                            <tr>
                                <th>Invoice #</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Paid</th>
                                <th>Status</th>
                                <th>Payment</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sales as $sale)
                            <tr>
                                <td>{{ $sale->invoice_number }}</td>
                                <td>{{ $sale->customer ? $sale->customer->name : 'Walk-in' }}</td>
                                <td>{{ $sale->sale_date->format('M d, Y') }}</td>
                                <td>{{ number_format($sale->total_amount, 2) }}</td>
                                <td>{{ number_format($sale->amount_paid, 2) }}</td>
                                <td>
                                    <span class="badge badge-{{ $sale->status == 'completed' ? 'success' : 'danger' }}">
                                        {{ ucfirst($sale->status) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $sale->payment_status == 'paid' ? 'success' : ($sale->payment_status == 'partial' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($sale->payment_status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center list-action">
                                        <a href="{{ route('sales.show', $sale->id) }}" class="badge badge-info mr-2">
                                            <i class="ri-eye-line mr-0"></i>
                                        </a>
                                        <a href="{{ route('sales.edit', $sale->id) }}" class="badge bg-success mr-2">
                                            <i class="ri-pencil-line mr-0"></i>
                                        </a>
                                        <form action="{{ route('sales.destroy', $sale->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="badge bg-danger border-0" onclick="return confirm('Are you sure? This will restore inventory.')">
                                                <i class="ri-delete-bin-line mr-0"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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