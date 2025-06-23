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
                        <h4 class="mb-3">User List</h4>
                        <p class="mb-0">Manage all system users with different roles and permissions.<br> Control access to various features based on user roles.</p>
                    </div>
                    <a href="{{ route('users.create') }}" class="btn btn-primary add-list"><i
                            class="las la-plus mr-3"></i>Add User</a>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="table-responsive rounded mb-3">
                    <table class="data-tables table mb-0 tbl-server-info">
                        <thead class="bg-white text-uppercase">
                            <tr class="ligth ligth-data">
                                <th>
                                    <div class="checkbox d-inline-block">
                                        <input type="checkbox" class="checkbox-input" id="checkbox1">
                                        <label for="checkbox1" class="mb-0"></label>
                                    </div>
                                </th>
                                <th>User</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="ligth-body">
                            @foreach($users as $user)
                            <tr>
                                <td>
                                    <div class="checkbox d-inline-block">
                                        <input type="checkbox" class="checkbox-input" id="checkbox{{ $user->id }}">
                                        <label for="checkbox{{ $user->id }}" class="mb-0"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($user->profile_image)
                                        <img src="{{ asset('storage/'.$user->profile_image) }}"
                                            class="img-fluid rounded avatar-50 mr-3" alt="image">
                                        @else
                                        <div class="avatar-50 mr-3 bg-primary rounded-circle d-flex align-items-center justify-content-center">
                                            <span class="text-white">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                        </div>
                                        @endif
                                        <div>
                                            {{ $user->name }}
                                            <p class="mb-0"><small>Joined: {{ $user->created_at->format('M d, Y') }}</small></p>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone ?? 'N/A' }}</td>
                                <td>
                                    @foreach($user->roles as $role)
                                    <span class="badge badge-info">{{ $role->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <span class="badge badge-{{ $user->email_verified_at ? 'success' : 'warning' }}">
                                        {{ $user->email_verified_at ? 'Active' : 'Pending' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center list-action">
                                        <a class="badge badge-info mr-2" data-toggle="tooltip"
                                            data-placement="top" title="View" href="{{ route('users.show', $user->id) }}"><i
                                                class="ri-eye-line mr-0"></i></a>
                                        <a class="badge bg-success mr-2" data-toggle="tooltip"
                                            data-placement="top" title="Edit" href="{{ route('users.edit', $user->id) }}"><i
                                                class="ri-pencil-line mr-0"></i></a>
                                        @if($user->id != auth()->id())
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="badge bg-warning mr-2 border-0" data-toggle="tooltip"
                                                data-placement="top" title="Delete" onclick="return confirm('Are you sure you want to delete this user?')"><i class="ri-delete-bin-line mr-0"></i></button>
                                        </form>
                                        @endif
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