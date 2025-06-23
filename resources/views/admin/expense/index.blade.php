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
                        <h4 class="mb-3">Expense List</h4>
                        <p class="mb-0">Track all business expenses to maintain accurate financial records and<br> 
                        better understand your spending patterns.</p>
                    </div>
                    <div>
                    <a href="{{ route('expenses.categories') }}" class="btn btn-secondary add-list">
                        <i class="las la-plus mr-3"></i>Expense Categoryes
                    </a>
                    <a href="{{ route('expenses.create') }}" class="btn btn-primary add-list">
                        <i class="las la-plus mr-3"></i>Add Expense
                    </a>
                    </div>
                   
                </div>
            </div>
            
            <!-- Summary Card -->
            <div class="col-lg-12">
                <div class="card bg-danger text-white mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white mb-0">Total Expenses</h6>
                                <h2 class="mb-0 text-white">{{ format_currency($totalExpenses) }}</h2>
                            </div>
                            <div class="bg-white rounded p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card text-danger">
                                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                    <line x1="1" y1="10" x2="23" y2="10"></line>
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
                                <th>Branch</th>
                                <th>Amount</th>
                                <th>Description</th>
                                <th>Reference</th>
                                <th>Recorded By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="ligth-body">
                            @foreach($expenses as $expense)
                            <tr>
                                <td>{{ $expense->date->format('d M Y') }}</td>
                                <td>{{ $expense->account->name }}</td>
                                <td>{{ $expense->category->name }}</td>
                                <td>{{ $expense->branch->name }}</td>
                                <td>{{ format_currency($expense->amount) }}</td>
                                <td>{{ Str::limit($expense->description, 20) ?? 'N/A' }}</td>
                                <td>{{ $expense->reference ?? 'N/A' }}</td>
                                <td>{{ $expense->user->name }}</td>
                                <td>
                                    <div class="d-flex align-items-center list-action">
                                        <a class="badge badge-info mr-2" data-toggle="tooltip"
                                            data-placement="top" title="View" 
                                            href="{{ route('expenses.show', $expense->id) }}">
                                            <i class="ri-eye-line mr-0"></i>
                                        </a>
                                        <a class="badge bg-success mr-2" data-toggle="tooltip"
                                            data-placement="top" title="Edit" 
                                            href="{{ route('expenses.edit', $expense->id) }}">
                                            <i class="ri-pencil-line mr-0"></i>
                                        </a>
                                        <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="badge bg-warning mr-2 border-0" data-toggle="tooltip"
                                                data-placement="top" title="Delete" 
                                                onclick="return confirm('Are you sure you want to delete this expense?')">
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