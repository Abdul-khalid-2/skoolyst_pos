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
                            <h4 class="card-title">{{ isset($transaction) ? 'Edit' : 'Add' }} Transaction</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ isset($transaction) ? route('transactions.update', $transaction->id) : route('transactions.store') }}" method="POST" data-toggle="validator">
                            @csrf
                            @if(isset($transaction))
                                @method('PUT')
                            @endif

                            <div class="row">
                                <!-- Account -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Account *</label>
                                        <select name="account_id" class="form-control" required>
                                            <option value="">Select Account</option>
                                            @foreach($accounts as $account)
                                                <option value="{{ $account->id }}" 
                                                    {{ old('account_id', $transaction->account_id ?? '') == $account->id ? 'selected' : '' }}>
                                                    {{ $account->name }} ({{ $account->type }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>

                                <!-- Type -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Type *</label>
                                        <select name="type" class="form-control" required>
                                            <option value="">Select Type</option>
                                            @foreach(['income', 'expense', 'transfer'] as $type)
                                                <option value="{{ $type }}" {{ old('type', $transaction->type ?? '') == $type ? 'selected' : '' }}>
                                                    {{ ucfirst($type) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>

                                <!-- Amount -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Amount *</label>
                                        <input type="number" step="0.01" name="amount" class="form-control" 
                                            placeholder="Enter Amount" 
                                            value="{{ old('amount', $transaction->amount ?? '') }}" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>

                                <!-- Date -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Date *</label>
                                        <input type="date" name="date" class="form-control" 
                                            value="{{ old('date', isset($transaction) ? $transaction->date->format('Y-m-d') : now()->format('Y-m-d')) }}" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>

                                <!-- Category -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Category</label>
                                        <input type="text" name="category" class="form-control" 
                                            placeholder="Enter Category (optional)" 
                                            value="{{ old('category', $transaction->category ?? '') }}">
                                    </div>
                                </div>

                                <!-- Reference -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Reference</label>
                                        <input type="text" name="reference" class="form-control" 
                                            placeholder="Enter Reference (optional)" 
                                            value="{{ old('reference', $transaction->reference ?? '') }}">
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea name="description" class="form-control" rows="3" 
                                            placeholder="Enter Description (optional)">{{ old('description', $transaction->description ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3">
                                {{ isset($transaction) ? 'Update' : 'Save' }} Transaction
                            </button>
                            <a href="{{ route('transactions.index') }}" class="btn btn-secondary mt-3">Cancel</a>
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


    <!-- app JavaScript -->
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>
    @endpush
</x-app-layout>
