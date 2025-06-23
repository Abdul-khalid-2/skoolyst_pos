<x-app-layout>
    @push('css')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css')}}">
    <!-- Dropzone CSS (CDN) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css"/>
    @endpush

    <div class="container-fluid add-form-list">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Add New Brand</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('brands.store') }}" method="POST" data-toggle="validator">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name *</label>
                                        <input type="text" name="name" class="form-control" placeholder="Enter Name" value="{{ old('name') }}" required>
                                        <div class="help-block with-errors"></div>
                                        @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                                        @error('description') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Brand Logo</label>
                                        <div class="dropzone" id="brandLogoDropzone"></div>
                                        <input type="hidden" name="logo_path" id="logoPath" value="{{ old('logo_path') }}">
                                        @error('logo_path') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Add Brand</button>
                            <button type="reset" class="btn btn-danger">Reset</button>
                            <a href="{{ route('brands.index') }}" class="btn btn-light">Cancel</a>
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
    <!-- Dropzone JS (CDN) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>

    <script>
        // Initialize Dropzone for brand logo upload
        Dropzone.autoDiscover = false;
        
        $(document).ready(function() {
            let uploadedLogo = null;
            
            // Initialize dropzone
            let brandDropzone = new Dropzone("#brandLogoDropzone", {
                url: "{{ route('brands.upload-logo') }}",
                paramName: "logo",
                maxFiles: 1,
                maxFilesize: 2, // MB
                acceptedFiles: "image/*",
                addRemoveLinks: true,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(file, response) {
                    uploadedLogo = response.path;
                    $('#logoPath').val(uploadedLogo);
                },
                removedfile: function(file) {
                    // Remove from server
                    $.ajax({
                        url: "{{ route('brands.remove-logo') }}",
                        type: 'DELETE',
                        data: {
                            path: file.name,
                            _token: "{{ csrf_token() }}"
                        }
                    });
                    
                    // Clear the stored path
                    uploadedLogo = null;
                    $('#logoPath').val('');
                    
                    // Remove preview
                    return file.previewElement.remove();
                },
                init: function() {
                    // Load existing logo if editing (though this is create form, kept for consistency)
                    @if(old('logo_path'))
                        let existingLogo = '{{ old('logo_path') }}';
                        let mockFile = { name: existingLogo, size: 12345 };
                        this.emit("addedfile", mockFile);
                        this.emit("thumbnail", mockFile, "{{ asset('storage') }}/" + existingLogo);
                        this.emit("complete", mockFile);
                        uploadedLogo = existingLogo;
                        $('#logoPath').val(uploadedLogo);
                    @endif
                }
            });
        });
    </script>
    @endpush
</x-app-layout>