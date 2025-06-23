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
                        <h4 class="mb-3">Transaction List</h4>
                        <p class="mb-0">Track all financial transactions including income, expenses, and transfers.<br> 
                        Maintain accurate financial records for better accounting.</p>
                    </div>
                    <a href="{{ route('transactions.create') }}" class="btn btn-primary add-list">
                        <i class="las la-plus mr-3"></i>Add Transaction
                    </a>
                </div>
            </div>
            
            <!-- Summary Cards -->
            <div class="col-lg-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white mb-0">Total Income</h6>
                                <h2 class="mb-0 text-white">{{ format_currency($income) }}</h2>
                            </div>
                            <div class="bg-white rounded p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-up text-primary">
                                    <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                                    <polyline points="17 6 23 6 23 12"></polyline>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white mb-0">Total Expenses</h6>
                                <h2 class="mb-0 text-white">{{ format_currency($expenses) }}</h2>
                            </div>
                            <div class="bg-white rounded p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-down text-danger">
                                    <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline>
                                    <polyline points="17 18 23 18 23 12"></polyline>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white mb-0">Net Balance</h6>
                                <h2 class="mb-0 text-white">{{ format_currency($income - $expenses) }}</h2>
                            </div>
                            <div class="bg-white rounded p-3">
                                <span width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign text-success">RS</span>
                                {{-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign text-success">
                                    <line x1="12" y1="1" x2="12" y2="23"></line>
                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                </svg> --}}
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
                                <th>Date</th>
                                <th>Account</th>
                                <th>Type</th>
                                <th>Category</th>
                                <th>Amount</th>
                                <th>Description</th>
                                <th>Reference</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="ligth-body">
                            @foreach($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->date->format('d M Y') }}</td>
                                <td>{{ $transaction->account->name }}</td>
                                <td>
                                    <span class="badge 
                                        {{ $transaction->type === 'income' ? 'badge-success' : '' }}
                                        {{ $transaction->type === 'expense' ? 'badge-danger' : '' }}
                                        {{ $transaction->type === 'transfer' ? 'badge-info' : '' }}">
                                        {{ ucfirst($transaction->type) }}
                                    </span>
                                </td>
                                <td>{{ $transaction->category ?? 'N/A' }}</td>
                                <td>{{ format_currency($transaction->amount) }}</td>
                                <td>{{ Str::limit($transaction->description, 30) ?? 'N/A' }}</td>
                                <td>{{ $transaction->reference ?? 'N/A' }}</td>
                                <td>
                                    <div class="d-flex align-items-center list-action">
                                        <a class="badge badge-info mr-2" data-toggle="tooltip"
                                            data-placement="top" title="View" 
                                            href="{{ route('transactions.show', $transaction->id) }}">
                                            <i class="ri-eye-line mr-0"></i>
                                        </a>
                                        <a class="badge bg-success mr-2" data-toggle="tooltip"
                                            data-placement="top" title="Edit" 
                                            href="{{ route('transactions.edit', $transaction->id) }}">
                                            <i class="ri-pencil-line mr-0"></i>
                                        </a>
                                        <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="badge bg-warning mr-2 border-0" data-toggle="tooltip"
                                                data-placement="top" title="Delete" 
                                                onclick="return confirm('Are you sure you want to delete this transaction?')">
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


    <!-- app JavaScript -->
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>
    @endpush
</x-app-layout>