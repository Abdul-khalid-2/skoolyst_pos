<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $sale->invoice_number }}</title>
    <style>
        @page {
            margin: 0.5cm;
            size: A4 portrait;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            line-height: 1.4;
            font-size: 12px;
        }
        .invoice-container {
            width: 100%;
            max-width: 710px;
            margin: 0 auto;
            padding: 15px;
            background: #fff;
            box-sizing: border-box;
        }
        .invoice-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 2px solid #ccc;
        }
        .header-left {
            display: flex;
            align-items: center;
            flex: 1;
        }
        .invoice-logo {
            width: 80px;
            height: auto;
            margin-right: 15px;
        }
        .business-info {
            font-family: Georgia, serif;
        }
        .business-name {
            margin: 0;
            font-size: 24px;
            color: #2e3e5c;
        }
        .business-tagline {
            margin: 3px 0;
            font-style: italic;
            font-weight: bold;
            color: #9a5700;
            font-size: 13px;
        }
        .business-contact {
            margin: 2px 0;
            font-size: 11px;
            color: #444;
        }
        .header-right {
            text-align: left;
            color: #444;
            margin-left: 10px;
        }
        .person-label {
            margin: 3px 0;
            font-size: 13px;
            color: #2e3e5c;
            font-weight: bold;
        }
        .person-name {
            margin: 3px 0;
            font-size: 12px;
            color: #ff8717;
        }
        .person-contact {
            margin: 3px 0;
            font-size: 11px;
            color: #2e3e5c;
        }
        .invoice-title-section {
            margin-bottom: 15px;
        }
        .invoice-title {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin: 0 0 8px 0;
        }
        .invoice-meta {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
        }
        .status-badge {
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            display: inline-block;
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
        .invoice-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        .info-label {
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 12px;
        }
        .info-value {
            padding: 8px;
            border: 1px solid #eee;
            border-radius: 4px;
            background: #f9f9f9;
            font-size: 11px;
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 11px;
            table-layout: fixed;
        }
        .invoice-table th {
            background: #f5f5f5;
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
            font-size: 11px;
        }
        .invoice-table td {
            padding: 8px;
            border: 1px solid #ddd;
            word-wrap: break-word;
        }
        .invoice-totals {
            width: 30%;
            max-width: 280px;
            margin-left: auto;
            margin-right: 0;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 11px;
        }
        .invoice-totals td {
            padding: 6px;
            border: 1px solid #ddd;
        }
        .invoice-totals td:first-child {
            font-weight: bold;
            background: #f5f5f5;
        }
        .text-right {
            text-align: right;
        }
        .section-title {
            margin: 15px 0 8px 0;
            font-size: 14px;
        }
        .invoice-footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #ccc;
            font-size: 11px;
        }
        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }
        .urdu-note {
            font-family: 'Jameel Noori Nastaleeq', 'Noto Nastaliq Urdu', serif;
            direction: rtl;
            margin: 0;
            font-size: 14px;
            color: #1e2b5a;
            flex: 1;
        }
        .signature {
            text-align: right;
        }
        .signature-line {
            border-top: 1px solid #1e2b5a;
            width: 120px;
            margin-top: 3px;
        }
        .compact {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header Section -->
        @if ($business->receipt_header)
            <div>
                <img src="{{ public_path('backend/'.$business->receipt_header) }}" alt="Header" style="width: 100%; height: auto; max-height: 100px; object-fit: contain;">
            </div>
        @else
            <div class="invoice-header">
                <div class="header-left">
                    @if($business->logo_path)
                        <img src="{{ public_path('backend/'.$business->logo_path) }}" alt="Logo" class="invoice-logo">
                    @endif
                    <div class="business-info">
                        <h1 class="business-name">{{ $business->name }}<sup>®</sup></h1>
                        <p class="business-tagline">Spare Parts Dealer</p>
                        <p class="business-contact">{{ $business->address }}</p>
                        <p class="business-contact">Email: {{ $business->email }}</p>
                    </div>
                </div>
                <div class="header-right">
                    <p class="person-label">Proprietor:</p>
                    <p class="person-name">Muhammad Iqbal</p>
                    <p class="person-contact compact">0333-2460463</p>
                    <p class="person-contact compact">0343-0211701</p>
                    
                    <p class="person-label" style="margin-top: 5px;">Manager:</p>
                    <p class="person-name">Muhammad Dawood Khan</p>
                    <p class="person-contact">{{ $business->phone }}</p>
                </div>
            </div>
        @endif

        <!-- Invoice Title Section -->
        <div class="invoice-title-section">
            <h2 class="invoice-title">INVOICE</h2>
            <div class="invoice-meta">
                <div>
                    <p class="compact">Invoice #: {{ $sale->invoice_number }}</p>
                    <p class="compact">Date: {{ $sale->sale_date->format('M d, Y') }}</p>
                </div>
                <div>
                    <p class="compact">Status: 
                        <span class="status-badge badge-{{ $sale->status == 'completed' ? 'success' : 'danger' }}">
                            {{ ucfirst($sale->status) }}
                        </span>
                    </p>
                    <p class="compact">Payment: 
                        <span class="status-badge badge-{{ $sale->payment_status == 'paid' ? 'success' : ($sale->payment_status == 'partial' ? 'warning' : 'danger') }}">
                            {{ ucfirst($sale->payment_status) }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Customer Info Section -->
        <div class="invoice-info">
            <table width="100%" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="48%" valign="top">
                        <div>
                            <div class="info-label">BILL TO</div>
                            <div class="info-value">
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
                                <br>
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
                    </td>
                    <td width="4%"></td> <!-- Spacer column -->
                    <td width="48%" valign="top">
                        <div>
                            <div class="info-label">SOLD BY</div>
                            <div class="info-value">
                                <strong>{{ $sale->user->name }}</strong><br>
                                {{ $sale->branch->name }}<br>
                                {{ $sale->branch->address }}
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Items Table -->
        <table class="invoice-table">
            <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 35%;">Product</th>
                    <th style="width: 20%;">Variant</th>
                    <th style="width: 10%;">Qty</th>
                    <th style="width: 15%;">Unit Price</th>
                    <th style="width: 15%;" class="text-right">Total</th>
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
                    <td class="text-right">{{ number_format($item->total_price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals Section -->
        <table class="invoice-totals">
            <tr>
                <td>Subtotal:</td>
                <td class="text-right">{{ number_format($sale->subtotal, 2) }}</td>
            </tr>
            @if($sale->tax_amount > 0)
            <tr>
                <td>Tax:</td>
                <td class="text-right">{{ number_format($sale->tax_amount, 2) }}</td>
            </tr>
            @endif
            @if($sale->discount_amount > 0)
            <tr>
                <td>Discount:</td>
                <td class="text-right">-{{ number_format($sale->discount_amount, 2) }}</td>
            </tr>
            @endif
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

        <!-- Payment History (only if exists) -->
        @if($sale->payments->count() > 0)
        <h3 class="section-title">Payment History</h3>
        <table class="invoice-table">
            <thead>
                <tr>
                    <th style="width: 25%;">Date</th>
                    <th style="width: 25%;">Method</th>
                    <th style="width: 25%;">Amount</th>
                    <th style="width: 25%;">Reference</th>
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

        <!-- Notes (only if exists) -->
        @if($sale->notes)
        <h3 class="section-title">Notes</h3>
        <p style="font-size: 11px; margin: 5px 0 10px 0;">{{ $sale->notes }}</p>
        @endif

        <!-- Footer -->
        <div class="invoice-footer">
            @if ($business->receipt_footer)
                <img src="{{ public_path('backend/'.$business->receipt_footer) }}" alt="Footer" style="width: 100%; height: auto; max-height: 80px; object-fit: contain;">
            @else
                <div class="footer-content">
                    <p class="urdu-note">
                        نوٹ: خریدا ہوا مال واپس اور تبدیل ہوتا ہے، بشرطیکہ خراب نہ ہو۔
                    </p>
                    <div class="signature">
                        <p style="margin: 0; color: #d2691e; font-size: 12px;"><strong>On Behalf of</strong><br>
                        <span style="font-size: 14px;">M.D. Autos</span></p>
                        <div class="signature-line"></div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</body>
</html>