<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $categories = Category::withCount('products')
            ->whereNull('parent_id')
            ->whereHas('products')
            ->take(6)
            ->get();
            
        $featuredProducts = Product::with(['category', 'variants'])
            ->where('status', 'active')
            ->whereHas('variants')
            ->take(8)
            ->get();
            
        $testimonials = Testimonial::where('is_active', true)
            ->take(3)
            ->get();

        return view('website.home', compact('categories', 'featuredProducts', 'testimonials'));
    }
    
    public function products(Request $request)
    {
        $query = Product::with(['category', 'variants'])
            ->where('status', 'active')
            ->whereHas('variants');
            
        // Filter by category
        if ($request->has('category') && $request->category != 'all') {
            $query->where('category_id', $request->category);
        }
        
        // Filter by search
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }
        
        $products = $query->paginate(12);
        $categories = Category::whereNull('parent_id')->get();
        
        return view('website.products', compact('products', 'categories'));
    }
    
    public function productDetail($id, $slug = null)
    {
        $product = Product::with(['category', 'brand', 'variants'])
            ->where('id', $id)
            ->where('status', 'active')
            ->firstOrFail();
            
        $relatedProducts = Product::with(['variants'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->take(4)
            ->get();
            
        return view('website.product-detail', compact('product', 'relatedProducts'));
    }
    
    public function about()
    {
        return view('website.about');
    }
    
    public function contact()
    {
        return view('website.contact');
    }
    
    public function contactSubmit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);
        
        // Here you would typically save to database and send email
        // For now, we'll just flash a success message
        
        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }
}
