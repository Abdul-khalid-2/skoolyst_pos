<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    
        <style>
            @page {
                margin: 0px;
            }
            body {
                font-family: 'DejaVu Sans', sans-serif;
                margin: 0;
                padding: 0;
                color: #333;
            }
            .invoice-container {
                width: 100%;
                max-width: 800px;
                margin: 0 auto;
                padding: 20px;
                background: #fff;
            }
            .invoice-header {
                display: flex;
                justify-content: space-between;
                margin-bottom: 30px;
                border-bottom: 1px solid #eee;
                padding-bottom: 20px;
            }
            .invoice-logo {
                max-width: 150px;
                max-height: 80px;
            }
            .invoice-title {
                font-size: 24px;
                font-weight: bold;
                color: #333;
            }
            .invoice-address {
                text-align: right;
                font-size: 12px;
                color: #666;
            }
            .invoice-info {
                display: flex;
                justify-content: space-between;
                margin-bottom: 20px;
            }
            .invoice-info-left, .invoice-info-right {
                width: 48%;
            }
            .info-box {
                margin-bottom: 15px;
            }
            .info-label {
                font-weight: bold;
                margin-bottom: 5px;
            }
            .info-value {
                padding: 5px;
                border: 1px solid #eee;
                border-radius: 4px;
                background: #f9f9f9;
            }
            .invoice-table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 30px;
            }
            .invoice-table th {
                background: #f5f5f5;
                padding: 10px;
                text-align: left;
                border: 1px solid #ddd;
            }
            .invoice-table td {
                padding: 10px;
                border: 1px solid #ddd;
            }
            .invoice-totals {
                width: 100%;
                max-width: 300px;
                margin-left: auto;
                border-collapse: collapse;
            }
            .invoice-totals td {
                padding: 8px;
                border: 1px solid #ddd;
            }
            .invoice-totals td:first-child {
                font-weight: bold;
                background: #f5f5f5;
            }
            .invoice-footer {
                margin-top: 50px;
                padding-top: 20px;
                border-top: 1px solid #eee;
                font-size: 12px;
                color: #666;
                text-align: center;
            }
            .status-badge {
                padding: 5px 10px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: bold;
            }
            .badge-success {
                background: #d4edda;
                color: #155724;
            }
            .badge-danger {
                background: #f8d7da;
                color: #721c24;
            }
            .badge-warning {
                background: #fff3cd;
                color: #856404;
            }
            .text-right {
                text-align: right;
            }
        </style>
</head>
<body>
    
    <div class="invoice-container">
        <!-- Invoice Header -->
        <div class="invoice-header">
            <div>
                @if($business->logo_path)
                    <img src="{{ asset($business->logo_path) }}" alt="Company Logo" class="invoice-logo">
                @else
                    <h1 class="invoice-title">{{ $business->name }}</h1>
                @endif
                <div style="margin-top: 10px;">
                    <p>{{ $business->address }}</p>
                    <p>Phone: {{ $business->phone }} | Email: {{ $business->email }}</p>
                    @if($business->tax_number)
                        <p>Tax ID: {{ $business->tax_number }}</p>
                    @endif
                </div>
            </div>
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
                    <th>Tax</th>
                    <th>Discount</th>
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
                    <td>{{ number_format($item->tax_amount, 2) }}</td>
                    <td>{{ number_format($item->discount_amount, 2) }}</td>
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

        <!-- Invoice Footer -->
        <div class="invoice-footer">
            @if($business->receipt_footer)
                {!! nl2br(e($business->receipt_footer)) !!}
            @else
                <p>Thank you for your business!</p>
                <p>All sales are final. Returns accepted within 7 days with original receipt.</p>
                <p>{{ $business->name }} | {{ $business->address }} | {{ $business->phone }}</p>
            @endif
        </div>
    </div>

</body>
</html>

