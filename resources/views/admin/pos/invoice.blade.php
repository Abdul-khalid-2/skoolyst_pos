<div class="modal fade" id="invoiceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="width: 60%;">
            <div class="modal-header">
                <h5 class="modal-title">Invoice #{{ $sale->invoice_number }}</h5>
                <div class="btn btn-primary" data-dismiss="modal" aria-label="Close">x</div>
            </div>
            <div class="modal-body">
                <div class="invoice-container" style="font-family: Arial, sans-serif; color: #333;">
                    <!-- Business Header -->
                    <div
                        style="display: grid; justify-content: space-between; border-bottom: 2px solid #eee; padding-bottom: 15px; margin-bottom: 15px;">
                        <div>
                            @if($business->logo_path)
                            <img src="{{ asset('backend/'.$business->logo_path) }}" alt="Logo"
                                style="max-height: 80px; margin-bottom: 10px;">
                            @endif
                            <h2 style="margin: 0; color: #2e3e5c;">{{ $business->name }}</h2>
                            <p style="margin: 5px 0 0; font-size: 14px; color: #555;">
                                {{ $business->address }}<br>
                                Phone: {{ $business->phone }} | Email: {{ $business->email }}
                            </p>
                        </div>
                        <div style="text-align: left;">
                            <h3 style="margin: 0; color: #2e3e5c;">INVOICE</h3>
                            <p style="margin: 5px 0 0; font-size: 14px;">
                                <strong>Date:</strong> {{ $sale->sale_date->format('d/m/Y') }}<br>
                                <strong>Invoice #:</strong> {{ $sale->invoice_number }}<br>
                                <strong>Status:</strong>
                                <span style="color: {{ $sale->status == 'completed' ? 'green' : 'red' }}">
                                    {{ ucfirst($sale->status) }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <!-- Customer and Branch Info -->
                    <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                        <div style="flex: 1; padding-right: 15px;">
                            <h4 style="margin: 0 0 5px; color: #2e3e5c; font-size: 16px;">BILL TO:</h4>
                            <p style="margin: 0; font-size: 14px;">
                                @if($sale->customer)
                                <strong>{{ $sale->customer->name }}</strong><br>
                                {{ $sale->customer->address }}<br>
                                Phone: {{ $sale->customer->phone }}
                                @elseif($sale->walk_in_customer_info)
                                <strong>{{ $sale->walk_in_customer_info['name'] ?? 'Walk-in Customer' }}</strong><br>
                                @if(isset($sale->walk_in_customer_info['phone']))
                                Phone: {{ $sale->walk_in_customer_info['phone'] }}
                                @endif
                                @else
                                Walk-in Customer
                                @endif
                            </p>
                        </div>
                        <div style="flex: 1; padding-left: 15px;">
                            <h4 style="margin: 0 0 5px; color: #2e3e5c; font-size: 16px;">SOLD BY:</h4>
                            <p style="margin: 0; font-size: 14px;">
                                <strong>{{ $sale->user->name }}</strong><br>
                                {{ $sale->branch->name }}<br>
                                {{ $sale->branch->address }}
                            </p>
                        </div>
                    </div>

                    <!-- Items Table -->
                    <table style="width: 100%; border-collapse: collapse; margin-bottom: 15px;">
                        <thead>
                            <tr style="background-color: #f8f9fa;">
                                <th style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd;">Variant</th>
                                <th style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd;">Qty</th>
                                <th style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd;">Price</th>
                                <th style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sale->items as $index => $item)
                            <tr>
                                <td style="padding: 8px; text-align: left; border-bottom: 1px solid #eee;">
                                    {{ $item->variant ? $item->variant->name ."(". $item->variant->sku .")" : 'Default' }}
                                </td>
                                <td style="padding: 8px; text-align: left; border-bottom: 1px solid #eee;">
                                    {{ $item->quantity }}
                                </td>
                                <td style="padding: 8px; text-align: left; border-bottom: 1px solid #eee;">
                                    {{ number_format($item->unit_price, 2) }}
                                </td>
                                <td style="padding: 8px; text-align: left; border-bottom: 1px solid #eee;">
                                    {{ number_format($item->total_price, 2) }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Totals -->
                    <div style="display: flex; justify-content: flex-end;">
                        <table style="width: 300px;">
                            <tr>
                                <td style="padding: 5px; text-align: right;"><strong>Subtotal:</strong></td>
                                <td style="padding: 5px; text-align: right;">{{ number_format($sale->subtotal, 2) }}
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 5px; text-align: right;"><strong>Tax:</strong></td>
                                <td style="padding: 5px; text-align: right;">{{ number_format($sale->tax_amount, 2) }}
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 5px; text-align: right;"><strong>Discount:</strong></td>
                                <td style="padding: 5px; text-align: right;">
                                    -{{ number_format($sale->discount_amount, 2) }}</td>
                            </tr>
                            <tr style="border-top: 1px solid #ddd;">
                                <td style="padding: 5px; text-align: right;"><strong>Total Amount:</strong></td>
                                <td style="padding: 5px; text-align: right;">
                                    <strong>{{ number_format($sale->total_amount, 2) }}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 5px; text-align: right;"><strong>Amount Paid:</strong></td>
                                <td style="padding: 5px; text-align: right;">{{ number_format($sale->amount_paid, 2) }}
                                </td>
                            </tr>
                            @if($sale->change_amount > 0)
                            <tr>
                                <td style="padding: 5px; text-align: right;"><strong>Change Due:</strong></td>
                                <td style="padding: 5px; text-align: right;">
                                    {{ number_format($sale->change_amount, 2) }}
                                </td>
                            </tr>
                            @endif
                        </table>
                    </div>

                    <!-- Payment Method -->
                    <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #eee;">
                        <p style="margin: 0; font-size: 14px;">
                            <strong>Payment Method:</strong>
                            {{ $sale->payments->first()->paymentMethod->name ?? 'N/A' }}
                            @if($sale->payments->first()->reference ?? false)
                            (Ref: {{ $sale->payments->first()->reference }})
                            @endif
                        </p>
                    </div>

                    <!-- Footer -->
                    <div
                        style="margin-top: 20px; padding-top: 15px; border-top: 1px solid #eee; text-align: center; font-size: 13px;">
                        <p style="margin: 0;">Thank you for your business!</p>
                        @if($business->receipt_footer)
                        <img src="{{ asset('backend/'.$business->receipt_footer) }}" alt="Footer"
                            style="max-width: 100%; margin-top: 10px;">
                        @else
                        <p
                            style="font-family: 'Jameel Noori Nastaleeq', 'Noto Nastaliq Urdu', serif; direction: rtl; margin-top: 10px;">
                            نوٹ: خریدا ہوا مال واپس اور تبدیل ہوتا ہے، بشرطیکہ خراب نہ ہو۔
                        </p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">Close</button>
                <button type="button" class="btn btn-primary" id="printInvoice">
                    <i class="las la-print"></i> Print Invoice
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('printInvoice').addEventListener('click', function() {
        // Get the invoice container HTML
        const invoiceHTML = document.querySelector('.invoice-container').outerHTML;

        // Create a print-specific stylesheet
        const printStyle = document.createElement('style');
        printStyle.id = 'temp-print-style';
        printStyle.innerHTML = `
        @media print {
            body * {
                visibility: hidden;
            }
            .print-only-content, 
            .print-only-content * {
                visibility: visible !important;
            }
            .print-only-content {
                position: absolute;
                top: 0;
                left: 10%;
                transform: translateX(-10%);
                width: 500px !important;
                margin-top: 10px;
                padding: 0;
            }
            @page {
                width:30%;
            }
        }
    `;
        document.head.appendChild(printStyle);

        // Create the content to print
        const printContent = document.createElement('div');
        printContent.className = 'print-only-content';
        printContent.innerHTML = invoiceHTML;

        document.body.appendChild(printContent);

        // Trigger print and clean up
        setTimeout(function() {
            window.print();
            document.body.removeChild(printContent);
            document.head.removeChild(printStyle);
        }, 100);
    });
</script>