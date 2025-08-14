<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Customer;
use App\Models\Branch;
use App\Models\Category;
use App\Models\PaymentMethod;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\SalePayment;
use App\Models\InventoryLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        try {
            $tenantId = auth()->user()->tenant_id;

            // Base query with eager loading
            $query = Order::with([
                'customer:id,name,email,phone',
                'user:id,name',
                'items.product:id,name',
                'items.variant:id,name'
            ])
                ->where('tenant_id', $tenantId)
                ->orderBy('created_at', 'desc');



            // For regular requests - return view with paginated data
            $orders = $query->paginate(20);

            return view('admin.order.index', [
                'orders' => $orders,
                'categories' => Category::where('tenant_id', $tenantId)->get(),
                'currentBranch' => Branch::where('tenant_id', $tenantId)->first()
            ]);
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to load orders',
                    'error' => config('app.debug') ? $e->getMessage() : null
                ], 500);
            }

            return back()->with('error', 'Failed to load orders: ' . $e->getMessage());
        }
    }

    public function jsonIndex(Request $request)
    {
        try {
            $tenantId = auth()->user()->tenant_id;

            // Base query with eager loading
            $query = Order::with([
                'customer:id,name,email,phone',
                'user:id,name',
                'items.product:id,name',
                'items.variant:id,name'
            ])
                ->where('tenant_id', $tenantId)
                ->orderBy('created_at', 'desc');

            // For AJAX requests - return JSON
            if ($request->ajax() || $request->has('ajax')) {
                // Get only necessary fields for the initial load
                $orders = $query->get([
                    'id',
                    'order_number',
                    'status',
                    'total_amount',
                    'created_at',
                    'customer_id',
                    'user_id',
                    'subtotal',
                    'tax_amount',
                    'discount_amount',
                ]);

                // Convert string amounts to numbers
                $orders->transform(function ($order) {
                    $order->total_amount = (float)$order->total_amount;
                    $order->subtotal = (float)$order->subtotal;
                    $order->tax_amount = (float)$order->tax_amount;
                    $order->discount_amount = (float)$order->discount_amount;
                    return $order;
                });

                return response()->json([
                    'success' => true,
                    'orders' => $orders,
                    'categories' => Category::where('tenant_id', $tenantId)->get(['id', 'name']),
                    'currentBranch' => Branch::where('tenant_id', $tenantId)->first(['id', 'name'])
                ]);
            }
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to load orders',
                    'error' => config('app.debug') ? $e->getMessage() : null
                ], 500);
            }

            return back()->with('error', 'Failed to load orders: ' . $e->getMessage());
        }
    }

    public function create()
    {
        $tenantId = auth()->user()->tenant_id;

        return view('admin.order.create', [
            'categories' => Category::where('tenant_id', $tenantId)
                ->withCount('products')
                ->get(),
            'products' => Product::where('tenant_id', $tenantId)
                ->with(['variants' => function ($query) {
                    $query->orderBy('name');
                }])
                ->get(),
            'customers' => Customer::where('tenant_id', $tenantId)
                ->orderBy('name')
                ->get(),
            'currentBranch' => Branch::where('tenant_id', $tenantId)
                ->firstOrFail()
        ]);
    }

    public function allProducts()
    {
        $tenantId = auth()->user()->tenant_id;

        return response()->json([
            'categories' => Category::where('tenant_id', $tenantId)
                ->withCount('products')
                ->get(),
            'products' => Product::where('tenant_id', $tenantId)
                ->with(['variants' => function ($query) {
                    $query->orderBy('name');
                }])
                ->get(),
            'customers' => Customer::where('tenant_id', $tenantId)
                ->orderBy('name')
                ->get(),
            'currentBranch' => Branch::where('tenant_id', $tenantId)
                ->firstOrFail()
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'nullable',
            'branch_id' => 'required|exists:branches,id',
            'order_number' => 'required|string|max:255|unique:orders',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.variant_id' => 'nullable|exists:product_variants,id',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'custom_customer_name' => 'nullable|string|max:255',
            'custom_customer_phone' => 'nullable|string|max:20',
        ]);

        try {
            // Handle customer
            $customerId = null;
            $walkInCustomerInfo = null;

            if ($request->customer_id !== 'Walk-in-Customer' && $request->customer_id) {
                $customerId = $request->customer_id;
            } elseif ($request->filled('custom_customer_name')) {
                $walkInCustomerInfo = [
                    'name' => $request->custom_customer_name,
                    'phone' => $request->custom_customer_phone,
                ];
            }

            // Calculate totals
            $subtotal = 0;

            foreach ($request->items as $item) {
                $itemTotal = $item['quantity'] * $item['unit_price'];
                $subtotal += $itemTotal;
            }

            $totalAmount = $subtotal;

            // Create order
            $order = Order::create([
                'tenant_id' => auth()->user()->tenant_id,
                'branch_id' => $request->branch_id,
                'customer_id' => $customerId,
                'walk_in_customer_info' => $walkInCustomerInfo,
                'user_id' => auth()->id(),
                'order_number' => $request->order_number,
                'subtotal' => $subtotal,
                'tax_amount' => 0,
                'discount_amount' => 0,
                'total_amount' => $totalAmount,
                'status' => $request->status ?? 'draft',
                'storage_type' => $request->storage_type ?? 'session',
                'notes' => $request->notes,
            ]);

            // Create order items
            foreach ($request->items as $item) {
                $itemTotal = $item['quantity'] * $item['unit_price'];

                $order->items()->create([
                    'tenant_id' => auth()->user()->tenant_id,
                    'product_id' => $item['product_id'],
                    'variant_id' => $item['variant_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'cost_price' => $item['cost_price'] ?? $item['unit_price'] * 0.8, // Default cost price
                    'total_price' => $itemTotal,
                ]);
            }

            return response()->json([
                'success' => true,
                'order' => $order->load(['items.product', 'items.variant', 'customer']),
                'message' => 'Order saved successfully',
                'print_url' => route('orders.print', $order->id) // Add print URL to response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saving order: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit(Order $order)
    {
        $tenantId = auth()->user()->tenant_id;

        if ($order->tenant_id !== $tenantId || $order->status === 'completed') {
            abort(403);
        }

        // Load products with variants and stock information
        $products = Product::where('tenant_id', $tenantId)
            ->with(['variants' => function ($query) {
                $query->orderBy('name');
            }])
            ->get();

        return view('admin.order.edit', [
            'order' => $order->load(['items.product', 'items.variant', 'customer']),
            'categories' => Category::where('tenant_id', $tenantId)
                ->withCount('products')
                ->get(),
            'products' => $products,
            'customers' => Customer::where('tenant_id', $tenantId)
                ->orderBy('name')
                ->get(),
            'currentBranch' => Branch::where('tenant_id', $tenantId)
                ->firstOrFail()
        ]);
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'customer_id' => 'nullable',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.variant_id' => 'nullable|exists:product_variants,id',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'custom_customer_name' => 'nullable|string|max:255',
            'custom_customer_phone' => 'nullable|string|max:20',
        ]);

        try {
            // Handle customer
            $customerId = null;
            $walkInCustomerInfo = null;

            if ($request->customer_id !== 'Walk-in-Customer' && $request->customer_id) {
                $customerId = $request->customer_id;
            } elseif ($request->filled('custom_customer_name')) {
                $walkInCustomerInfo = [
                    'name' => $request->custom_customer_name,
                    'phone' => $request->custom_customer_phone,
                ];
            }

            // Calculate totals
            $subtotal = 0;

            foreach ($request->items as $item) {
                $itemTotal = $item['quantity'] * $item['unit_price'];
                $subtotal += $itemTotal;
            }

            $totalAmount = $subtotal;

            // Update order
            $order->update([
                'customer_id' => $customerId,
                'walk_in_customer_info' => $walkInCustomerInfo,
                'subtotal' => $subtotal,
                'tax_amount' => 0,
                'discount_amount' => 0,
                'total_amount' => $totalAmount,
                'status' => $request->status ?? $order->status,
                'storage_type' => $request->storage_type ?? $order->storage_type,
                'notes' => $request->notes,
            ]);

            // Sync order items
            $order->items()->delete();

            foreach ($request->items as $item) {
                $itemTotal = $item['quantity'] * $item['unit_price'];

                $order->items()->create([
                    'tenant_id' => auth()->user()->tenant_id,
                    'product_id' => $item['product_id'],
                    'variant_id' => $item['variant_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'cost_price' => $item['cost_price'] ?? $item['unit_price'] * 0.8, // Default cost price
                    'total_price' => $itemTotal,
                ]);
            }

            return response()->json([
                'success' => true,
                'order' => $order->load(['items.product', 'items.variant', 'customer']),
                'message' => 'Order updated successfully',
                'print_url' => route('orders.print', $order->id)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating order: ' . $e->getMessage()
            ], 500);
        }
    }

    public function complete(Order $order)
    {
        try {
            if ($order->status !== 'confirmed') {
                throw new \Exception('Only confirmed orders can be completed');
            }

            // Convert order to sale
            $sale = $this->convertOrderToSale($order);

            // Update order status
            $order->update(['status' => 'completed']);

            return response()->json([
                'success' => true,
                'sale' => $sale,
                'order' => $order,
                'message' => 'Order completed and converted to sale successfully',
                'print_url' => route('orders.print', $order->id) // Add print URL to response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error completing order: ' . $e->getMessage()
            ], 500);
        }
    }

    public function print(Order $order)
    {
        $currentBranch = Branch::find($order->branch_id);
        return view('admin.order.orderbill', [
            'order' => $order,
            'currentBranch' => $currentBranch
        ]);
    }

    public function cancel(Order $order)
    {
        try {
            if ($order->status === 'completed') {
                throw new \Exception('Completed orders cannot be cancelled');
            }

            $order->update(['status' => 'cancelled']);

            return response()->json([
                'success' => true,
                'message' => 'Order cancelled successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error cancelling order: ' . $e->getMessage()
            ], 500);
        }
    }

    public function filter(Request $request)
    {
        $tenantId = auth()->user()->tenant_id;

        $query = Order::with(['customer', 'user', 'items.product'])
            ->where('tenant_id', $tenantId);

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->storage_type) {
            $query->where('storage_type', $request->storage_type);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('order_number', 'like', '%' . $request->search . '%')
                    ->orWhereHas('customer', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->search . '%');
                    });
            });
        }

        $orders = $query->orderBy('created_at', 'desc')->get();

        return view('admin.order.partials.order-cards', ['orders' => $orders]);
    }

    protected function convertOrderToSale(Order $order)
    {
        try {
            // Generate invoice number
            $invoiceNumber = 'MD-' . \Carbon\Carbon::now()->format('Ymd-his');

            // Create sale
            $sale = Sale::create([
                'tenant_id' => $order->tenant_id,
                'branch_id' => $order->branch_id,
                'customer_id' => $order->customer_id,
                'walk_in_customer_info' => $order->walk_in_customer_info,
                'user_id' => $order->user_id,
                'invoice_number' => $invoiceNumber,
                'sale_date' => now(),
                'subtotal' => $order->subtotal,
                'tax_amount' => $order->tax_amount,
                'discount_amount' => $order->discount_amount,
                'total_amount' => $order->total_amount,
                'amount_paid' => $order->total_amount, // Assume full payment for now
                'change_amount' => 0,
                'payment_status' => 'paid',
                'status' => 'completed',
                'notes' => $order->notes,
            ]);

            // Create sale items
            foreach ($order->items as $orderItem) {
                $saleItem = SaleItem::create([
                    'tenant_id' => $orderItem->tenant_id,
                    'sale_id' => $sale->id,
                    'product_id' => $orderItem->product_id,
                    'variant_id' => $orderItem->variant_id,
                    'quantity' => $orderItem->quantity,
                    'unit_price' => $orderItem->unit_price,
                    'cost_price' => $orderItem->cost_price,
                    'tax_rate' => 0,
                    'tax_amount' => 0,
                    'discount_rate' => 0,
                    'discount_amount' => 0,
                    'total_price' => $orderItem->total_price,
                ]);

                // Update inventory
                $this->updateInventory(
                    $orderItem->product_id,
                    $orderItem->variant_id,
                    $order->branch_id,
                    -$orderItem->quantity,
                    $sale->id
                );
            }

            // Create payment record
            SalePayment::create([
                'tenant_id' => $order->tenant_id,
                'sale_id' => $sale->id,
                'payment_method_id' => 1, // Default to cash payment
                'amount' => $order->total_amount,
                'reference' => 'From Order #' . $order->order_number,
                'user_id' => $order->user_id,
            ]);

            return $sale;
        } catch (\Exception $e) {
            throw new \Exception('Error converting order to sale: ' . $e->getMessage());
        }
    }

    protected function updateInventory($productId, $variantId, $branchId, $quantity, $referenceId, $referenceType = 'sale')
    {
        if ($variantId) {
            $variant = ProductVariant::find($variantId);
            $variant->decrement('current_stock', abs($quantity));
            $newQuantity = $variant->current_stock;
        } else {
            // Handle products without variants if needed
            $product = Product::find($productId);
            $newQuantity = 0;
        }

        // Create inventory log
        InventoryLog::create([
            'tenant_id' => auth()->user()->tenant_id,
            'product_id' => $productId,
            'variant_id' => $variantId,
            'branch_id' => $branchId,
            'quantity_change' => $quantity,
            'new_quantity' => $newQuantity,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
            'user_id' => auth()->id(),
        ]);
    }
}
