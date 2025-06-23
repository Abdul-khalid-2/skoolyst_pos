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
                        <h4 class="mb-3">Tax Settings</h4>
                        <p class="mb-0">Manage tax rates and configure tax calculation preferences</p>
                    </div>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#addTaxModal">
                        <i class="ri-add-line"></i> Add Tax Rate
                    </button>
                </div>
            </div>
            
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive rounded mb-3">
                            <table class="data-tables table mb-0 tbl-server-info">
                                <thead class="bg-white text-uppercase">
                                    <tr class="ligth ligth-data">
                                        <th>Sno#</th>
                                        <th>Name</th>
                                        <th>Rate</th>
                                        <th>Type</th>
                                        <th>Inclusive</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="ligth-body">
                                    @foreach($taxRates as $key => $tax)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $tax->name }}</td>
                                            <td>{{ $tax->rate }}%</td>
                                            <td>{{ ucfirst($tax->type) }}</td>
                                            <td>
                                                @if($tax->is_inclusive)
                                                    <span class="badge bg-success">Yes</span>
                                                @else
                                                    <span class="badge bg-secondary">No</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center list-action">
                                                    <button class="badge bg-success mr-2 edit-tax-btn" 
                                                            data-id="{{ $tax->id }}"
                                                            data-name="{{ $tax->name }}"
                                                            data-rate="{{ $tax->rate }}"
                                                            data-type="{{ $tax->type }}"
                                                            data-is_inclusive="{{ $tax->is_inclusive }}"
                                                            data-description="{{ $tax->description }}">
                                                        <i class="ri-edit-line mr-0"></i>
                                                    </button>
                                                    
                                                    <form action="{{ route('tax-rates.destroy', $tax->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="badge bg-danger mr-2" onclick="return confirm('Are you sure?')">
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
                        
                        <div class="card mt-4">
                            <div class="card-header bg-primary text-white">
                                <h5>Default Tax Settings</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('settings.tax.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="form-group">
                                        <label>Default Tax Rate</label>
                                        <select class="form-control" name="default_tax_rate">
                                            <option value="">No Default Tax</option>
                                            @foreach($taxRates as $tax)
                                                <option value="{{ $tax->id }}" {{ (old('default_tax_rate', $settings['default_tax_rate'] ?? '') == $tax->id ? 'selected' : '' }}>
                                                    {{ $tax->name }} ({{ $tax->rate }}%)
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="enable_tax" 
                                                   name="enable_tax" value="1" {{ (old('enable_tax', $settings['enable_tax'] ?? true) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="enable_tax">Enable Tax System</label>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="tax_inclusive" 
                                                   name="tax_inclusive" value="1" {{ (old('tax_inclusive', $settings['tax_inclusive'] ?? false) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="tax_inclusive">Prices Include Tax</label>
                                        </div>
                                    </div>
                                    
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary">Save Tax Settings</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Tax Modal -->
    <div class="modal fade" id="addTaxModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Tax Rate</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('tax-rates.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Tax Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Tax Rate (%)</label>
                            <input type="number" class="form-control" name="rate" min="0" max="100" step="0.01" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Tax Type</label>
                            <select class="form-control" name="type" required>
                                <option value="percentage">Percentage</option>
                                <option value="fixed">Fixed Amount</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_inclusive" name="is_inclusive" value="1">
                                <label class="custom-control-label" for="is_inclusive">Tax Inclusive</label>
                            </div>
                            <small class="form-text text-muted">If checked, tax is included in the product price</small>
                        </div>
                        
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" name="description" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Tax Rate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Tax Modal -->
    <div class="modal fade" id="editTaxModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Tax Rate</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editTaxForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Tax Name</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Tax Rate (%)</label>
                            <input type="number" class="form-control" id="edit_rate" name="rate" min="0" max="100" step="0.01" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Tax Type</label>
                            <select class="form-control" id="edit_type" name="type" required>
                                <option value="percentage">Percentage</option>
                                <option value="fixed">Fixed Amount</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="edit_is_inclusive" name="is_inclusive" value="1">
                                <label class="custom-control-label" for="edit_is_inclusive">Tax Inclusive</label>
                            </div>
                            <small class="form-text text-muted">If checked, tax is included in the product price</small>
                        </div>
                        
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" id="edit_description" name="description" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Tax Rate</button>
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
            // Handle edit button click
            $('.edit-tax-btn').click(function() {
                var taxId = $(this).data('id');
                var taxName = $(this).data('name');
                var taxRate = $(this).data('rate');
                var taxType = $(this).data('type');
                var taxInclusive = $(this).data('is_inclusive');
                var taxDescription = $(this).data('description');
                
                // Set form action URL
                $('#editTaxForm').attr('action', '/tax-rates/' + taxId);
                
                // Populate form fields
                $('#edit_name').val(taxName);
                $('#edit_rate').val(taxRate);
                $('#edit_type').val(taxType);
                $('#edit_is_inclusive').prop('checked', taxInclusive);
                $('#edit_description').val(taxDescription);
                
                // Show modal
                $('#editTaxModal').modal('show');
            });
        });
    </script>
    @endpush
</x-app-layout>