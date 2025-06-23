<x-app-layout>
    @push('css')
        <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.ico') }}" />
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css') }}">
    @endpush

    <div class="container-fluid add-form-list">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">{{ isset($business) ? 'Edit' : 'Add' }} Business</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ isset($business) ? route('businesses.update', $business->id) : route('businesses.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if(isset($business))
                                @method('PUT')
                            @endif
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name *</label>
                                        <input type="text" name="name" class="form-control" 
                                            placeholder="Enter Business Name" 
                                            value="{{ old('name', $business->name ?? '') }}" required>
                                        @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tax Number</label>
                                        <input type="text" name="tax_number" class="form-control" 
                                            placeholder="Enter Tax Number" 
                                            value="{{ old('tax_number', $business->tax_number ?? '') }}">
                                        @error('tax_number') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Registration Number</label>
                                        <input type="text" name="registration_number" class="form-control" 
                                            placeholder="Enter Registration Number" 
                                            value="{{ old('registration_number', $business->registration_number ?? '') }}">
                                        @error('registration_number') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone *</label>
                                        <input type="text" name="phone" class="form-control" 
                                            placeholder="Enter Phone Number" 
                                            value="{{ old('phone', $business->phone ?? '') }}" required>
                                        @error('phone') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email *</label>
                                        <input type="email" name="email" class="form-control" 
                                            placeholder="Enter Email" 
                                            value="{{ old('email', $business->email ?? '') }}" required>
                                        @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Address *</label>
                                        <textarea name="address" class="form-control" rows="3" required>{{ old('address', $business->address ?? '') }}</textarea>
                                        @error('address') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Logo</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="logo" name="logo">
                                            <label class="custom-file-label" for="logo">Choose file</label>
                                        </div>
                                        @error('logo') <div class="text-danger">{{ $message }}</div> @enderror
                                        @if(isset($business) && $business->logo_url)
                                            <div class="mt-2">
                                                <img src="{{ $business->logo_url }}" alt="Logo" class="img-thumbnail" width="100">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Receipt Header</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="receipt_header" name="receipt_header">
                                            <label class="custom-file-label" for="receipt_header">Choose file</label>
                                        </div>
                                        @error('receipt_header') <div class="text-danger">{{ $message }}</div> @enderror
                                        @if(isset($business) && $business->receipt_header_url)
                                            <div class="mt-2">
                                                <img src="{{ $business->receipt_header_url }}" alt="Header" class="img-thumbnail" width="100">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Receipt Footer</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="receipt_footer" name="receipt_footer">
                                            <label class="custom-file-label" for="receipt_footer">Choose file</label>
                                        </div>
                                        @error('receipt_footer') <div class="text-danger">{{ $message }}</div> @enderror
                                        @if(isset($business) && $business->receipt_footer_url)
                                            <div class="mt-2">
                                                <img src="{{ $business->receipt_footer_url }}" alt="Footer" class="img-thumbnail" width="100">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">
                                {{ isset($business) ? 'Update' : 'Save' }} Business
                            </button>
                            <button type="reset" class="btn btn-danger">Reset</button>
                            <a href="{{ route('businesses.index') }}" class="btn btn-light">Cancel</a>
                        </form>
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
        
        <script>
            // Update custom file input label with selected file name
            document.querySelectorAll('.custom-file-input').forEach(input => {
                input.addEventListener('change', function(e) {
                    const fileName = e.target.files[0]?.name || 'Choose file';
                    const label = e.target.nextElementSibling;
                    label.textContent = fileName;
                });
            });
        </script>
    @endpush
</x-app-layout>