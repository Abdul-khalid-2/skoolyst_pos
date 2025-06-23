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
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Edit Purchase Order #{{ $purchase->invoice_number }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('purchases.update', $purchase->id) }}" method="POST" id="purchaseForm">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <!-- Branch Selection -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Branch *</label>
                                        <select name="branch_id" class="form-control" required>
                                            <option value="">Select Branch</option>
                                            @foreach($branches as $branch)
                                                <option value="{{ $branch->id }}" {{ $purchase->branch_id == $branch->id ? 'selected' : '' }}>
                                                    {{ $branch->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Supplier Selection -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Supplier *</label>
                                        <select name="supplier_id" class="form-control" required>
                                            <option value="">Select Supplier</option>
                                            @foreach($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}" {{ $purchase->supplier_id == $supplier->id ? 'selected' : '' }}>
                                                    {{ $supplier->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Invoice Number -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Invoice Number *</label>
                                        <input type="text" name="invoice_number" class="form-control" 
                                            value="{{ $purchase->invoice_number }}" required>
                                    </div>
                                </div>
                                
                                <!-- Status -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status *</label>
                                        <select name="status" class="form-control" required>
                                            <option value="ordered" {{ $purchase->status == 'ordered' ? 'selected' : '' }}>Ordered</option>
                                            <option value="partial" {{ $purchase->status == 'partial' ? 'selected' : '' }}>Partially Received</option>
                                            <option value="received" {{ $purchase->status == 'received' ? 'selected' : '' }}>Fully Received</option>
                                            <option value="cancelled" {{ $purchase->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Dates -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Purchase Date *</label>
                                        <input type="date" name="purchase_date" class="form-control" 
                                            value="{{ $purchase->purchase_date->format('Y-m-d') }}" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Expected Delivery Date</label>
                                        <input type="date" name="expected_delivery_date" class="form-control"
                                            value="{{ $purchase->expected_delivery_date ? $purchase->expected_delivery_date->format('Y-m-d') : '' }}">
                                    </div>
                                </div>
                                
                                <!-- Additional Costs -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Shipping Amount</label>
                                        <input type="number" step="0.01" name="shipping_amount" 
                                            class="form-control" min="0" value="{{ $purchase->shipping_amount }}">
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Tax Amount</label>
                                        <input type="number" step="0.01" name="tax_amount" 
                                            class="form-control" min="0" value="{{ $purchase->tax_amount }}">
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Discount Amount</label>
                                        <input type="number" step="0.01" name="discount_amount" 
                                            class="form-control" min="0" value="{{ $purchase->discount_amount }}">
                                    </div>
                                </div>
                                
                                <!-- Purchase Items Section -->
                                <div class="col-md-12">
                                    <h5>Purchase Items</h5>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Variant</th>
                                                    <th>Quantity</th>
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
                                                    <td>{{ number_format($item->unit_price, 2) }}</td>
                                                    <td>{{ number_format($item->total_price, 2) }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <p class="text-muted">Note: Items cannot be edited once created. Create a new purchase order for changes.</p>
                                </div>
                                
                                <!-- Notes -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Notes</label>
                                        <textarea name="notes" class="form-control" rows="3">{{ $purchase->notes }}</textarea>
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary mr-2">Update Purchase</button>
                                    <a href="{{ route('purchases.show', $purchase->id) }}" class="btn btn-light">Cancel</a>
                                </div>
                            </div>
                        </form>
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