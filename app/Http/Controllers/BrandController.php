<?php
namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::withCount('products')->latest()->get();
        return view('admin.brand.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brand.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $brand = new Brand();
        $brand->tenant_id = auth()->user()->tenant_id;
        $brand->name = $request->name;
        $brand->description = $request->description;



        $brand->save();

        return redirect()->route('brands.index')->with('success', 'Brand created successfully.');
    }

    public function show(Brand $brand)
    {
        return view('brands.show', compact('brand'));
    }

    public function edit(Brand $brand)
    {
        return view('admin.brand.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        $brand->name = $request->name;
        $brand->description = $request->description;


        $brand->save();

        return redirect()->route('admin.brand.index')->with('success', 'Brand updated successfully.');
    }

    public function destroy(Brand $brand)
    {
        if ($brand->logo_path) {
            Storage::disk('public')->delete($brand->logo_path);
        }
        
        $brand->delete();
        return redirect()->route('admin.brand.index')->with('success', 'Brand deleted successfully.');
    }


    // Add these methods to your BrandController

    public function uploadLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $path = Storage::disk('website')->put('brands', $request->logo);

        return response()->json([
            'path' => $path,
            'url' => asset('storage/'.$path)
        ]);
    }

    public function removeLogo(Request $request)
    {
        $request->validate([
            'path' => 'required|string',
        ]);

        Storage::disk('website')->delete($request->path);

        return response()->json(['success' => true]);
    }
}