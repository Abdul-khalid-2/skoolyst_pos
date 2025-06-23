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
                        <h4 class="mb-3">Purchase Orders</h4>
                        <p class="mb-0">Manage all incoming inventory purchases</p>
                    </div>
                    <a href="{{ route('purchases.create') }}" class="btn btn-primary add-list">
                        <i class="las la-plus mr-3"></i>New Purchase
                    </a>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="table-responsive rounded mb-3">
                    <table class="data-tables table mb-0 tbl-server-info">
                        <thead class="bg-white text-uppercase">
                            <tr>
                                <th>PO Number</th>
                                <th>Supplier</th>
                                <th>Date</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($purchases as $purchase)
                            <tr>
                                <td>{{ $purchase->invoice_number }}</td>
                                <td>{{ $purchase->supplier->name }}</td>
                                <td>{{ $purchase->purchase_date->format('M d, Y') }}</td>
                                <td>{{ $purchase->items->count() }}</td>
                                <td>{{ number_format($purchase->total_amount, 2) }}</td>
                                <td>
                                    <span class="badge badge-{{ $purchase->status == 'received' ? 'success' : 'warning' }}">
                                        {{ ucfirst($purchase->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center list-action">
                                        <a href="{{ route('purchases.show', $purchase->id) }}" class="badge badge-info mr-2">
                                            <i class="ri-eye-line mr-0"></i>
                                        </a>
                                        <a href="{{ route('purchases.edit', $purchase->id) }}" class="badge bg-success mr-2">
                                            <i class="ri-pencil-line mr-0"></i>
                                        </a>
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

