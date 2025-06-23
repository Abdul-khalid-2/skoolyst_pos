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
                <div class="d-flex flex-wrap flex-wrap align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="mb-3">Inventory Adjustment Logs</h4>
                        <p class="mb-0">Track all inventory movements and adjustments.<br> View stock changes, reasons, and responsible users.</p>
                    </div>
                    <a href="{{ route('inventory-logs.create') }}" class="btn btn-primary add-list">
                        <i class="las la-plus mr-1"></i> Add Adjustment
                    </a>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="table-responsive rounded mb-3">
                    <table class="data-tables table mb-0 tbl-server-info">
                        <thead class="bg-white text-uppercase">
                            <tr class="ligth ligth-data">
                                <th>Date</th>
                                <th>Product</th>
                                <th>Variant</th>
                                <th>Branch</th>
                                <th>Change</th>
                                <th>New Qty</th>
                                <th>Reference</th>
                                <th>User</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="ligth-body">
                            @foreach($logs as $log)
                            <tr>
                                <td>{{ $log->created_at->format('M d, Y H:i') }}</td>
                                <td>{{ $log->product->name }}</td>
                                <td>{{ $log->variant->name ? $log->variant->name .' ('. $log->variant->sku .') ' : 'N/A' }}</td>
                                <td>{{ $log->branch->name }}</td>
                                <td class="{{ $log->quantity_change > 0 ? 'text-success' : 'text-danger' }}">
                                    {{ $log->quantity_change > 0 ? '+' : '' }}{{ $log->quantity_change }}
                                </td>
                                <td>{{ $log->new_quantity }}</td>
                                <td>
                                    @if($log->reference_type == 'purchase')
                                        <span class="badge badge-info">Purchase</span>
                                    @elseif($log->reference_type == 'sale')
                                        <span class="badge badge-warning">Sale</span>
                                    @elseif($log->reference_type == 'return')
                                        <span class="badge badge-success">Return</span>
                                    @else
                                        <span class="badge badge-secondary">Manual</span>
                                    @endif
                                </td>
                                <td>{{ $log->user->name ?? 'System' }}</td>
                                <td>
                                    @if($log->reference_type == 'manual')
                                    <form action="{{ route('inventory-logs.destroy', $log->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="badge bg-warning border-0" 
                                                onclick="return confirm('Are you sure? This will reverse the stock adjustment.')">
                                            <i class="ri-delete-bin-line mr-0"></i>
                                        </button>
                                    </form>
                                    @endif
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