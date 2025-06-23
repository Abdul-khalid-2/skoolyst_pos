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
                            <h4 class="card-title">Edit User</h4>
                        </div>
                        <div>
                            <a href="{{ route('users.show', $user->id) }}" class="btn btn-info">View Details</a>
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to List</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('users.update', $user->id) }}" method="POST" data-toggle="validator" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Full Name *</label>
                                        <input type="text" name="name" class="form-control" placeholder="Enter Full Name" value="{{ old('name', $user->name) }}" required>
                                        <div class="help-block with-errors"></div>
                                        @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email *</label>
                                        <input type="email" name="email" class="form-control" placeholder="Enter Email" value="{{ old('email', $user->email) }}" required>
                                        <div class="help-block with-errors"></div>
                                        @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone Number</label>
                                        <input type="text" name="phone" class="form-control" placeholder="Enter Phone Number" value="{{ old('phone', $user->phone) }}">
                                        @error('phone') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Role *</label>
                                        <select name="role" class="selectpicker form-control" data-style="py-0" required>
                                            <option value="">Select Role</option>
                                            @foreach($roles as $role)
                                                <option value="{{ $role->name }}" {{ (old('role', $user->getRoleNames()->first()) == $role->name) ? 'selected' : '' }}>{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('role') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Profile Image</label>
                                        <div class="d-flex align-items-center">
                                            @if($user->profile_image)
                                                <img src="{{ Storage::disk('website')->url($user->profile_image) }}" alt="Current Profile Image" class="img-thumbnail mr-3" style="width: 80px; height: 80px; object-fit: cover;">
                                            @endif
                                            <input type="file" class="form-control image-file" name="profile_image" accept="image/*">
                                        </div>
                                        @error('profile_image') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>New Password (Leave blank to keep current)</label>
                                        <input type="password" name="password" class="form-control" placeholder="Enter New Password">
                                        <div class="help-block with-errors"></div>
                                        @error('password') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Confirm New Password</label>
                                        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm New Password">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Update User</button>
                            <button type="reset" class="btn btn-danger">Reset</button>
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