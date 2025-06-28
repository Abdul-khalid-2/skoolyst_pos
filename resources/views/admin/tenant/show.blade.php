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
                        <h4 class="mb-3">Tenant Details</h4>
                        <p class="mb-0">View and manage tenant information and businesses.</p>
                    </div>
                    <div>
                        <a href="{{ route('tenants.edit', $tenant->id) }}" class="btn btn-primary mr-2">
                            <i class="ri-pencil-line mr-2"></i>Edit Tenant
                        </a>
                        <a href="{{ route('tenants.dashboard', $tenant->id) }}" class="btn btn-info">
                            <i class="ri-dashboard-line mr-2"></i>View Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h5 class="card-title">Tenant Information</h5>
                            <span class="badge badge-{{ $tenant->is_active ? 'success' : 'danger' }}">
                                {{ $tenant->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-3">
                                <i class="ri-global-line mr-2 text-primary"></i>
                                <strong>Domain:</strong> 
                                <a href="http://{{ $tenant->domains->first()->domain }}" target="_blank">
                                    {{ $tenant->domains->first()->domain }}
                                </a>
                            </li>
                            <li class="mb-3">
                                <i class="ri-database-2-line mr-2 text-primary"></i>
                                <strong>Database:</strong> {{ $tenant->database_name }}
                            </li>
                            <li class="mb-3">
                                <i class="ri-mail-line mr-2 text-primary"></i>
                                <strong>Email:</strong> {{ $tenant->email }}
                            </li>
                            <li class="mb-3">
                                <i class="ri-time-line mr-2 text-primary"></i>
                                <strong>Timezone:</strong> {{ $tenant->timezone }}
                            </li>
                            <li class="mb-3">
                                <i class="ri-money-dollar-circle-line mr-2 text-primary"></i>
                                <strong>Currency:</strong> {{ $tenant->currency }}
                            </li>
                            <li class="mb-3">
                                <i class="ri-translate-2 mr-2 text-primary"></i>
                                <strong>Locale:</strong> {{ $tenant->locale }}
                            </li>
                            @if($tenant->trial_ends_at)
                            <li class="mb-3">
                                <i class="ri-timer-line mr-2 text-primary"></i>
                                <strong>Trial Ends:</strong> 
                                {{ $tenant->trial_ends_at->format('M d, Y') }}
                                ({{ $tenant->trial_ends_at->diffForHumans() }})
                            </li>
                            @endif
                            <li class="mb-3">
                                <i class="ri-calendar-line mr-2 text-primary"></i>
                                <strong>Created:</strong> {{ $tenant->created_at->format('M d, Y') }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h5 class="card-title">Businesses ({{ $tenant->businesses_count }})</h5>
                        </div>
                        <a href="{{ route('businesses.create', ['tenant_id' => $tenant->id]) }}" class="btn btn-sm btn-primary">
                            <i class="ri-add-line mr-1"></i> Add Business
                        </a>
                    </div>
                    <div class="card-body">
                        @if($businesses->isEmpty())
                            <div class="alert alert-info">No businesses found for this tenant.</div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Tax Number</th>
                                            <th>Phone</th>
                                            <th>Branches</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($businesses as $business)
                                        <tr>
                                            <td>
                                                <a href="{{ route('businesses.show', $business->id) }}" class="text-primary">
                                                    {{ $business->name }}
                                                </a>
                                            </td>
                                            <td>{{ $business->tax_number ?? 'N/A' }}</td>
                                            <td>{{ $business->phone }}</td>
                                            <td>
                                                <span class="badge badge-primary">{{ $business->branches_count }}</span>
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
                            {{ $businesses->links() }}
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

    <!-- Chart Custom JavaScript -->
    <script async src="{{ asset('backend/assets/js/chart-custom.js') }}"></script>

    <!-- app JavaScript -->
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>
    @endpush
</x-app-layout>