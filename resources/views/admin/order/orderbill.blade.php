<!DOCTYPE html>
<html>
<head>
    <title>Order Bill - #{{ $order->order_number }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }
        .bill-container { max-width: 400px; margin: 0 auto; border: 1px solid #ddd; padding: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; }
        .info { margin-bottom: 20px; }
        .info div { margin-bottom: 5px; }
        .items { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .items th, .items td { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; }
        .total { text-align: right; font-weight: bold; margin-top: 10px; }
        .footer { text-align: center; margin-top: 30px; font-size: 12px; }
        @media print {
            .no-print { display: none; }
            body { padding: 0; }
        }
    </style>
</head>
<body>
    <div class="bill-container">
        <div class="header">
            {{-- <h2>{{ config('app.name') }}</h2> --}}
            <div>{{ $currentBranch->name ?? 'Main Branch' }}</div>
            <div>{{ $currentBranch->address ?? '' }}</div>
            <div>Tel: {{ $currentBranch->phone ?? '' }}</div>
        </div>

        <div class="info">
            <div>Order #: {{ $order->order_number }}</div>
            <div>Date: {{ $order->created_at->format('d/m/Y H:i') }}</div>
            <div>Customer: {{ $order->customer ? $order->customer->name : ($order->walk_in_customer_info['name'] ?? 'Walk-in Customer') }}</div>
            <div>Cashier: {{ $order->user->name }}</div>
        </div>

        <table class="items">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>
                        {{ $item->product->name }}
                        @if($item->variant)
                            ({{ $item->variant->name }})
                        @endif
                    </td>
                    <td>{{ $item->quantity }}</td>
                    <td>Rs {{ number_format($item->unit_price, 2) }}</td>
                    <td>Rs {{ number_format($item->total_price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total">
            <div>Subtotal: Rs {{ number_format($order->subtotal, 2) }}</div>
            <div>Tax: Rs {{ number_format($order->tax_amount, 2) }}</div>
            <div>Discount: Rs {{ number_format($order->discount_amount, 2) }}</div>
            <div>Total: Rs {{ number_format($order->total_amount, 2) }}</div>
        </div>

        <div class="footer">
            <div>Thank you for your business!</div>
            <div>{{ config('app.name') }}</div>
            <button class="no-print" onclick="window.print()">Print Bill</button>
            <button class="no-print" onclick="window.close()">Close</button>
        </div>
    </div>
</body>
</html>