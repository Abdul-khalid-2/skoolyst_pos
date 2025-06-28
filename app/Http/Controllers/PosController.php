<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\PaymentMethod;
use App\Models\Branch;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use App\Models\InventoryLog;
use App\Models\SalePayment;
use App\Models\Business;

class PosController extends Controller
{
    public function index()
    {
        $tenantId = auth()->user()->tenant_id;

        return view('admin.pos.index', [
            'categories' => Category::where('tenant_id', $tenantId)
                ->withCount('products')
                ->get(),
            'products' => Product::where('tenant_id', $tenantId)
                ->with(['variants' => function($query) {
                    $query->orderBy('name');
                }])
                ->get(),
            'customers' => Customer::where('tenant_id', $tenantId)
                ->orderBy('name')
                ->get(),
            'paymentMethods' => PaymentMethod::where('tenant_id', $tenantId)
                ->where('is_active', true)
                ->get(),
            'currentBranch' => Branch::where('tenant_id', $tenantId)
                ->firstOrFail()
        ]);
    }

    public function variants(Product $product)
    {
        $this->authorizeProductAccess($product);
        return response()->json($product->variants);
    }

    public function variantsData(Product $product)
    {
        $this->authorizeProductAccess($product);
        return response()->json($product->variants);
    }

    public function search($term)
    {
        $products = Product::where('tenant_id', auth()->user()->tenant_id)
            ->where(function($query) use ($term) {
                $query->where('name', 'like', "%$term%")
                    ->orWhere('sku', 'like', "%$term%")
                    ->orWhere('barcode', 'like', "%$term%")
                    ->orWhereHas('variants', function($q) use ($term) {
                        $q->where('name', 'like', "%$term%")
                          ->orWhere('sku', 'like', "%$term%")
                          ->orWhere('barcode', 'like', "%$term%");
                    });
            })
            ->with('variants')
            ->get();

        return response()->json($products);
    }

    public function barcode($barcode)
    {
        $variant = ProductVariant::where('barcode', $barcode)
            ->whereHas('product', function($q) {
                $q->where('tenant_id', auth()->user()->tenant_id);
            })
            ->with('product')
            ->first();

        return $variant ? response()->json($variant) : response()->json(null, 404);
    }

    public function products(Category $category)
    {
        $this->authorizeCategoryAccess($category);
        $products = $category->products()
            ->with(['variants' => function($query) {
                $query->orderBy('name');
            }])
            ->get()
            ->map(function($product) {
                // Ensure image_paths is properly formatted
                if ($product->image_paths) {
                    try {
                        $decoded = is_string($product->image_paths) 
                            ? json_decode($product->image_paths, true) 
                            : $product->image_paths;
                        
                        if (is_array($decoded)) {
                            $product->image_paths = array_map(function($path) {
                                return ltrim($path, '/'); // Remove leading slash if exists
                            }, $decoded);
                        }
                    } catch (\Exception $e) {
                        $product->image_paths = null;
                    }
                }
                return $product;
            });

        return response()->json($products);
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'customer_id' => 'nullable',
            'branch_id' => 'required|exists:branches,id',
            'invoice_number' => 'required|string|max:255|unique:sales',
            'sale_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.variant_id' => 'nullable|exists:product_variants,id',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.tax_rate' => 'nullable|numeric|min:0|max:100',
            'items.*.discount_rate' => 'nullable|numeric|min:0|max:100',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'amount_paid' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
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
            $taxAmount = 0;
            $discountAmount = 0;

            foreach ($request->items as $item) {
                $itemTotal = $item['quantity'] * $item['unit_price'];
                $itemDiscount = $itemTotal * ($item['discount_rate'] ?? 0) / 100;
                $itemTax = ($itemTotal - $itemDiscount) * ($item['tax_rate'] ?? 0) / 100;

                $subtotal += $itemTotal;
                $taxAmount += $itemTax;
                $discountAmount += $itemDiscount;
            }

            $totalAmount = $subtotal + $taxAmount - $discountAmount - $request->discount_amount;
            $changeAmount = max(0, $request->amount_paid - $totalAmount);
            $paymentStatus = $request->amount_paid >= $totalAmount ? 'paid' : 'partial';

            // Create sale
            $sale = Sale::create([
                'tenant_id' => auth()->user()->tenant_id,
                'branch_id' => $request->branch_id,
                'customer_id' => $customerId,
                'walk_in_customer_info' => $walkInCustomerInfo,
                'user_id' => auth()->id(),
                'invoice_number' => $request->invoice_number,
                'sale_date' => $request->sale_date,
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'discount_amount' => $discountAmount + $request->discount_amount,
                'total_amount' => $totalAmount,
                'amount_paid' => min($request->amount_paid, $totalAmount),
                'change_amount' => $changeAmount,
                'payment_status' => $paymentStatus,
                'status' => 'completed',
                'notes' => $request->notes,
            ]);

            // Create sale items
            foreach ($request->items as $item) {
                $itemTotal = $item['quantity'] * $item['unit_price'];
                $itemDiscount = $itemTotal * ($item['discount_rate'] ?? 0) / 100;
                $itemTax = ($itemTotal - $itemDiscount) * ($item['tax_rate'] ?? 0) / 100;

                $saleItem = SaleItem::create([
                    'tenant_id' => auth()->user()->tenant_id,
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'variant_id' => $item['variant_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'cost_price' => $item['cost_price'],
                    'tax_rate' => $item['tax_rate'] ?? 0,
                    'tax_amount' => $itemTax,
                    'discount_rate' => $item['discount_rate'] ?? 0,
                    'discount_amount' => $itemDiscount + $request->discount_amount,
                    'total_price' => $itemTotal - $itemDiscount + $itemTax,
                ]);

                // Update inventory
                $this->updateInventory(
                    $item['product_id'],
                    $item['variant_id'],
                    $request->branch_id,
                    -$item['quantity'],
                    $sale->id
                );
            }

            // Record payment if any amount was paid
            if ($request->amount_paid > 0) {
                SalePayment::create([
                    'tenant_id' => auth()->user()->tenant_id,
                    'sale_id' => $sale->id,
                    'payment_method_id' => $request->payment_method_id,
                    'amount' => min($request->amount_paid, $totalAmount),
                    'reference' => $request->payment_reference,
                    'user_id' => auth()->id(),
                ]);
            }


            if ($request->ajax()) {
                $business = Business::first(); // Get business info
                $sale->load(['items.product', 'items.variant', 'payments.paymentMethod', 'customer', 'branch']);
                
                $invoiceHtml = view('admin.pos.invoice', [
                    'sale' => $sale,
                    'business' => $business
                ])->render();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Sale completed successfully',
                    'invoice_html' => $invoiceHtml,
                    'invoice_number' => $sale->invoice_number
                ]);
            }

            return redirect()->route('sales.show', $sale->id)
                ->with('success', 'Sale completed successfully.');

        } catch (\Exception $e) {
            // Return JSON error response for AJAX requests
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
            }

            return back()->withInput()
                ->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function storeCustomer(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email',
            'address' => 'nullable|string'
        ]);

        $customer = Customer::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'address' => $validated['address'],
            'tenant_id' => auth()->user()->tenant_id
        ]);

        return response()->json($customer);
    }

    private function authorizeProductAccess(Product $product)
    {
        if ($product->tenant_id != auth()->user()->tenant_id) {
            abort(403, 'Unauthorized access to product');
        }
    }

    private function authorizeCategoryAccess(Category $category)
    {
        if ($category->tenant_id != auth()->user()->tenant_id) {
            abort(403, 'Unauthorized access to category');
        }
    }

    public function posProducts()
    {
        $products = Product::where('tenant_id', auth()->user()->tenant_id)
            ->with(['variants' => function ($query) {
                $query->orderBy('name');
            }])
            ->get()
            ->map(function($product) {
                // Same image path processing as above
                if ($product->image_paths) {
                    try {
                        $decoded = is_string($product->image_paths) 
                            ? json_decode($product->image_paths, true) 
                            : $product->image_paths;
                        
                        if (is_array($decoded)) {
                            $product->image_paths = array_map(function($path) {
                                return ltrim($path, '/');
                            }, $decoded);
                        }
                    } catch (\Exception $e) {
                        $product->image_paths = null;
                    }
                }
                return $product;
            });

        return response()->json($products);
    }

    protected function updateInventory($productId, $variantId, $branchId, $quantity, $referenceId, $referenceType = 'sale')
    {
        if ($variantId) {
            $variant = ProductVariant::find($variantId);
            $variant->increment('current_stock', $quantity);
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
