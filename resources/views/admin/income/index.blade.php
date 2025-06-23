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
                        <h4 class="mb-3">Income List</h4>
                        <p class="mb-0">Track all business income to maintain accurate financial records and<br> 
                        better understand your revenue streams.</p>
                    </div>
                    <a href="{{ route('income.create') }}" class="btn btn-primary add-list">
                        <i class="las la-plus mr-3"></i>Add Income
                    </a>
                </div>
            </div>
            
            <!-- Summary Card -->
            <div class="col-lg-12">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white mb-0">Total Income</h6>
                                <h2 class="mb-0 text-white">{{ format_currency($totalIncome) }}</h2>
                            </div>
                            <div class="bg-white rounded p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign text-success">
                                    <line x1="12" y1="1" x2="12" y2="23"></line>
                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                </svg>
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
                                <th>Category</th>
                                <th>Amount</th>
                                <th>Description</th>
                                <th>Reference</th>
                                <th>Recorded By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="ligth-body">
                            @foreach($income as $transaction)
                            <tr>
                                <td>{{ $transaction->date->format('d M Y') }}</td>
                                <td>{{ $transaction->account->name }}</td>
                                <td>{{ $transaction->category ?? 'N/A' }}</td>
                                <td>{{ format_currency($transaction->amount) }}</td>
                                <td>{{ Str::limit($transaction->description, 20) ?? 'N/A' }}</td>
                                <td>{{ $transaction->reference ?? 'N/A' }}</td>
                                <td>{{ $transaction->user->name }}</td>
                                <td>
                                    <div class="d-flex align-items-center list-action">
                                        <a class="badge badge-info mr-2" href="{{ route('transactions.edit', $transaction->id) }}" title="Edit">
                                            <i class="ri-edit-line"></i>
                                        </a>
                                        <form method="POST" action="{{ route('transactions.destroy', $transaction->id) }}" onsubmit="return confirm('Are you sure you want to delete this transaction?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="badge badge-danger border-0" title="Delete">
                                                <i class="ri-delete-bin-line"></i>
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
