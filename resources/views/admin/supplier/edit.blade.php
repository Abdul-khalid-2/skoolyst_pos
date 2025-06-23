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
                            <h4 class="card-title">Edit Supplier: {{ $supplier->name }}</h4>
                        </div>
                        <div>
                            <a href="{{ route('suppliers.show', $supplier->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye mr-1"></i> View
                            </a>
                            <a href="{{ route('suppliers.index') }}" class="btn btn-sm btn-light">
                                <i class="fas fa-arrow-left mr-1"></i> Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST" data-toggle="validator">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name *</label>
                                        <input type="text" name="name" class="form-control" 
                                            placeholder="Enter Name" value="{{ old('name', $supplier->name) }}" required>
                                        <div class="help-block with-errors"></div>
                                        @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Contact Person</label>
                                        <input type="text" name="contact_person" class="form-control" 
                                            placeholder="Enter Contact Person" value="{{ old('contact_person', $supplier->contact_person) }}">
                                        @error('contact_person') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control" 
                                            placeholder="Enter Email" value="{{ old('email', $supplier->email) }}">
                                        @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone *</label>
                                        <input type="text" name="phone" class="form-control" 
                                            placeholder="Enter Phone" value="{{ old('phone', $supplier->phone) }}" required>
                                        <div class="help-block with-errors"></div>
                                        @error('phone') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Alternate Phone</label>
                                        <input type="text" name="alternate_phone" class="form-control" 
                                            placeholder="Enter Alternate Phone" value="{{ old('alternate_phone', $supplier->alternate_phone) }}">
                                        @error('alternate_phone') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tax Number</label>
                                        <input type="text" name="tax_number" class="form-control" 
                                            placeholder="Enter Tax Number" value="{{ old('tax_number', $supplier->tax_number) }}">
                                        @error('tax_number') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Address *</label>
                                        <textarea name="address" class="form-control" rows="3" required>{{ old('address', $supplier->address) }}</textarea>
                                        <div class="help-block with-errors"></div>
                                        @error('address') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">
                                <i class="fas fa-save mr-1"></i> Update Supplier
                            </button>
                            <button type="reset" class="btn btn-danger">
                                <i class="fas fa-undo mr-1"></i> Reset
                            </button>
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
    @endpush
</x-app-layout>