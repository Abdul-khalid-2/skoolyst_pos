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
                        <h4 class="mb-3">Income Details</h4>
                        <p class="mb-0">View detailed information about this income transaction</p>
                    </div>
                    <a href="{{ route('accounting.income.index') }}" class="btn btn-primary add-list">
                        <i class="las la-arrow-left mr-3"></i>Back to Income
                    </a>
                </div>
            </div>
            
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <div class="header-title">
                            <h4 class="card-title">Income Information</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date</label>
                                    <p class="form-control-static">{{ $income->date->format('d M Y') }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Account</label>
                                    <p class="form-control-static">{{ $income->account->name }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Amount</label>
                                    <p class="form-control-static">{{ format_currency($income->amount) }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Category</label>
                                    <p class="form-control-static">{{ $income->category }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Reference</label>
                                    <p class="form-control-static">{{ $income->reference ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <p class="form-control-static">{{ $income->description ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Recorded By</label>
                                    <p class="form-control-static">{{ $income->user->name }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Recorded At</label>
                                    <p class="form-control-static">{{ $income->created_at->format('d M Y H:i') }}</p>
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
                            <span class="font-weight-bold">{{ $income->account->name }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Account Type:</span>
                            <span>{{ $income->account->type }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Account Number:</span>
                            <span>{{ $income->account->account_number ?? 'N/A' }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Currency:</span>
                            <span>{{ $income->account->currency }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Current Balance:</span>
                            <span class="font-weight-bold">{{ format_currency($income->account->current_balance) }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-body text-center">
                        <a href="{{ route('accounting.income.edit', $income->id) }}" class="btn btn-primary btn-block mb-3">
                            <i class="ri-pencil-line mr-2"></i> Edit Income
                        </a>
                        <form action="{{ route('accounting.income.destroy', $income->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-block" onclick="return confirm('Are you sure you want to delete this income record?')">
                                <i class="ri-delete-bin-line mr-2"></i> Delete Income
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

    <!-- app JavaScript -->
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>
    @endpush
</x-app-layout>