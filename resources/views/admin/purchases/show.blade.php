<x-app-layout>
    @push('css')
    <link rel="stylesheet" href="{{ asset('Backend/assets/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Backend/assets/css/backend.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('Backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Backend/assets/vendor/remixicon/fonts/remixicon.css')}}">
    @endpush

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex flex-wrap justify-content-between mb-4">
                    <div>
                        <h4 class="mb-3">Purchase Order #{{ $purchase->invoice_number }}</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('purchases.index') }}">Purchases</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Details</li>
                            </ol>
                        </nav>
                    </div>
                    <div>
                        <a href="{{ route('purchases.edit', $purchase->id) }}" class="btn btn-primary mr-2">
                            <i class="las la-edit mr-2"></i>Edit
                        </a>
                        <a href="{{ route('purchases.index') }}" class="btn btn-light">
                            <i class="las la-arrow-left mr-2"></i>Back
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Purchase Details -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title">Purchase Information</h5>
                        <span class="badge badge-{{ $purchase->status == 'received' ? 'success' : ($purchase->status == 'cancelled' ? 'danger' : 'warning') }}">
                            {{ ucfirst($purchase->status) }}
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Supplier:</strong> {{ $purchase->supplier->name }}</p>
                                <p><strong>Branch:</strong> {{ $purchase->branch->name }}</p>
                                <p><strong>Purchase Date:</strong> {{ $purchase->purchase_date->format('M d, Y') }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Expected Delivery:</strong> 
                                    {{ $purchase->expected_delivery_date ? $purchase->expected_delivery_date->format('M d, Y') : 'Not specified' }}
                                </p>
                                <p><strong>Created By:</strong> {{ $purchase->user->name ?? 'System' }}</p>
                                <p><strong>Last Updated:</strong> {{ $purchase->updated_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Items Table -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title">Purchase Items</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Variant</th>
                                        <th>Ordered</th>
                                        <th>Received</th>
                                        <th>Unit Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($purchase->items as $item)
                                    <tr>
                                        <td>{{ $item->product->name }}</td>
                                        <td>{{ $item->variant ? $item->variant->name : 'Default' }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->quantity_received }}</td>
                                        <td>{{ number_format($item->unit_price, 2) }}</td>
                                        <td>{{ number_format($item->total_price, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Receive Items Form -->
                @if($purchase->status != 'received' && $purchase->status != 'cancelled')
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title">Receive Items</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('purchases.receive-items', $purchase->id) }}" method="POST">
                            @csrf
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Ordered</th>
                                            <th>Previously Received</th>
                                            <th>Receive Now</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($purchase->items as $item)
                                        <tr>
                                            <td>{{ $item->product->name }} ({{ $item->variant ? $item->variant->name : 'Default' }})</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ $item->quantity_received }}</td>
                                            <td>
                                                <input type="hidden" name="items[{{ $loop->index }}][id]" value="{{ $item->id }}">
                                                <input type="number" name="items[{{ $loop->index }}][quantity_received]" 
                                                    class="form-control" min="0" max="{{ $item->quantity - $item->quantity_received }}" 
                                                    value="{{ $item->quantity - $item->quantity_received }}">
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Received Items</button>
                        </form>
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
                            <p><strong>Subtotal:</strong> {{ number_format($purchase->subtotal, 2) }}</p>
                            <p><strong>Shipping:</strong> {{ number_format($purchase->shipping_amount, 2) }}</p>
                            <p><strong>Tax:</strong> {{ number_format($purchase->tax_amount, 2) }}</p>
                            <p><strong>Discount:</strong> -{{ number_format($purchase->discount_amount, 2) }}</p>
                            <hr>
                            <p class="font-weight-bold"><strong>Total Amount:</strong> {{ number_format($purchase->total_amount, 2) }}</p>
                            <p><strong>Amount Paid:</strong> {{ number_format($purchase->amount_paid, 2) }}</p>
                            <p class="font-weight-bold"><strong>Balance Due:</strong> {{ number_format($purchase->remaining_balance, 2) }}</p>
                        </div>
                        
                        @if($purchase->remaining_balance > 0 && $purchase->status != 'cancelled')
                        <div class="mt-4">
                            <h6>Add Payment</h6>
                            <form action="{{ route('purchases.add-payment', $purchase->id) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label>Payment Method</label>
                                    <select name="payment_method_id" class="form-control" required>
                                        <option value="">Select Method</option>
                                        @foreach($paymentMethods as $method)
                                            <option value="{{ $method->id }}">{{ $method->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Amount</label>
                                    <input type="number" name="amount" class="form-control" 
                                        min="0.01" max="{{ $purchase->remaining_balance }}" 
                                        step="0.01" value="{{ $purchase->remaining_balance }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Reference</label>
                                    <input type="text" name="reference" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Date</label>
                                    <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Notes</label>
                                    <textarea name="notes" class="form-control" rows="2"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Record Payment</button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Payment History -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title">Payment History</h5>
                    </div>
                    <div class="card-body">
                        @if($purchase->payments->isEmpty())
                            <p>No payments recorded yet.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Method</th>
                                            <th>Amount</th>
                                            <th>Reference</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($purchase->payments as $payment)
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
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
    <!-- Backend Bundle JavaScript -->
    <script src="{{ asset('Backend/assets/js/backend-bundle.min.js') }}"></script>

    <!-- Table Treeview JavaScript -->
    <script src="{{ asset('Backend/assets/js/table-treeview.js') }}"></script>

    <!-- Chart Custom JavaScript -->
    <script src="{{ asset('Backend/assets/js/customizer.js') }}"></script>

    <!-- Chart Custom JavaScript -->
    <script async src="{{ asset('Backend/assets/js/chart-custom.js') }}"></script>

    <!-- app JavaScript -->
    <script src="{{ asset('Backend/assets/js/app.js') }}"></script>
    @endpush
</x-app-layout>