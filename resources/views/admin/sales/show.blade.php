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