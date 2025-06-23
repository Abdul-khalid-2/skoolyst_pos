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
                            <h4 class="card-title">{{ isset($branch) ? 'Edit' : 'Add' }} Branch</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ isset($branch) ? route('branches.update', $branch->id) : route('branches.store') }}" method="POST">
                            @csrf
                            @if(isset($branch))
                                @method('PUT')
                            @endif
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Business *</label>
                                        <select name="business_id" class="form-control" required>
                                            <option value="">Select Business</option>
                                            @foreach($businesses as $id => $name)
                                                <option value="{{ $id }}" 
                                                    {{ (isset($branch) && $branch->business_id == $id) || old('business_id') == $id ? 'selected' : '' }}>
                                                    {{ $name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('business_id') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name *</label>
                                        <input type="text" name="name" class="form-control" 
                                            placeholder="Enter Branch Name" 
                                            value="{{ old('name', $branch->name ?? '') }}" required>
                                        @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Code *</label>
                                        <input type="text" name="code" class="form-control" 
                                            placeholder="Enter Unique Code" 
                                            value="{{ old('code', $branch->code ?? '') }}" required>
                                        @error('code') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone *</label>
                                        <input type="text" name="phone" class="form-control" 
                                            placeholder="Enter Phone Number" 
                                            value="{{ old('phone', $branch->phone ?? '') }}" required>
                                        @error('phone') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email *</label>
                                        <input type="email" name="email" class="form-control" 
                                            placeholder="Enter Email" 
                                            value="{{ old('email', $branch->email ?? '') }}" required>
                                        @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Main Branch</label>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="is_main" 
                                                name="is_main" value="1"
                                                {{ old('is_main', $branch->is_main ?? false) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="is_main">Mark as main branch</label>
                                        </div>
                                        <small class="text-muted">Only one branch can be the main branch per business</small>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Address *</label>
                                        <textarea name="address" class="form-control" rows="3" required>{{ old('address', $branch->address ?? '') }}</textarea>
                                        @error('address') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">
                                {{ isset($branch) ? 'Update' : 'Save' }} Branch
                            </button>
                            <button type="reset" class="btn btn-danger">Reset</button>
                            <a href="{{ route('branches.index') }}" class="btn btn-light">Cancel</a>
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