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
                            <h4 class="card-title">Supplier Details</h4>
                        </div>
                        <div>
                            <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-sm btn-primary mr-2">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            <a href="{{ route('suppliers.index') }}" class="btn btn-sm btn-light">
                                <i class="fas fa-arrow-left mr-1"></i> Back
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
                                                        <td>{{ $supplier->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Contact Person:</th>
                                                        <td>{{ $supplier->contact_person ?? 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Email:</th>
                                                        <td>{{ $supplier->email ?? 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Phone:</th>
                                                        <td>{{ $supplier->phone }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Alternate Phone:</th>
                                                        <td>{{ $supplier->alternate_phone ?? 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Tax Number:</th>
                                                        <td>{{ $supplier->tax_number ?? 'N/A' }}</td>
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
                                        <p>{{ $supplier->address }}</p>
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
                                                        <th width="50%">Total Purchases:</th>
                                                        <td>{{ $purchases->count() }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total Amount:</th>
                                                        <td>{{ number_format($totalPurchases, 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Last Purchase:</th>
                                                        <td>
                                                            @if($purchases->count() > 0)
                                                                {{ $purchases->first()->purchase_date->format('M d, Y') }}
                                                            @else
                                                                N/A
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Outstanding Balance:</th>
                                                        <td>
                                                            <span class="badge bg-{{ $outstandingBalance > 0 ? 'danger' : 'success' }}">
                                                                {{ number_format($outstandingBalance, 2) }}
                                                            </span>
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
                                        <h5 class="mb-0">Recent Purchases</h5>
                                    </div>
                                    <div class="card-body">
                                        @if($purchases->count() > 0)
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
                                                        @foreach($purchases as $purchase)
                                                            <tr>
                                                                <td>{{ $purchase->invoice_number }}</td>
                                                                <td>{{ $purchase->purchase_date->format('M d, Y') }}</td>
                                                                <td>{{ $purchase->items->count() }}</td>
                                                                <td>{{ number_format($purchase->total_amount, 2) }}</td>
                                                                <td>
                                                                    <span class="badge bg-{{ $purchase->status == 'received' ? 'success' : ($purchase->status == 'partial' ? 'warning' : 'danger') }}">
                                                                        {{ ucfirst($purchase->status) }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <a href="{{ route('purchases.show', $purchase->id) }}" class="btn btn-sm btn-primary">
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
                                                No purchases found for this supplier.
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