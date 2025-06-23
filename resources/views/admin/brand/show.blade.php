<x-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css') }}">
    @endpush

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex flex-wrap flex-wrap align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="mb-3">Brand Details</h4>
                        <p class="mb-0">View detailed information about the brand.</p>
                    </div>
                    <div>
                        <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-primary mr-2"><i class="ri-pencil-line mr-0"></i> Edit</a>
                        <a href="{{ route('brands.index') }}" class="btn btn-secondary"><i class="ri-arrow-left-line mr-0"></i> Back</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                @if($brand->logo_path)
                                    <img src="{{ asset('storage/'.$brand->logo_path) }}" class="img-fluid rounded" style="max-height: 200px;" alt="Brand Logo">
                                @else
                                    <div class="avatar-150 bg-primary rounded-circle d-flex align-items-center justify-content-center mx-auto">
                                        <span class="text-white" style="font-size: 60px;">{{ strtoupper(substr($brand->name, 0, 1)) }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-8">
                                <h3 class="mb-3">{{ $brand->name }}</h3>
                                
                                <div class="mb-4">
                                    <h6 class="mb-2">Description</h6>
                                    <p>{{ $brand->description ?? 'No description available' }}</p>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <h6 class="mb-2">Products</h6>
                                            <p>{{ $brand->products_count ?? 0 }} products</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <h6 class="mb-2">Created At</h6>
                                            <p>{{ $brand->created_at->format('M d, Y h:i A') }}</p>
                                        </div>
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