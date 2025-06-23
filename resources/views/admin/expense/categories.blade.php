<x-app-layout>
    @push('css')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css')}}">
    @endpush

    <div class="container-fluid">
        <!-- Success/Error Alerts -->
        <div id="ajax-alert" class="alert d-none" role="alert">
            <span id="ajax-alert-message"></span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex flex-wrap flex-wrap align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="mb-3">Expense Categories</h4>
                        <p class="mb-0">Manage your expense categories to better organize and track your business expenses.</p>
                    </div>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#addCategoryModal">
                        <i class="las la-plus mr-3"></i>Add Category
                    </button>
                </div>
            </div>
            
            <div class="col-lg-12">
                <div class="table-responsive rounded mb-3">
                    <table class="data-tables table mb-0 tbl-server-info">
                        <thead class="bg-white text-uppercase">
                            <tr class="ligth ligth-data">
                                <th>Name</th>
                                <th>Description</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="ligth-body">
                            @foreach($categories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->description ?? 'N/A' }}</td>
                                <td>{{ $category->created_at->format('d M Y') }}</td>
                                <td>
                                    <div class="d-flex align-items-center list-action">
                                        <a class="badge bg-success mr-2" data-toggle="modal" 
                                           data-target="#editCategoryModal" 
                                           data-id="{{ $category->id }}"
                                           data-name="{{ $category->name }}"
                                           data-description="{{ $category->description }}"
                                           title="Edit">
                                            <i class="ri-pencil-line mr-0"></i>
                                        </a>
                                        <form action="{{ route('expense-categories.destroy', $category->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="badge bg-warning mr-2 border-0" 
                                                title="Delete" 
                                                onclick="return confirm('Are you sure you want to delete this category?')">
                                                <i class="ri-delete-bin-line mr-0"></i>
                                            </button>
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

    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Expense Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addCategoryForm" action="{{ route('expense-categories.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name *</label>
                            <input type="text" class="form-control" name="name" required>
                            <div class="invalid-feedback" id="name-error"></div>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" name="description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="saveBtn">
                            <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Expense Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editCategoryForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name *</label>
                            <input type="text" class="form-control" name="name" id="editCategoryName" required>
                            <div class="invalid-feedback" id="edit-name-error"></div>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" name="description" id="editCategoryDescription" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="updateBtn">
                            <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                            Update
                        </button>
                    </div>
                </form>
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
            $(document).ready(function() {
                // Show alert function
                function showAlert(message, type = 'success') {
                    const alert = $('#ajax-alert');
                    alert.removeClass('d-none alert-success alert-danger').addClass(`alert-${type}`);
                    $('#ajax-alert-message').text(message);
                    setTimeout(() => alert.addClass('d-none'), 5000);
                }

                // Edit modal setup
                $('#editCategoryModal').on('show.bs.modal', function(event) {
                    const button = $(event.relatedTarget);
                    const id = button.data('id');
                    const name = button.data('name');
                    const description = button.data('description');
                    
                    const modal = $(this);
                    modal.find('#editCategoryForm').attr('action', `/accounting/expense-categories/${id}`);
                    modal.find('#editCategoryName').val(name);
                    modal.find('#editCategoryDescription').val(description || '');
                });

                // Add category form submission
                $('#addCategoryForm').on('submit', function(e) {
                    e.preventDefault();
                    const form = $(this);
                    const url = form.attr('action');
                    const data = form.serialize();
                    const saveBtn = $('#saveBtn');

                    // Reset errors
                    form.find('.is-invalid').removeClass('is-invalid');
                    $('.invalid-feedback').text('');

                    // Show loading
                    saveBtn.prop('disabled', true);
                    saveBtn.find('.spinner-border').removeClass('d-none');

                    $.ajax({
                        url: url,
                        method: "POST",
                        data: data,
                        success: function(response) {
                            $('#addCategoryModal').modal('hide');
                            form[0].reset();
                            showAlert(response.message);
                            // Reload page to see new category
                            setTimeout(() => location.reload(), 1000);
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                                const errors = xhr.responseJSON.errors;
                                for (const [key, value] of Object.entries(errors)) {
                                    $(`[name="${key}"]`).addClass('is-invalid');
                                    $(`#${key}-error`).text(value[0]);
                                }
                            } else {
                                showAlert(xhr.responseJSON.message || 'An error occurred', 'danger');
                            }
                        },
                        complete: function() {
                            saveBtn.prop('disabled', false);
                            saveBtn.find('.spinner-border').addClass('d-none');
                        }
                    });
                });

                // Edit category form submission
                $('#editCategoryForm').on('submit', function(e) {
                    e.preventDefault();
                    const form = $(this);
                    const url = form.attr('action');
                    const data = form.serialize();
                    const updateBtn = $('#updateBtn');

                    // Reset errors
                    form.find('.is-invalid').removeClass('is-invalid');
                    $('.invalid-feedback').text('');

                    // Show loading
                    updateBtn.prop('disabled', true);
                    updateBtn.find('.spinner-border').removeClass('d-none');

                    $.ajax({
                        url: url,
                        method: "POST",
                        data: data,
                        success: function(response) {
                            $('#editCategoryModal').modal('hide');
                            showAlert(response.message);
                            // Reload page to see updated category
                            setTimeout(() => location.reload(), 1000);
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                                const errors = xhr.responseJSON.errors;
                                for (const [key, value] of Object.entries(errors)) {
                                    $(`#edit${key.charAt(0).toUpperCase() + key.slice(1)}`).addClass('is-invalid');
                                    $(`#edit-${key}-error`).text(value[0]);
                                }
                            } else {
                                showAlert(xhr.responseJSON.message || 'An error occurred', 'danger');
                            }
                        },
                        complete: function() {
                            updateBtn.prop('disabled', false);
                            updateBtn.find('.spinner-border').addClass('d-none');
                        }
                    });
                });
            });
        </script>
    @endpush
</x-app-layout>