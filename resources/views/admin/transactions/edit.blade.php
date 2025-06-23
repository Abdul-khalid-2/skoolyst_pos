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
                            <h4 class="card-title">Edit Transaction #{{ $transaction->id }}</h4>
                        </div>
                        <div>
                            <a href="{{ route('transactions.show', $transaction->id) }}" class="btn btn-sm btn-primary mr-1">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-light">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('transactions.update', $transaction->id) }}" method="POST" data-toggle="validator">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <!-- Account -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Account *</label>
                                        <select name="account_id" class="form-control" required>
                                            <option value="">Select Account</option>
                                            @foreach($accounts as $account)
                                                <option value="{{ $account->id }}" 
                                                    {{ old('account_id', $transaction->account_id) == $account->id ? 'selected' : '' }}>
                                                    {{ $account->name }} ({{ $account->type }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="help-block with-errors"></div>
                                        @error('account_id') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <!-- Type -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Type *</label>
                                        <select name="type" class="form-control" required>
                                            <option value="">Select Type</option>
                                            @foreach(['income', 'expense', 'transfer'] as $type)
                                                <option value="{{ $type }}" {{ old('type', $transaction->type) == $type ? 'selected' : '' }}>
                                                    {{ ucfirst($type) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="help-block with-errors"></div>
                                        @error('type') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <!-- Amount -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Amount *</label>
                                        <input type="number" step="0.01" name="amount" class="form-control" 
                                            placeholder="Enter Amount" 
                                            value="{{ old('amount', $transaction->amount) }}" required>
                                        <div class="help-block with-errors"></div>
                                        @error('amount') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <!-- Date -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Date *</label>
                                        <input type="date" name="date" class="form-control" 
                                            value="{{ old('date', $transaction->date->format('Y-m-d')) }}" required>
                                        <div class="help-block with-errors"></div>
                                        @error('date') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <!-- Category -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Category</label>
                                        <input type="text" name="category" class="form-control" 
                                            placeholder="Enter Category (optional)" 
                                            value="{{ old('category', $transaction->category) }}">
                                        @error('category') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <!-- Reference -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Reference</label>
                                        <input type="text" name="reference" class="form-control" 
                                            placeholder="Enter Reference (optional)" 
                                            value="{{ old('reference', $transaction->reference) }}">
                                        @error('reference') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea name="description" class="form-control" rows="3" 
                                            placeholder="Enter Description (optional)">{{ old('description', $transaction->description) }}</textarea>
                                        @error('description') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save mr-1"></i> Update Transaction
                                </button>
                                
                                <div>
                                    <a href="{{ route('transactions.index') }}" class="btn btn-secondary mr-2">
                                        <i class="fas fa-times mr-1"></i> Cancel
                                    </a>
                                    <button type="reset" class="btn btn-danger">
                                        <i class="fas fa-undo mr-1"></i> Reset
                                    </button>
                                </div>
                            </div>
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

        <script>
            $(document).ready(function() {
                // Type change handler to show/hide additional fields if needed
                $('select[name="type"]').change(function() {
                    // You can add dynamic behavior here if needed
                    // For example, show different fields based on transaction type
                });
            });
        </script>
    @endpush
</x-app-layout>