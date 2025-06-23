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
                            <h4 class="card-title">{{ isset($account) ? 'Edit' : 'Add' }} Account</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ isset($account) ? route('accounts.update', $account->id) : route('accounts.store') }}" method="POST" data-toggle="validator">
                            @csrf
                            @if(isset($account))
                                @method('PUT')
                            @endif
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Account Name *</label>
                                        <input type="text" name="name" class="form-control" 
                                            placeholder="Enter Account Name" 
                                            value="{{ isset($account) ? $account->name : old('name') }}" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Account Type *</label>
                                        <select name="type" class="form-control" required>
                                            <option value="">Select Type</option>
                                            <option value="Bank" {{ (isset($account) && $account->type == 'Bank') ? 'selected' : (old('type') == 'Bank' ? 'selected' : '') }}>Bank</option>
                                            <option value="Cash" {{ (isset($account) && $account->type == 'Cash') ? 'selected' : (old('type') == 'Cash' ? 'selected' : '') }}>Cash</option>
                                            <option value="Credit Card" {{ (isset($account) && $account->type == 'Credit Card') ? 'selected' : (old('type') == 'Credit Card' ? 'selected' : '') }}>Credit Card</option>
                                            <option value="Loan" {{ (isset($account) && $account->type == 'Loan') ? 'selected' : (old('type') == 'Loan' ? 'selected' : '') }}>Loan</option>
                                            <option value="Other" {{ (isset($account) && $account->type == 'Other') ? 'selected' : (old('type') == 'Other' ? 'selected' : '') }}>Other</option>
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Account Number</label>
                                        <input type="text" name="account_number" class="form-control" 
                                            placeholder="Enter Account Number" 
                                            value="{{ isset($account) ? $account->account_number : old('account_number') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Currency *</label>
                                        <select name="currency" class="form-control" required>
                                            <option value="Rs" {{ (isset($account) && $account->currency == 'Rs') ? 'selected' : (old('currency') == 'Rs' ? 'selected' : '') }}>Rs - Rupees</option>                                     <!-- Add more currencies as needed -->
                                            <option value="USD" {{ (isset($account) && $account->currency == 'Rs') ? 'selected' : (old('currency') == 'Rs' ? 'selected' : '') }}>USD - US Dollar</option>                                     <!-- Add more currencies as needed -->
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Opening Balance *</label>
                                        <input type="number" step="0.01" name="opening_balance" class="form-control" 
                                            placeholder="Enter Opening Balance" 
                                            value="{{ isset($account) ? $account->opening_balance : (old('opening_balance') ?? 0) }}" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                @if(isset($account))
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="is_active" 
                                                name="is_active" value="1" {{ $account->is_active ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="is_active">Active</label>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea name="description" class="form-control" rows="3">{{ isset($account) ? $account->description : old('description') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
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