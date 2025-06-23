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
                        <h4 class="mb-3">Account Details</h4>
                        <p class="mb-0">View detailed information about this account and its transactions</p>
                    </div>
                    <a href="{{ route('accounting.accounts.index') }}" class="btn btn-primary add-list">
                        <i class="las la-arrow-left mr-3"></i>Back to Accounts
                    </a>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <div class="header-title">
                            <h4 class="card-title">Account Information</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span>Account Name:</span>
                            <span class="font-weight-bold">{{ $account->name }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Account Type:</span>
                            <span>{{ $account->type }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Account Number:</span>
                            <span>{{ $account->account_number ?? 'N/A' }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Currency:</span>
                            <span>{{ $account->currency }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Status:</span>
                            <span class="badge {{ $account->is_active ? 'badge-success' : 'badge-danger' }}">
                                {{ $account->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Opening Balance:</span>
                            <span class="font-weight-bold">{{ format_currency($account->opening_balance) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Current Balance:</span>
                            <span class="font-weight-bold {{ $account->current_balance >= $account->opening_balance ? 'text-success' : 'text-danger' }}">
                                {{ format_currency($account->current_balance) }}
                            </span>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label>Description</label>
                            <p class="form-control-static">{{ $account->description ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('accounting.accounts.edit', $account->id) }}" class="btn btn-primary mr-2">
                            <i class="ri-pencil-line mr-2"></i> Edit Account
                        </a>
                        @if($account->transactions->count() == 0)
                        <form action="{{ route('accounting.accounts.destroy', $account->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this account?')">
                                <i class="ri-delete-bin-line mr-2"></i> Delete Account
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Recent Transactions</h4>
                        </div>
                        <a href="{{ route('accounting.transactions.create') }}?account_id={{ $account->id }}" class="btn btn-sm btn-primary">
                            <i class="ri-add-line mr-1"></i> Add Transaction
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                        <th>Balance</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->date->format('d M Y') }}</td>
                                        <td>
                                            <span class="badge 
                                                {{ $transaction->type === 'income' ? 'badge-success' : '' }}
                                                {{ $transaction->type === 'expense' ? 'badge-danger' : '' }}
                                                {{ $transaction->type === 'transfer' ? 'badge-info' : '' }}">
                                                {{ ucfirst($transaction->type) }}
                                            </span>
                                        </td>
                                        <td>{{ Str::limit($transaction->description, 30) ?? 'N/A' }}</td>
                                        <td class="{{ $transaction->type === 'income' ? 'text-success' : 'text-danger' }}">
                                            {{ $transaction->type === 'income' ? '+' : '-' }}{{ format_currency($transaction->amount) }}
                                        </td>
                                        <td>
                                            @php
                                                // This would need proper calculation based on transaction history
                                                $balance = $account->opening_balance + $account->transactions->where('date', '<=', $transaction->date)->sum(function($t) {
                                                    return $t->type === 'income' ? $t->amount : -$t->amount;
                                                });
                                            @endphp
                                            {{ format_currency($balance) }}
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center list-action">
                                                <a class="badge badge-info mr-2" data-toggle="tooltip"
                                                    data-placement="top" title="View" 
                                                    href="{{ route('accounting.transactions.show', $transaction->id) }}">
                                                    <i class="ri-eye-line mr-0"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $transactions->links() }}
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