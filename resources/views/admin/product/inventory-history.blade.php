<x-app-layout>
  @push('css')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css"/>

    @endpush
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Inventory History: {{ $product->name }}</h4>
                        </div>
                        <div>
                            <a href="{{ route('products.show', $product->id) }}" 
                               class="btn btn-sm btn-secondary">
                                <i class="ri-arrow-left-line"></i> Back to Product
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Variant</th>
                                        <th>Branch</th>
                                        <th>Change</th>
                                        <th>New Qty</th>
                                        <th>Reference</th>
                                        <th>User</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($inventoryLogs as $log)
                                    <tr>
                                        <td>{{ $log->created_at->format('M d, Y H:i') }}</td>
                                        <td>{{ $log->variant->name ? $log->variant->name .'('. $log->variant->sku .')' : 'N/A' }}</td>
                                        <td>{{ $log->branch->name ?? 'N/A' }}</td>
                                        <td class="{{ $log->quantity_change > 0 ? 'text-success' : 'text-danger' }}">
                                            {{ $log->quantity_change > 0 ? '+' : '' }}{{ $log->quantity_change }}
                                        </td>
                                        <td>{{ $log->new_quantity }}</td>
                                        <td>
                                            @if($log->reference_type && $log->reference_id)
                                                {{ class_basename($log->reference_type) }} #{{ $log->reference_id }}
                                            @else
                                                Manual Adjustment
                                            @endif
                                        </td>
                                        <td>{{ $log->user->name ?? 'System' }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No inventory history found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-3">
                            {{ $inventoryLogs->links() }}
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