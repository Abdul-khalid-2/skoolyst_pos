<div class="modal fade" id="invoiceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Invoice #{{ $sale->invoice_number }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Vertical Receipt Container -->
                <div class="receipt-container" style="width: 300px; margin: 0 auto; font-family: Arial, sans-serif; padding: 10px; font-size: 14px; line-height: 1.4;">
                    <!-- Business Header -->
                    <div style="text-align: center; margin-bottom: 10px; border-bottom: 1px dashed #ccc; padding-bottom: 10px;">
                        @if($business->logo_path)
                        <img src="{{ asset('backend/'.$business->logo_path) }}" alt="Logo" style="max-height: 50px; margin-bottom: 5px;">
                        @endif
                        <h3 style="margin: 5px 0; font-size: 16px;">{{ $business->name }}</h3>
                        <p style="margin: 3px 0; font-size: 12px;">{{ $business->address }}</p>
                        <p style="margin: 3px 0; font-size: 12px;">Tel: {{ $business->phone }}</p>
                    </div>

                    <!-- Receipt Info -->
                    <div style="margin-bottom: 10px; border-bottom: 1px dashed #ccc; padding-bottom: 10px;">
                        <div style="display: flex; justify-content: space-between;">
                            <span><strong>Date:</strong></span>
                            <span>{{ $sale->sale_date->format('d/m/Y H:i') }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span><strong>Invoice #:</strong></span>
                            <span>{{ $sale->invoice_number }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span><strong>Cashier:</strong></span>
                            <span>{{ $sale->user->name }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span><strong>Branch:</strong></span>
                            <span>{{ $sale->branch->name }}</span>
                        </div>
                    </div>

                    <!-- Customer Info -->
                    <div style="margin-bottom: 10px; border-bottom: 1px dashed #ccc; padding-bottom: 10px;">
                        <p style="margin: 5px 0;"><strong>CUSTOMER:</strong></p>
                        @if($sale->customer)
                        <p style="margin: 3px 0;">{{ $sale->customer->name }}</p>
                        @if($sale->customer->phone)
                        <p style="margin: 3px 0;">Tel: {{ $sale->customer->phone }}</p>
                        @endif
                        @elseif($sale->walk_in_customer_info)
                        <p style="margin: 3px 0;">{{ $sale->walk_in_customer_info['name'] ?? 'Walk-in Customer' }}</p>
                        @if(isset($sale->walk_in_customer_info['phone']))
                        <p style="margin: 3px 0;">Tel: {{ $sale->walk_in_customer_info['phone'] }}</p>
                        @endif
                        @else
                        <p style="margin: 3px 0;">Walk-in Customer</p>
                        @endif
                    </div>

                    <!-- Items List -->
                    <div style="margin-bottom: 10px; border-bottom: 1px dashed #ccc;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th style="text-align: left; padding: 3px 0; border-bottom: 1px dashed #ccc;">Item</th>
                                    <th style="text-align: right; padding: 3px 0; border-bottom: 1px dashed #ccc;">Qty×Price</th>
                                    <th style="text-align: right; padding: 3px 0; border-bottom: 1px dashed #ccc;">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sale->items as $item)
                                <tr>
                                    <td style="text-align: left; padding: 3px 0; font-size: 13px;">
                                        {!! $item->variant ? $item->variant->name .'</br>'. $item->variant->sku : 'Default' !!}
                                    </td>
                                    <td style="text-align: right; padding: 3px 0; font-size: 13px;">
                                        {{ $item->quantity }}×{{ number_format($item->unit_price, 2) }}
                                    </td>
                                    <td style="text-align: right; padding: 3px 0; font-size: 13px;">
                                        {{ number_format($item->total_price, 2) }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Totals -->
                    <div style="margin-bottom: 10px;">
                        <div style="display: flex; justify-content: space-between;">
                            <span>Subtotal:</span>
                            <span>{{ number_format($sale->subtotal, 2) }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span>Tax:</span>
                            <span>{{ number_format($sale->tax_amount, 2) }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span>Discount:</span>
                            <span>-{{ number_format($sale->discount_amount, 2) }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-weight: bold; border-top: 1px dashed #ccc; margin-top: 5px; padding-top: 5px;">
                            <span>TOTAL:</span>
                            <span>{{ number_format($sale->total_amount, 2) }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span>Amount Paid:</span>
                            <span>{{ number_format($sale->amount_paid, 2) }}</span>
                        </div>
                        @if($sale->change_amount > 0)
                        <div style="display: flex; justify-content: space-between;">
                            <span>Change:</span>
                            <span>{{ number_format($sale->change_amount, 2) }}</span>
                        </div>
                        @endif
                    </div>

                    <!-- Payment Method -->
                    <div style="margin-bottom: 10px; border-bottom: 1px dashed #ccc; padding-bottom: 10px;">
                        <p style="margin: 5px 0;"><strong>Payment Method:</strong></p>
                        <p style="margin: 3px 0;">
                            {{ $sale->payments->first()->paymentMethod->name ?? 'N/A' }}
                            @if($sale->payments->first()->reference ?? false)
                            (Ref: {{ $sale->payments->first()->reference }})
                            @endif
                        </p>
                    </div>

                    <!-- Footer -->
                    <div style="text-align: center; font-size: 12px;">
                        <p style="margin: 5px 0;">Thank you for your purchase!</p>
                        @if($business->receipt_footer)
                        <img src="{{ asset('backend/'.$business->receipt_footer) }}" alt="Footer" style="max-width: 100%;">
                        @else
                        <p style="font-family: 'Jameel Noori Nastaleeq', 'Noto Nastaliq Urdu', serif; direction: rtl; margin: 5px 0;">
                            نوٹ: خریدا ہوا مال واپس اور تبدیل ہوتا ہے، بشرطیکہ خراب نہ ہو۔
                        </p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="printReceipt">
                    <i class="las la-print"></i> Print Receipt
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('printReceipt').addEventListener('click', function() {
        // Get the receipt container HTML
        const receiptHTML = document.querySelector('.receipt-container').outerHTML;

        // Create a print-specific stylesheet
        const printStyle = document.createElement('style');
        printStyle.id = 'temp-print-style';
        printStyle.innerHTML = `
            @media print {
                body * {
                    visibility: hidden;
                }
                .print-only-receipt, 
                .print-only-receipt * {
                    visibility: visible !important;
                }
                .print-only-receipt {
                    position: absolute;
                    left: 0;
                    top: 0;
                    width: 300px !important;
                    margin: 0;
                    padding: 10px;
                    font-size: 14px !important;
                }
                @page {
                    size: auto;
                    margin: 0;
                }
            }
        `;

        // Create the content to print
        const printContent = document.createElement('div');
        printContent.className = 'print-only-receipt';
        printContent.innerHTML = receiptHTML;

        document.body.appendChild(printContent);
        document.head.appendChild(printStyle);

        // Trigger print and clean up
        setTimeout(function() {
            window.print();
            document.body.removeChild(printContent);
            document.head.removeChild(printStyle);
        }, 100);
    });
</script>