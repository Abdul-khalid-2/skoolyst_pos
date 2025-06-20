<?php

// namespace App\Http\Controllers;

// use App\Models\Product;
// use App\Models\Category;
// use App\Models\Brand;
// use App\Models\Supplier;
// use App\Models\Customer;
// use App\Models\PaymentMethod;
// use App\Models\Branch;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Facades\Validator;
// use App\Models\ProductVariant;

// class PosController extends Controller
// {
//     public function index()
//     {
//         // Get all necessary data for POS
//         $categories = Category::where('tenant_id', auth()->user()->tenant_id)
//             ->withCount('products')
//             ->get();
            
//         $products = Product::where('tenant_id', auth()->user()->tenant_id)
//             ->with('variants')
//             ->get();
            
//         $customers = Customer::where('tenant_id', auth()->user()->tenant_id)
//             ->orderBy('name')
//             ->get();
            
//         $paymentMethods = PaymentMethod::where('tenant_id', auth()->user()->tenant_id)
//             ->where('is_active', true)
//             ->get();
            
//         $currentBranch = Branch::where('tenant_id', auth()->user()->tenant_id)
//             ->where('is_main', true)
//             ->first();

//         return view('admin.pos.index', [
//             'categories' => $categories,
//             'products' => $products,
//             'customers' => $customers,
//             'paymentMethods' => $paymentMethods,
//             'currentBranch' => $currentBranch
//         ]);
//     }

//     public function variants(Product $product)
//     {
//         // Ensure the product belongs to the current tenant
//         if ($product->tenant_id != auth()->user()->tenant_id) {
//             return response()->json(['error' => 'Unauthorized'], 403);
//         }

//         return response()->json($product->variants);
//     }

//     public function search($term)
//     {
//         $products = Product::where('tenant_id', auth()->user()->tenant_id)
//             ->where(function($query) use ($term) {
//                 $query->where('name', 'like', "%$term%")
//                     ->orWhere('sku', 'like', "%$term%")
//                     ->orWhere('barcode', 'like', "%$term%")
//                     ->orWhereHas('variants', function($q) use ($term) {
//                         $q->where('name', 'like', "%$term%")
//                           ->orWhere('sku', 'like', "%$term%")
//                           ->orWhere('barcode', 'like', "%$term%");
//                     });
//             })
//             ->with('variants')
//             ->get();

//         return response()->json($products);
//     }

//     public function barcode($barcode)
//     {
//         $variant = ProductVariant::where('barcode', $barcode)
//             ->whereHas('product', function($q) {
//                 $q->where('tenant_id', auth()->user()->tenant_id);
//             })
//             ->with('product')
//             ->first();

//         return $variant ? response()->json($variant) : response()->json(null, 404);
//     }

//     public function products(Category $category)
//     {
//         // Ensure the category belongs to the current tenant
//         if ($category->tenant_id != auth()->user()->tenant_id) {
//             return response()->json(['error' => 'Unauthorized'], 403);
//         }

//         $products = $category->products()
//             ->with('variants')
//             ->get();

//         return response()->json($products);
//     }
// }



namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\PaymentMethod;
use App\Models\Branch;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

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
                ->where('is_main', true)
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
            ->with('variants')
            ->get();

        return response()->json($products);
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
}