<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Customer Invoice - {{ $customer->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: rgb(50, 189, 234);
            --secondary-color: rgb(50, 189, 234);
            --success-color: #4cc9f0;
            --danger-color: #f72585;
            --light-color: #f8f9fa;
            --dark-color: #212529;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            background-color: #f5f7fa;
        }
        
        .invoice-container {
            max-width: 900px;
            margin: 30px auto;
            padding: 0;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .invoice-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .invoice-header h1 {
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .invoice-header p {
            margin-bottom: 0;
            opacity: 0.9;
        }
        
        .invoice-body {
            padding: 30px;
        }
        
        .company-info, .customer-info {
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        
        .company-info {
            background-color: #f8f9fa;
            border-left: 4px solid var(--primary-color);
        }
        
        .customer-info {
            background-color: #e9f7fe;
            border-left: 4px solid var(--success-color);
        }
        
        .info-title {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 15px;
            font-size: 1.1rem;
        }
        
        .summary-card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
            transition: transform 0.3s ease;
        }
        
        .summary-card:hover {
            transform: translateY(-3px);
        }
        
        .summary-card .card-header {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
            border-radius: 8px 8px 0 0 !important;
        }
        
        .summary-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        
        .summary-item:last-child {
            border-bottom: none;
        }
        
        .summary-label {
            font-weight: 500;
            color: #666;
        }
        
        .summary-value {
            font-weight: 600;
        }
        
        .transaction-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .transaction-table th {
            background-color: var(--primary-color);
            color: white;
            padding: 12px 15px;
            text-align: left;
        }
        
        .transaction-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
        }
        
        .transaction-table tr:last-child td {
            border-bottom: none;
        }
        
        .transaction-table tr:hover {
            background-color: #f8f9fa;
        }
        
        .badge {
            padding: 6px 10px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.8rem;
        }
        
        .total-row {
            font-weight: 700;
            background-color: #f8f9fa;
        }
        
        .notes-section {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-top: 30px;
        }
        
        .footer {
            text-align: center;
            padding: 20px;
            margin-top: 40px;
            color: #666;
            font-size: 0.9rem;
        }
        
        .signature-area {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px dashed #ccc;
        }
        
        .text-success {
            color: var(--success-color) !important;
        }
        
        .text-danger {
            color: var(--danger-color) !important;
        }
        
        .bg-success {
            background-color: var(--success-color) !important;
        }
        
        .bg-warning {
            background-color: #ffc107 !important;
        }
        
        .bg-danger {
            background-color: var(--danger-color) !important;
        }
        
        @media print {
            body {
                background: none;
            }
            
            .invoice-container {
                box-shadow: none;
                margin: 0;
                padding: 0;
            }
            
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid no-print">
        <div class="row">
            <div class="col-12 d-flex justify-content-between p-3">
                <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Customer
                </a>
                <div>
                    <button onclick="window.print()" class="btn btn-primary me-2">
                        <i class="fas fa-print me-2"></i>Print Invoice
                    </button>
                    <a href="{{ route('customers.invoice.download', $customer->id) }}" class="btn btn-success">
                        <i class="fas fa-file-pdf me-2"></i>Download PDF
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="invoice-container">
        <div class="invoice-header">
            <h1>CUSTOMER STATEMENT</h1>
            <p>Summary of all transactions with {{ $customer->name }}</p>
        </div>
        
        <div class="invoice-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="company-info">
                        <div class="info-title">
                            <i class="fas fa-building me-2"></i>Business Information
                        </div>
                        <div class="mb-2"><strong>{{ $business->name ?? 'Your Business Name' }}</strong></div>
                        <div class="mb-1">{{ $business->address ?? '123 Business Street' }}</div>
                        <div class="mb-1">
                            <i class="fas fa-phone me-2"></i>{{ $business->phone ?? '123-456-7890' }}
                        </div>
                        <div class="mb-1">
                            <i class="fas fa-envelope me-2"></i>{{ $business->email ?? 'business@example.com' }}
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="customer-info">
                        <div class="info-title">
                            <i class="fas fa-user me-2"></i>Customer Information
                        </div>
                        <div class="mb-2"><strong>{{ $customer->name }}</strong></div>
                        <div class="mb-1">{{ $customer->address ?? 'No address provided' }}</div>
                        <div class="mb-1">
                            <i class="fas fa-phone me-2"></i>{{ $customer->phone }}
                        </div>
                        <div class="mb-1">
                            <i class="fas fa-envelope me-2"></i>{{ $customer->email ?? 'N/A' }}
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="card summary-card">
                        <div class="card-header">
                            <i class="fas fa-id-card me-2"></i>Customer Details
                        </div>
                        <div class="card-body">
                            <div class="summary-item">
                                <span class="summary-label">Customer Since:</span>
                                <span class="summary-value">
                                    @if($sales->count() > 0)
                                        {{ $sales->last()->created_at->format('M d, Y') }}
                                    @else
                                        N/A
                                    @endif
                                </span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Customer Group:</span>
                                <span class="summary-value">
                                    <span class="badge bg-primary">{{ ucfirst($customer->customer_group) }}</span>
                                </span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Credit Limit:</span>
                                <span class="summary-value">{{ number_format($customer->credit_limit, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card summary-card">
                        <div class="card-header">
                            <i class="fas fa-chart-line me-2"></i>Purchase Summary
                        </div>
                        <div class="card-body">
                            <div class="summary-item">
                                <span class="summary-label">Total Orders:</span>
                                <span class="summary-value">{{ $sales->count() }}</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Total Purchases:</span>
                                <span class="summary-value">{{ number_format($totalSpent, 2) }}</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Total Payments:</span>
                                <span class="summary-value">{{ number_format($totalPaid, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card summary-card">
                        <div class="card-header">
                            <i class="fas fa-wallet me-2"></i>Balance Summary
                        </div>
                        <div class="card-body">
                            <div class="summary-item">
                                <span class="summary-label">Current Balance:</span>
                                <span class="summary-value {{ $customer->balance >= 0 ? 'text-success' : 'text-danger' }}">
                                    {{ number_format($customer->balance, 2) }}
                                </span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Total Dues Banance:</span>
                                <span class="summary-value {{ $totalDues >= 0 ? 'text-danger' : 'text-success' }}">
                                    {{ number_format($totalDues, 2) }}
                                </span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Last Order:</span>
                                <span class="summary-value">
                                    @if($sales->count() > 0)
                                        {{ $sales->first()->created_at->format('M d, Y') }}
                                    @else
                                        N/A
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <h4 class="mt-5 mb-3">
                <i class="fas fa-file-invoice me-2"></i>Transaction History
            </h4>
            
            <div class="table-responsive">
                <table class="transaction-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Invoice #</th>
                            <th>Amount</th>
                            <th>Paid</th>
                            <th>Balance</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sales as $sale)
                            <tr>
                                <td>{{ $sale->created_at->format('M d, Y') }}</td>
                                <td>{{ $sale->invoice_number }}</td>
                                <td>{{ number_format($sale->total_amount, 2) }}</td>
                                <td>{{ number_format($sale->amount_paid, 2) }}</td>
                                <td>{{ number_format($sale->total_amount - $sale->amount_paid, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $sale->status == 'completed' ? 'success' : ($sale->status == 'pending' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($sale->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                        @if($sales->count() == 0)
                            <tr>
                                <td colspan="6" class="text-center py-4">No transactions found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            
            <div class="notes-section">
                <h5><i class="fas fa-info-circle me-2"></i>Important Notes</h5>
                <ul class="mb-0">
                    <li>This statement reflects all transactions with {{ $customer->name }} as of {{ now()->format('F j, Y') }}.</li>
                    <li>Please make payments to clear outstanding balances by the due date.</li>
                    <li>For any discrepancies, please contact our accounts department within 7 days.</li>
                    <li>Late payments may be subject to interest charges as per our terms.</li>
                </ul>
            </div>
            
            <div class="signature-area">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-1">Customer Signature:</p>
                        <div style="height: 50px; border-bottom: 1px solid #ccc; width: 70%;"></div>
                    </div>
                    <div class="col-md-6 text-end">
                        <p class="mb-1">Authorized Signature:</p>
                        <div style="height: 50px; border-bottom: 1px solid #ccc; width: 70%; margin-left: auto;"></div>
                        <p class="mt-2 mb-0"><strong>{{ $business->name ?? 'Your Business Name' }}</strong></p>
                    </div>
                </div>
            </div>
            
            <div class="footer">
                <p class="mb-0">Thank you for your business!</p>
                <p class="mb-0">Generated on {{ now()->format('F j, Y \a\t h:i A') }}</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>