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
                        <h4 class="mb-3">Expense Details</h4>
                        <p class="mb-0">View detailed information about this expense</p>
                    </div>
                    <a href="{{ route('expenses.index') }}" class="btn btn-primary add-list">
                        <i class="las la-arrow-left mr-3"></i>Back to Expenses
                    </a>
                </div>
            </div>
            
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <div class="header-title">
                            <h4 class="card-title">Expense Information</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Category</label>
                                    <p class="form-control-static">{{ $expense->category->name }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date</label>
                                    <p class="form-control-static">{{ $expense->date->format('d M Y') }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Account</label>
                                    <p class="form-control-static">{{ $expense->account->name }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Branch</label>
                                    <p class="form-control-static">{{ $expense->branch->name }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Amount</label>
                                    <p class="form-control-static">{{ format_currency($expense->amount) }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Reference</label>
                                    <p class="form-control-static">{{ $expense->reference ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <p class="form-control-static">{{ $expense->description ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Recorded By</label>
                                    <p class="form-control-static">{{ $expense->user->name }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Recorded At</label>
                                    <p class="form-control-static">{{ $expense->created_at->format('d M Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <div class="header-title">
                            <h4 class="card-title">Account Summary</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span>Account Name:</span>
                            <span class="font-weight-bold">{{ $expense->account->name }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Account Type:</span>
                            <span>{{ $expense->account->type }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Account Number:</span>
                            <span>{{ $expense->account->account_number ?? 'N/A' }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Currency:</span>
                            <span>{{ $expense->account->currency }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Current Balance:</span>
                            <span class="font-weight-bold">{{ format_currency($expense->account->current_balance) }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-body text-center">
                        <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-primary btn-block mb-3">
                            <i class="ri-pencil-line mr-2"></i> Edit Expense
                        </a>
                        <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-block" onclick="return confirm('Are you sure you want to delete this expense?')">
                                <i class="ri-delete-bin-line mr-2"></i> Delete Expense
                            </button>
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