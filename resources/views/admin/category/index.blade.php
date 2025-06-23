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
                        <h4 class="mb-3">Category List</h4>
                        <p class="mb-0">Manage all product categories in a hierarchical structure.<br> Organize your products for better inventory management.</p>
                    </div>
                    <a href="{{ route('categories.create') }}" class="btn btn-primary add-list"><i
                            class="las la-plus mr-3"></i>Add Category</a>
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
                                <th>Name</th>
                                <th>Code</th>
                                <th>Parent Category</th>
                                <th>Products</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="ligth-body">
                            @foreach($categories as $category)
                            <tr>
                                <td>
                                    <div class="checkbox d-inline-block">
                                        <input type="checkbox" class="checkbox-input" id="checkbox{{ $category->id }}">
                                        <label for="checkbox{{ $category->id }}" class="mb-0"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-50 mr-3 bg-primary rounded-circle d-flex align-items-center justify-content-center">
                                            <span class="text-white">{{ strtoupper(substr($category->name, 0, 1)) }}</span>
                                        </div>
                                        <div>
                                            {{ $category->name }}
                                            @if($category->children->count() > 0)
                                            <p class="mb-0"><small>{{ $category->children->count() }} subcategories</small></p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $category->code ?? 'N/A' }}</td>
                                <td>{{ $category->parent->name ?? 'N/A' }}</td>
                                <td>{{ $category->products_count ?? 0 }}</td>
                                <td>{{ Str::limit($category->description, 30) ?? 'N/A' }}</td>
                                <td>
                                    <div class="d-flex align-items-center list-action">
                                        <a class="badge badge-info mr-2" data-toggle="tooltip"
                                            data-placement="top" title="View" href="{{ route('categories.show', $category->id) }}"><i
                                                class="ri-eye-line mr-0"></i></a>
                                        <a class="badge bg-success mr-2" data-toggle="tooltip"
                                            data-placement="top" title="Edit" href="{{ route('categories.edit', $category->id) }}"><i
                                                class="ri-pencil-line mr-0"></i></a>
                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="badge bg-warning mr-2 border-0" data-toggle="tooltip"
                                                data-placement="top" title="Delete" onclick="return confirm('Are you sure you want to delete this category?')"><i class="ri-delete-bin-line mr-0"></i></button>
                                        </form>
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