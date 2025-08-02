<div class="col-md-4 mb-4">
    <div class="card order-card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="card-title mb-0">#{{ $order->order_number }}</h5>
                <span class="order-status status-{{ $order->status }}">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
            
            <div class="mb-2">
                <small class="text-muted">Customer:</small>
                <div>
                    {{ $order->customer ? $order->customer->name : ($order->walk_in_customer_info['name'] ?? 'Walk-in Customer') }}
                </div>
            </div>
            
            <div class="mb-2">
                <small class="text-muted">Items:</small>
                <div>{{ $order->items->sum('quantity') }}</div>
            </div>
            
            <div class="mb-3">
                <small class="text-muted">Total:</small>
                <div class="fw-bold">Rs {{ number_format($order->total_amount, 2) }}</div>
            </div>
            
            <div class="d-flex justify-content-between">
                <small class="text-muted">
                    {{ $order->created_at->format('M d, Y h:i A') }}
                </small>
                
                <div class="btn-group">
                    @if($order->status === 'draft')
                        <a href="{{ route('orders.edit', $order) }}" class="btn btn-sm btn-primary">
                            <i class="las la-edit"></i>
                        </a>
                    @endif
                    
                    @if($order->status === 'confirmed')
                        <button class="btn btn-sm btn-success complete-order-btn" data-order-id="{{ $order->id }}">
                            <i class="las la-check-circle"></i>
                        </button>
                    @endif
                    
                    @if(in_array($order->status, ['draft', 'confirmed']))
                        <button class="btn btn-sm btn-danger cancel-order-btn" data-order-id="{{ $order->id }}">
                            <i class="las la-times"></i>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>