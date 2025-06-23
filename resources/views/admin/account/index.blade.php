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
                        <h4 class="mb-3">Accounts List</h4>
                        <p class="mb-0">Manage all your business accounts to track financial transactions<br> 
                        and maintain accurate balance records.</p>
                    </div>
                    <a href="{{ route('accounts.create') }}" class="btn btn-primary add-list">
                        <i class="las la-plus mr-3"></i>Add Account
                    </a>
                </div>
            </div>
            
            <!-- Summary Card -->
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card bg-primary text-white mb-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-white mb-0">Total Accounts</h6>
                                        <h2 class="mb-0 text-white">{{ $accounts->total() }}</h2>
                                    </div>
                                    <div class="bg-white rounded p-3">
                                        <i class="ri-bank-line text-primary" style="font-size: 24px;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-success text-white mb-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-white mb-0">Active Accounts</h6>
                                        <h2 class="mb-0 text-white">{{ $activeAccounts }}</h2>
                                    </div>
                                    <div class="bg-white rounded p-3">
                                        <i class="ri-checkbox-circle-line text-success" style="font-size: 24px;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-info text-white mb-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-white mb-0">Total Balance</h6>
                                        <h2 class="mb-0 text-white">{{ format_currency($totalBalance) }}</h2>
                                    </div>
                                    <div class="bg-white rounded p-3">
                                        <i class="ri-money-dollar-circle-line text-info" style="font-size: 24px;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-12">
                <div class="table-responsive rounded mb-3">
                    <table class="data-tables table mb-0 tbl-server-info">
                        <thead class="bg-white text-uppercase">
                            <tr class="ligth ligth-data">
                                <th>Account Name</th>
                                <th>Type</th>
                                <th>Account Number</th>
                                <th>Currency</th>
                                <th>Opening Balance</th>
                                <th>Current Balance</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="ligth-body">
                            @foreach($accounts as $account)
                            <tr>
                                <td>{{ $account->name }}</td>
                                <td>{{ $account->type }}</td>
                                <td>{{ $account->account_number ?? 'N/A' }}</td>
                                <td>{{ $account->currency }}</td>
                                <td>{{ format_currency($account->opening_balance) }}</td>
                                <td>
                                    <span class="badge 
                                        {{ $account->current_balance >= $account->opening_balance ? 'badge-success' : 'badge-danger' }}">
                                        {{ format_currency($account->current_balance) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $account->is_active ? 'badge-success' : 'badge-danger' }}">
                                        {{ $account->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center list-action">
                                        <a class="badge badge-info mr-2" data-toggle="tooltip"
                                            data-placement="top" title="View" 
                                            href="{{ route('accounts.show', $account->id) }}">
                                            <i class="ri-eye-line mr-0"></i>
                                        </a>
                                        <a class="badge bg-success mr-2" data-toggle="tooltip"
                                            data-placement="top" title="Edit" 
                                            href="{{ route('accounts.edit', $account->id) }}">
                                            <i class="ri-pencil-line mr-0"></i>
                                        </a>
                                        <form action="{{ route('accounts.destroy', $account->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="badge bg-warning mr-2 border-0" data-toggle="tooltip"
                                                data-placement="top" title="Delete" 
                                                onclick="return confirm('Are you sure you want to delete this account?')">
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