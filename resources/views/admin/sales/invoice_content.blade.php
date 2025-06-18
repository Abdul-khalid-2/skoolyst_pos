    <div class="invoice-container">
        <!-- Invoice Header -->


        <!-- Invoice Header -->

        @if ($business->receipt_header)
        
            <div style="font-family: Georgia, serif;"> 
                <img src="{{ public_path("backend/".$business->receipt_header) }}" alt="Logo" style="width: 100%; height: auto; margin-right: 20px;>
            </div>
        @else
            
            <div class="invoice-header" style="display: flex; align-items: center; justify-content: space-between; border-bottom: 2px solid #ccc; padding-bottom: 15px;">
                <div style="display: flex; align-items: center;">
                    @if($business->logo_path)
                        <img src="{{ public_path("backend/".$business->logo_path) }}" alt="Logo" style="width: 100px; height: auto; margin-right: 20px;">
                    @endif
                    <div style="font-family: Georgia, serif;">
                        <h1 style="margin: 0; font-size: 28px; color: #2e3e5c;">{{ $business->name }}<sup>®</sup></h1>
                        <p style="margin: 5px 0; font-style: italic; font-weight: bold; color: #9a5700;">Spare Parts Dealer</p>
                        <p style="margin: 0; font-size: 12px; color: #444;">{{ $business->address }}</p>
                        <p style="margin: 0; font-size: 12px; color: #444;">Email: {{ $business->email }}</p>
                    </div>
                </div>
                <div class="invoice-address" style="text-align: left; color: #444;">
                
                    <p><strong style="margin: 0; font-size: 15px; color: #2e3e5c;">Proprietor:</strong> <br><span style="margin: 0; font-size: 13px; color: #ff8717;">Muhammad Iqbal</span></p>
                    <p style="margin: 0; font-size: 12px; color: #2e3e5c;">0333-2460463 <br> 0343-0211701</p>
                    <p><strong style="margin: 0; font-size: 15px; color: #2e3e5c;">Manager:</strong> <br> <span style="margin: 0; font-size: 13px; color: #ff8717;">Muhammad Dawood Khan</span> </p>
                    <p style="margin: 0; font-size: 12px; color: #2e3e5c;">{{ $business->phone }}</p>
                </div>
            </div>
        @endif
        

        <div class="invoice-address">
                <h2 class="invoice-title">INVOICE</h2>
                <p>Invoice #: {{ $sale->invoice_number }}</p>
                <p>Date: {{ $sale->sale_date->format('M d, Y') }}</p>
                <p>Status: 
                    <span class="status-badge badge-{{ $sale->status == 'completed' ? 'success' : 'danger' }}">
                        {{ ucfirst($sale->status) }}
                    </span>
                </p>
                <p>Payment: 
                    <span class="status-badge badge-{{ $sale->payment_status == 'paid' ? 'success' : ($sale->payment_status == 'partial' ? 'warning' : 'danger') }}">
                        {{ ucfirst($sale->payment_status) }}
                    </span>
                </p>
            </div>

        <!-- Invoice Info -->
        <div class="invoice-info">
            <div class="invoice-info-left">
                <div class="info-box">
                    <div class="info-label">BILL TO</div>
                    <div class="info-value">
                        {{ $sale->customer ? $sale->customer->name : 'Walk-in Customer' }}<br>
                        @if($sale->customer && $sale->customer->address)
                            {{ $sale->customer->address }}<br>
                        @endif
                        @if($sale->customer && $sale->customer->phone)
                            Phone: {{ $sale->customer->phone }}<br>
                        @endif
                        @if($sale->customer && $sale->customer->tax_number)
                            Tax ID: {{ $sale->customer->tax_number }}
                        @endif
                    </div>
                </div>
            </div>
            <div class="invoice-info-right">
                <div class="info-box">
                    <div class="info-label">SOLD BY</div>
                    <div class="info-value">
                        {{ $sale->user->name }}<br>
                        {{ $sale->branch->name }}<br>
                        {{ $sale->branch->address }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <table class="invoice-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Variant</th>
                    <th>Qty</th>
                    <th>Unit Price</th>
                    {{-- <th>Tax</th>
                    <th>Discount</th> --}}
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sale->items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->variant ? $item->variant->name : 'Default' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->unit_price, 2) }}</td>
                    {{-- <td>{{ number_format($item->tax_amount, 2) }}</td>
                    <td>{{ number_format($item->discount_amount, 2) }}</td> --}}
                    <td class="text-right">{{ number_format($item->total_price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <table class="invoice-totals">
            <tr>
                <td>Subtotal:</td>
                <td class="text-right">{{ number_format($sale->subtotal, 2) }}</td>
            </tr>
            <tr>
                <td>Tax:</td>
                <td class="text-right">{{ number_format($sale->tax_amount, 2) }}</td>
            </tr>
            <tr>
                <td>Discount:</td>
                <td class="text-right">-{{ number_format($sale->discount_amount, 2) }}</td>
            </tr>
            <tr>
                <td><strong>Total Amount:</strong></td>
                <td class="text-right"><strong>{{ number_format($sale->total_amount, 2) }}</strong></td>
            </tr>
            <tr>
                <td>Amount Paid:</td>
                <td class="text-right">{{ number_format($sale->amount_paid, 2) }}</td>
            </tr>
            @if($sale->change_amount > 0)
            <tr>
                <td>Change Due:</td>
                <td class="text-right">{{ number_format($sale->change_amount, 2) }}</td>
            </tr>
            @endif
            @if($sale->remaining_balance > 0)
            <tr>
                <td>Balance Due:</td>
                <td class="text-right">{{ number_format($sale->remaining_balance, 2) }}</td>
            </tr>
            @endif
        </table>

        <!-- Payment History -->
        @if($sale->payments->count() > 0)
        <h3 style="margin-top: 30px; margin-bottom: 10px;">Payment History</h3>
        <table class="invoice-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Method</th>
                    <th>Amount</th>
                    <th>Reference</th>
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
        @endif

        <!-- Notes -->
        @if($sale->notes)
        <div style="margin-top: 20px;">
            <h3>Notes</h3>
            <p>{{ $sale->notes }}</p>
        </div>
        @endif


        <div class="invoice-footer" style="border-top: 1px solid #ccc; padding-top: 15px; margin-top: 20px; font-size: 13px;">
        @if ($business->receipt_footer)
            <div style="font-family: Georgia, serif;"> 
                <img src="{{ public_path("backend/".$business->receipt_footer) }}" alt="footer" style="width: 100%; height: auto; margin-right: 20px;">
            </div>
        @else
            
            {{-- <div class="invoice-footer" style="border-top: 1px solid #ccc; padding-top: 15px; margin-top: 20px; font-size: 13px;"> --}}
                <div style="display: flex; justify-content: space-between; align-items: flex-end;">
                    <!-- Urdu Note -->
                    <p style="font-family: 'Jameel Noori Nastaleeq', 'Noto Nastaliq Urdu', serif; direction: rtl; margin: 0; font-size: 16px; color: #1e2b5a;">
                        نوٹ: خریدا ہوا مال واپس اور تبدیل ہوتا ہے، بشرطیکہ خراب نہ ہو۔
                    </p>

                    <!-- Signature -->
                    <div style="text-align: right;display: flex; justify-content: space-between; align-items: flex-end;">
                        <p style="margin: 0; color: #d2691e;"><strong>On Behalf of</strong><br><span style="font-size: 16px;">M.D. Autos</span></p><br>
                        <div style="border-top: 1px solid #1e2b5a; width: 150px; margin-top: 10px;"></div>
                    </div>
                </div>
            {{-- </div> --}}
            @endif
        </div>
        <!-- Invoice Footer -->
        

    </div>