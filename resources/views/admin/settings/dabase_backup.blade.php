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
                        <h4 class="mb-3">Supplier List</h4>
                        <p class="mb-0">Manage all your suppliers and vendors in one place.<br> Track supplier information and manage your procurement process.</p>
                    </div>
                    {{-- <a href="{{ route('generate.database') }}" class="btn btn-primary add-list"><i
                            class="las la-plus mr-3"></i>Generate New Dabase</a> --}}
                </div>
            </div>
            <div class="col-lg-12">
                <div class="table-responsive rounded mb-3">
                    <table class="data-tables table mb-0 tbl-server-info">
                        <thead class="bg-white text-uppercase">
                            <tr class="ligth ligth-data">
            
                                <th>Sno#</th>
                                <th>File</th>
                                <th>Download</th>
                               
                            </tr>
                        </thead>
                        <tbody class="ligth-body">
                            @foreach($files as $key => $file)
                                <tr>
                                    <td>{{ $key+1 ?? '' }}</td>
                                    <td>{{ basename($file) ?? '' }}</td>
                                    <td>
                                        <div class="d-flex align-items-center list-action">
                                            <a class="badge bg-success mr-2" 
                                            href="{{ route('download.backup', basename($file)) }}">
                                            <i class="ri-download-line mr-0"></i>
                                            </a>
                                    
                                            <a class="badge bg-danger mr-2" 
                                            href="{{ route('remove.backup', basename($file)) }}">
                                            <i class="ri-delete-bin-line mr-0"></i>
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