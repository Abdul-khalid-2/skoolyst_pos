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
                        <h4 class="mb-3">Transaction Details</h4>
                        <p class="mb-0">View detailed information about this transaction</p>
                    </div>
                    <a href="{{ route('transactions.index') }}" class="btn btn-primary add-list">
                        <i class="las la-arrow-left mr-3"></i>Back to Transactions
                    </a>
                </div>
            </div>
 
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <div class="header-title">
                            <h4 class="card-title">Transaction Information</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Transaction Type</label>
                                    <p class="form-control-static">
                                        <span class="badge 
                                            {{ $transaction->type === 'income' ? 'badge-success' : '' }}
                                            {{ $transaction->type === 'expense' ? 'badge-danger' : '' }}
                                            {{ $transaction->type === 'transfer' ? 'badge-info' : '' }}">
                                            {{ ucfirst($transaction->type) }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date</label>
                                    <p class="form-control-static">{{ $transaction->date->format('d M Y') }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Account</label>
                                    <p class="form-control-static">{{ $transaction->account->name }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Amount</label>
                                    <p class="form-control-static">{{ format_currency($transaction->amount) }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Category</label>
                                    <p class="form-control-static">{{ $transaction->category ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Reference</label>
                                    <p class="form-control-static">{{ $transaction->reference ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <p class="form-control-static">{{ $transaction->description ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Recorded By</label>
                                    <p class="form-control-static">{{ $transaction->user->name }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Recorded At</label>
                                    <p class="form-control-static">{{ $transaction->created_at->format('d M Y H:i') }}</p>
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
                            <span class="font-weight-bold">{{ $transaction->account->name }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Account Type:</span>
                            <span>{{ $transaction->account->type }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Account Number:</span>
                            <span>{{ $transaction->account->account_number ?? 'N/A' }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Currency:</span>
                            <span>{{ $transaction->account->currency }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Current Balance:</span>
                            <span class="font-weight-bold">{{ format_currency($transaction->account->current_balance) }}</span>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body text-center">
                        <a href="{{ route('transactions.edit', $transaction->id) }}" class="btn btn-primary btn-block mb-3">
                            <i class="ri-pencil-line mr-2"></i> Edit Transaction
                        </a>
                        <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-block" onclick="return confirm('Are you sure you want to delete this transaction?')">
                                <i class="ri-delete-bin-line mr-2"></i> Delete Transaction
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


    <!-- app JavaScript -->
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>
    @endpush
</x-app-layout>