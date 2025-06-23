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
                <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="mb-3">Record New Income</h4>
                        <p class="mb-0">Add a new income transaction to track your business revenue.</p>
                    </div>
                    <a href="{{ route('income.index') }}" class="btn btn-primary add-list">
                        <i class="las la-arrow-left mr-3"></i>Back to Income
                    </a>
                </div>
            </div>
            
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="header-title">
                            <h4 class="card-title">Income Details</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('income.store') }}">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="account_id">Account *</label>
                                        <select class="form-control" id="account_id" name="account_id" required>
                                            <option value="">Select Account</option>
                                            @foreach($accounts as $account)
                                                <option value="{{ $account->id }}" {{ old('account_id') == $account->id ? 'selected' : '' }}>
                                                    {{ $account->name }} ({{ $account->currency }} {{ format_currency($account->current_balance) }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('account_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="amount">Amount *</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">{{ auth()->user()->tenant->currency ?? 'Rs' }}</span>
                                            </div>
                                            <input type="number" step="0.01" class="form-control" id="amount" name="amount" 
                                                   value="{{ old('amount') }}" placeholder="0.00" required>
                                        </div>
                                        @error('amount')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="date">Date *</label>
                                        <input type="date" class="form-control" id="date" name="date" 
                                               value="{{ old('date', date('Y-m-d')) }}" required>
                                        @error('date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category">Category *</label>
                                        <input type="text" class="form-control" id="category" name="category" 
                                               value="{{ old('category') }}" placeholder="e.g. Sales, Services, etc." required>
                                        @error('category')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="reference">Reference</label>
                                        <input type="text" class="form-control" id="reference" name="reference" 
                                               value="{{ old('reference') }}" placeholder="Optional reference number">
                                        @error('reference')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" id="description" name="description" 
                                                  rows="3" placeholder="Optional description">{{ old('description') }}</textarea>
                                        @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-4 text-center">
                                <button type="submit" class="btn btn-primary">
                                    <i class="las la-save mr-2"></i> Record Income
                                </button>
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

    <!-- Chart Custom JavaScript -->
    <script async src="{{ asset('backend/assets/js/chart-custom.js') }}"></script>

    <!-- app JavaScript -->
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>
    
    <script>
        // Set default date to today
        document.addEventListener('DOMContentLoaded', function() {
            if (!document.getElementById('date').value) {
                document.getElementById('date').valueAsDate = new Date();
            }
        });
    </script>
    @endpush
</x-app-layout>