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
                        <h4 class="mb-3">Business Details</h4>
                        <p class="mb-0">View all details of your business.</p>
                    </div>
                    <div>
                        <a href="{{ route('businesses.edit', $business->id) }}" class="btn btn-primary mr-2">
                            <i class="ri-pencil-line mr-1"></i> Edit
                        </a>
                        <a href="{{ route('businesses.index') }}" class="btn btn-light">
                            <i class="ri-arrow-left-line mr-1"></i> Back
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body text-center">
                        @if($business->logo_url)
                            <img src="{{ $business->logo_url }}" alt="Logo" class="img-fluid rounded-circle mb-3" width="150">
                        @else
                            <div class="avatar-150 bg-primary rounded-circle d-flex align-items-center justify-content-center mb-3">
                                <span class="text-white" style="font-size: 60px;">{{ strtoupper(substr($business->name, 0, 1)) }}</span>
                            </div>
                        @endif
                        <h4>{{ $business->name }}</h4>
                        <p class="text-muted">{{ $business->registration_number }}</p>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Contact Information</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-3">
                                <i class="ri-phone-line mr-2 text-primary"></i>
                                {{ $business->phone }}
                            </li>
                            <li class="mb-3">
                                <i class="ri-mail-line mr-2 text-primary"></i>
                                {{ $business->email }}
                            </li>
                            <li>
                                <i class="ri-map-pin-line mr-2 text-primary"></i>
                                {{ $business->address }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Business Information</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tax Number</label>
                                    <p class="form-control-static">{{ $business->tax_number ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Registration Number</label>
                                    <p class="form-control-static">{{ $business->registration_number ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Address</label>
                                    <p class="form-control-static">{{ $business->address }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Receipt Templates</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Receipt Header</label>
                                    @if($business->receipt_header_url)
                                        <img src="{{ $business->receipt_header_url }}" alt="Header" class="img-fluid border">
                                    @else
                                        <p class="text-muted">No header image uploaded</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Receipt Footer</label>
                                    @if($business->receipt_footer_url)
                                        <img src="{{ $business->receipt_footer_url }}" alt="Footer" class="img-fluid border">
                                    @else
                                        <p class="text-muted">No footer image uploaded</p>
                                    @endif
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