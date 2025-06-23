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
                            <h4 class="card-title">{{ isset($expense) ? 'Edit' : 'Add' }} Expense</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ isset($expense) ? route('expenses.update', $expense->id) : route('expenses.store') }}" method="POST" data-toggle="validator">
                            @csrf
                            @if(isset($expense))
                                @method('PUT')
                            @endif
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Expense Category *</label>
                                        <select name="expense_category_id" class="form-control" required>
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" 
                                                    {{ (isset($expense) && $expense->expense_category_id == $category->id) ? 'selected' : '' }}
                                                    {{ old('expense_category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Account *</label>
                                        <select name="account_id" class="form-control" required>
                                            <option value="">Select Account</option>
                                            @foreach($accounts as $account)
                                                <option value="{{ $account->id }}" 
                                                    {{ (isset($expense) && $expense->account_id == $account->id) ? 'selected' : '' }}
                                                    {{ old('account_id') == $account->id ? 'selected' : '' }}>
                                                    {{ $account->name }} ({{ $account->type }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Branch *</label>
                                        <select name="branch_id" class="form-control" required>
                                            <option value="">Select Branch</option>
                                            @foreach($branches as $branch)
                                                <option value="{{ $branch->id }}" 
                                                    {{ (isset($expense) && $expense->branch_id == $branch->id) ? 'selected' : '' }}
                                                    {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                                    {{ $branch->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Amount *</label>
                                        <input type="number" step="0.01" name="amount" class="form-control" 
                                            placeholder="Enter Amount" 
                                            value="{{ isset($expense) ? $expense->amount : old('amount') }}" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Date *</label>
                                        <input type="date" name="date" class="form-control" 
                                            value="{{ isset($expense) ? $expense->date->format('Y-m-d') : (old('date') ?? date('Y-m-d')) }}" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Reference</label>
                                        <input type="text" name="reference" class="form-control" 
                                            placeholder="Enter Reference" 
                                            value="{{ isset($expense) ? $expense->reference : old('reference') }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea name="description" class="form-control" rows="3">{{ isset($expense) ? $expense->description : old('description') }}</textarea>
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