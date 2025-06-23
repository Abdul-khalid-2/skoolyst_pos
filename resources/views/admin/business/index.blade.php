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
                        <h4 class="mb-3">Business List</h4>
                        <p class="mb-0">Manage all your registered businesses.<br> Each business can have multiple branches.</p>
                    </div>
                    <a href="{{ route('businesses.create') }}" class="btn btn-primary add-list">
                        <i class="las la-plus mr-3"></i>Add Business
                    </a>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="table-responsive rounded mb-3">
                    <table class="data-tables table mb-0 tbl-server-info">
                        <thead class="bg-white text-uppercase">
                            <tr class="ligth ligth-data">
                                <th>SL</th>
                                <th>Logo</th>
                                <th>Name</th>
                                <th>Tax Number</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Branches</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="ligth-body">
                            @foreach($businesses as $business)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if($business->logo_url)
                                        <img src="{{ $business->logo_url }}" alt="{{ $business->name }}" class="rounded-circle avatar-50">
                                    @else
                                        <div class="avatar-50 bg-primary rounded-circle d-flex align-items-center justify-content-center">
                                            <span class="text-white">{{ strtoupper(substr($business->name, 0, 1)) }}</span>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    {{ $business->name }}
                                    <p class="mb-0"><small>{{ $business->registration_number }}</small></p>
                                </td>
                                <td>{{ $business->tax_number ?? 'N/A' }}</td>
                                <td>{{ $business->phone }}</td>
                                <td>{{ $business->email }}</td>
                                <td>
                                    <span class="badge badge-primary">{{ $business->branches->count() ?? 0 }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center list-action">
                                        <a class="badge badge-info mr-2" data-toggle="tooltip"
                                            data-placement="top" title="View" href="{{ route('businesses.show', $business->id) }}">
                                            <i class="ri-eye-line mr-0"></i>
                                        </a>
                                        <a class="badge bg-success mr-2" data-toggle="tooltip"
                                            data-placement="top" title="Edit" href="{{ route('businesses.edit', $business->id) }}">
                                            <i class="ri-pencil-line mr-0"></i>
                                        </a>
                                        <form action="{{ route('businesses.destroy', $business->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="badge bg-warning mr-2 border-0" data-toggle="tooltip"
                                                data-placement="top" title="Delete" onclick="return confirm('Are you sure you want to delete this business?')">
                                                <i class="ri-delete-bin-line mr-0"></i>
                                            </button>
                                        </form>
                                        <a class="badge bg-secondary" data-toggle="tooltip"
                                            data-placement="top" title="Branches" href="{{ route('branches.index', ['business_id' => $business->id]) }}">
                                            <i class="ri-store-2-line mr-0"></i>
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