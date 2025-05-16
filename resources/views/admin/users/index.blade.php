
<x-app-layout>

    @push('css')
        <link rel="shortcut icon" href="{{ asset('Backend/assets/images/favicon.ico') }}" />
        <link rel="stylesheet" href="{{ asset('Backend/assets/css/backend-plugin.min.css') }}">
        <link rel="stylesheet" href="{{ asset('Backend/assets/css/backend.css?v=1.0.0') }}">
        <link rel="stylesheet" href="{{ asset('Backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet"
            href="{{ asset('Backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('Backend/assets/vendor/remixicon/fonts/remixicon.css') }}">
    @endpush
        <div class="container-fluid add-form-list">
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                        <div>
                            <h4 class="mb-3">User List</h4>
                            <p class="mb-0">A dashboard provides you an overview of user list with access to the most important data,<br>
                             functions and controls. </p>
                        </div>
                        <a href="page-add-users.html" class="btn btn-primary add-list"><i class="las la-plus mr-3"></i>Add User</a>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="table-responsive rounded mb-3">
                    <table class="data-table table mb-0 tbl-server-info">
                        <thead class="bg-white text-uppercase">
                            <tr class="ligth ligth-data">
                                <th>
                                    <div class="checkbox d-inline-block">
                                        <input type="checkbox" class="checkbox-input" id="checkbox1">
                                        <label for="checkbox1" class="mb-0"></label>
                                    </div>
                                </th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Company</th>
                                <th>Awors Points</th>
                                <th>Group</th>
                                <th>Status</th>
                                <th>Store</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="ligth-body">
                            <tr>
                                <td>
                                    <div class="checkbox d-inline-block">
                                        <input type="checkbox" class="checkbox-input" id="checkbox2">
                                        <label for="checkbox2" class="mb-0"></label>
                                    </div>
                                </td>
                                <td>Cliff Hanger</td>
                                <td>cliff@gmail.com</td>
                                <td>Product Manager</td>
                                <td>0</td>
                                <td>Cliff</td>
                                <td>Active</td>
                                <td>1</td>
                                <td>
                                    <div class="d-flex align-items-center list-action">
                                        <a class="badge badge-info mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" href="#"><i class="ri-eye-line mr-0"></i></a>
                                        <a class="badge bg-success mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" href="#"><i class="ri-pencil-line mr-0"></i></a>
                                        <a class="badge bg-warning mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" href="#"><i class="ri-delete-bin-line mr-0"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="checkbox d-inline-block">
                                        <input type="checkbox" class="checkbox-input" id="checkbox3">
                                        <label for="checkbox3" class="mb-0"></label>
                                    </div>
                                </td>
                                <td>Terry Aki</td>
                                <td>terry@gmail.com</td>
                                <td>Stock CEO</td>
                                <td>0</td>
                                <td>Terry</td>
                                <td>Active</td>
                                <td>2</td>
                                <td>
                                    <div class="d-flex align-items-center list-action">
                                        <a class="badge badge-info mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" href="#"><i class="ri-eye-line mr-0"></i></a>
                                        <a class="badge bg-success mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" href="#"><i class="ri-pencil-line mr-0"></i></a>
                                        <a class="badge bg-warning mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" href="#"><i class="ri-delete-bin-line mr-0"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="checkbox d-inline-block">
                                        <input type="checkbox" class="checkbox-input" id="checkbox4">
                                        <label for="checkbox4" class="mb-0"></label>
                                    </div>
                                </td>
                                <td>Ira Membrit</td>
                                <td>ira@gmail.com</td>
                                <td>Stock Manager</td>
                                <td>0</td>
                                <td>Ira</td>
                                <td>Active</td>
                                <td>3</td>
                                <td>
                                    <div class="d-flex align-items-center list-action">
                                        <a class="badge badge-info mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" href="#"><i class="ri-eye-line mr-0"></i></a>
                                        <a class="badge bg-success mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" href="#"><i class="ri-pencil-line mr-0"></i></a>
                                        <a class="badge bg-warning mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" href="#"><i class="ri-delete-bin-line mr-0"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="checkbox d-inline-block">
                                        <input type="checkbox" class="checkbox-input" id="checkbox5">
                                        <label for="checkbox5" class="mb-0"></label>
                                    </div>
                                </td>
                                <td>Barb Ackue</td>
                                <td>barb@gmail.com</td>
                                <td>Stock Developer</td>
                                <td>0</td>
                                <td>Barb</td>
                                <td>Active</td>
                                <td>1</td>
                                <td>
                                    <div class="d-flex align-items-center list-action">
                                        <a class="badge badge-info mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" href="#"><i class="ri-eye-line mr-0"></i></a>
                                        <a class="badge bg-success mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" href="#"><i class="ri-pencil-line mr-0"></i></a>
                                        <a class="badge bg-warning mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" href="#"><i class="ri-delete-bin-line mr-0"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="checkbox d-inline-block">
                                        <input type="checkbox" class="checkbox-input" id="checkbox6">
                                        <label for="checkbox6" class="mb-0"></label>
                                    </div>
                                </td>
                                <td>Max Conversion</td>
                                <td>max@gmail.com</td>
                                <td>Stock Manager</td>
                                <td>0</td>
                                <td>Max</td>
                                <td>Active</td>
                                <td>1</td>
                                <td>
                                    <div class="d-flex align-items-center list-action">
                                        <a class="badge badge-info mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" href="#"><i class="ri-eye-line mr-0"></i></a>
                                        <a class="badge bg-success mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" href="#"><i class="ri-pencil-line mr-0"></i></a>
                                        <a class="badge bg-warning mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" href="#"><i class="ri-delete-bin-line mr-0"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="checkbox d-inline-block">
                                        <input type="checkbox" class="checkbox-input" id="checkbox7">
                                        <label for="checkbox7" class="mb-0"></label>
                                    </div>
                                </td>
                                <td>Alex john</td>
                                <td>alex@gmail.com</td>
                                <td>Product Manager</td>
                                <td>0</td>
                                <td>Alex</td>
                                <td>Active</td>
                                <td>2</td>
                                <td>
                                    <div class="d-flex align-items-center list-action">
                                        <a class="badge badge-info mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" href="#"><i class="ri-eye-line mr-0"></i></a>
                                        <a class="badge bg-success mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" href="#"><i class="ri-pencil-line mr-0"></i></a>
                                        <a class="badge bg-warning mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" href="#"><i class="ri-delete-bin-line mr-0"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="checkbox d-inline-block">
                                        <input type="checkbox" class="checkbox-input" id="checkbox8">
                                        <label for="checkbox8" class="mb-0"></label>
                                    </div>
                                </td>
                                <td>Paige Turner</td>
                                <td>paige@gmail.com</td>
                                <td>Stock Developer</td>
                                <td>0</td>
                                <td>Paige</td>
                                <td>Active</td>
                                <td>2</td>
                                <td>
                                    <div class="d-flex align-items-center list-action">
                                        <a class="badge badge-info mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" href="#"><i class="ri-eye-line mr-0"></i></a>
                                        <a class="badge bg-success mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" href="#"><i class="ri-pencil-line mr-0"></i></a>
                                        <a class="badge bg-warning mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" href="#"><i class="ri-delete-bin-line mr-0"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="checkbox d-inline-block">
                                        <input type="checkbox" class="checkbox-input" id="checkbox9">
                                        <label for="checkbox9" class="mb-0"></label>
                                    </div>
                                </td>
                                <td>Greta Life</td>
                                <td>greta@gmail.com</td>
                                <td>Product Manager</td>
                                <td>0</td>
                                <td>Greta</td>
                                <td>Active</td>
                                <td>4</td>
                                <td>
                                    <div class="d-flex align-items-center list-action">
                                        <a class="badge badge-info mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" href="#"><i class="ri-eye-line mr-0"></i></a>
                                        <a class="badge bg-success mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" href="#"><i class="ri-pencil-line mr-0"></i></a>
                                        <a class="badge bg-warning mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" href="#"><i class="ri-delete-bin-line mr-0"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="checkbox d-inline-block">
                                        <input type="checkbox" class="checkbox-input" id="checkbox10">
                                        <label for="checkbox10" class="mb-0"></label>
                                    </div>
                                </td>
                                <td>Anna Mull</td>
                                <td>anna@gmail.com</td>
                                <td>Stock Manager</td>
                                <td>0</td>
                                <td>Anna</td>
                                <td>Active</td>
                                <td>1</td>
                                <td>
                                    <div class="d-flex align-items-center list-action">
                                        <a class="badge badge-info mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" href="#"><i class="ri-eye-line mr-0"></i></a>
                                        <a class="badge bg-success mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" href="#"><i class="ri-pencil-line mr-0"></i></a>
                                        <a class="badge bg-warning mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" href="#"><i class="ri-delete-bin-line mr-0"></i></a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    @push('js')
            <!-- Backend Bundle JavaScript -->
            <script src="{{ asset('Backend/assets/js/backend-bundle.min.js') }}"></script>
            <!-- Table Treeview JavaScript -->
            <script src="{{ asset('Backend/assets/js/table-treeview.js') }}"></script>
            <!-- Chart Custom JavaScript -->
            <script src="{{ asset('Backend/assets/js/customizer.js') }}"></script>
            <!-- Chart Custom JavaScript -->
            <script async src="{{ asset('Backend/assets/js/chart-custom.js') }}"></script>
            <!-- app JavaScript -->
            <script src="{{ asset('Backend/assets/js/app.js') }}"></script>
    @endpush
</x-app-layout>