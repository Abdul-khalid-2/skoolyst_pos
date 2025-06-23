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
                <div class="d-flex flex-wrap justify-content-between mb-4">
                    <div>
                        <h4 class="mb-3">Sale #{{ $sale->invoice_number }}</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('sales.index') }}">Sales</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Details</li>
                            </ol>
                        </nav>
                    </div>
                    <div>
                        <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-primary mr-2">
                            <i class="las la-edit mr-2"></i>Edit
                        </a>
                        <a href="{{ route('sales.index') }}" class="btn btn-light">
                            <i class="las la-arrow-left mr-2"></i>Back
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Sale Details -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title">Sale Information</h5>
                        <div>
                            <span class="badge badge-{{ $sale->status == 'completed' ? 'success' : 'danger' }} mr-2">
                                {{ ucfirst($sale->status) }}
                            </span>
                            <span class="badge badge-{{ $sale->payment_status == 'paid' ? 'success' : ($sale->payment_status == 'partial' ? 'warning' : 'danger') }}">
                                {{ ucfirst($sale->payment_status) }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p>
                                    <strong>Customer:</strong> 
                                    @if($sale->customer)
                                        {{ $sale->customer->name }}
                                    @elseif($sale->walk_in_customer_info && isset($sale->walk_in_customer_info['name']))
                                        {{ $sale->walk_in_customer_info['name'] }} 
                                        @if(isset($sale->walk_in_customer_info['phone']))
                                            ({{ $sale->walk_in_customer_info['phone'] }})
                                        @endif
                                    @else
                                        Walk-in Customer
                                    @endif
                                </p>
                                <p><strong>Branch:</strong> {{ $sale->branch->name }}</p>
                                <p><strong>Sales Person:</strong> {{ $sale->user->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Date:</strong> {{ $sale->sale_date->format('M d, Y H:i') }}</p>
                                <p><strong>Invoice #:</strong> {{ $sale->invoice_number }}</p>
                                @if($sale->walk_in_customer_info && isset($sale->walk_in_customer_info['phone']))
                                    <p><strong>Customer Phone:</strong> {{ $sale->walk_in_customer_info['phone'] }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Items Table -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title">Sale Items</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Variant</th>
                                        <th>Qty</th>
                                        <th>Unit Price</th>
                                        {{-- 
                                        <th>Tax</th>
                                        <th>Discount</th> 
                                        --}}
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sale->items as $item)
                                    <tr>
                                        <td>{{ $item->product->name }}</td>
                                        <td>{{ $item->variant ? $item->variant->name : 'Default' }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ number_format($item->unit_price, 2) }}</td>
                                        {{-- 
                                            <td>{{ number_format($item->tax_amount, 2) }}</td>
                                            <td>{{ number_format($item->discount_amount, 2) }}</td> 
                                        --}}
                                        <td>{{ number_format($item->total_price, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Notes -->
                @if($sale->notes)
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title">Notes</h5>
                    </div>
                    <div class="card-body">
                        <p>{{ $sale->notes }}</p>
                    </div>
                </div>
                @endif
            </div>
            
            <!-- Payment Summary -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Payment Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <p><strong>Subtotal:</strong> {{ number_format($sale->subtotal, 2) }}</p>
                            <p><strong>Tax:</strong> {{ number_format($sale->tax_amount, 2) }}</p>
                            <p><strong>Discount:</strong> -{{ number_format($sale->discount_amount, 2) }}</p>
                            <hr>
                            <p class="font-weight-bold"><strong>Total Amount:</strong> {{ number_format($sale->total_amount, 2) }}</p>
                            <p><strong>Amount Paid:</strong> {{ number_format($sale->amount_paid, 2) }}</p>
                            <p><strong>Change Due:</strong> {{ number_format($sale->change_amount, 2) }}</p>
                            <p><strong>Balance Due:</strong> {{ number_format($sale->remaining_balance, 2) }}</p>
                        </div>
                        
                        <!-- Payment History -->
                        <h5 class="mb-3">Payment History</h5>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Method</th>
                                        <th>Amount</th>
                                        <th>Ref</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sale->payments as $payment)
                                    <tr>
                                        <td>{{ $payment->created_at->format('M d, Y') }}</td>
                                        <td>{{ $payment->paymentMethod->name }}</td>
                                        <td>{{ number_format($payment->amount, 2) }}</td>
                                        <td>{{ $payment->reference ?? '-' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Add Payment Form -->
                        @if($sale->remaining_balance > 0)
                        <div class="mt-4">
                            <h5 class="mb-3">Add Payment</h5>
                            <form action="{{ route('sales.add-payment', $sale->id) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label>Payment Method *</label>
                                    <select name="payment_method_id" class="form-control" required>
                                        <option value="">Select Method</option>
                                        @foreach($paymentMethods as $method)
                                            <option value="{{ $method->id }}">{{ $method->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Amount *</label>
                                    <input type="number" step="0.01" name="amount" class="form-control" 
                                        min="0.01" max="{{ $sale->remaining_balance }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Reference</label>
                                    <input type="text" name="reference" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Date</label>
                                    <input type="date" name="date" class="form-control" 
                                        value="{{ date('Y-m-d') }}">
                                </div>
                                <button type="submit" class="btn btn-primary">Record Payment</button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Print/Download Options -->
                <div class="card mt-4">
                    <div class="card-body text-center">
                        <a href="{{ route('sales.invoice', $sale->id) }}" target="_blank" class="btn btn-outline-primary mr-2">
                            <i class="las la-print mr-2"></i>Print Invoice
                        </a>
                        <a href="{{ route('sales.invoice-pdf', $sale->id) }}" class="btn btn-outline-secondary">
                            <i class="las la-download mr-2"></i>Download PDF
                        </a>
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