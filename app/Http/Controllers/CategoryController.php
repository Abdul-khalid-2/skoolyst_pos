<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('parent', 'children')
            ->where('tenant_id', Auth::user()->tenant_id)
            ->latest()
            ->get();

        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        $parentCategories = Category::where('tenant_id', Auth::user()->tenant_id)
            ->whereNull('parent_id')
            ->get();

        return view('admin.category.create', compact('parentCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'nullable|string|max:20|unique:categories,code',
            'parent_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
        ]);

        Category::create([
            'tenant_id' => Auth::user()->tenant_id,
            'name' => $request->name,
            'code' => $request->code,
            'parent_id' => $request->parent_id,
            'description' => $request->description,
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function show(Category $category)
    {
        // $this->authorize('view', $category);

        return view('categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        // $this->authorize('update', $category);

        $parentCategories = Category::where('tenant_id', Auth::user()->tenant_id)
            ->whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->get();

        return view('admin.category.edit', compact('category', 'parentCategories'));
    }

    public function update(Request $request, Category $category)
    {
        // $this->authorize('update', $category);

        $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'nullable|string|max:20|unique:categories,code,' . $category->id,
            'parent_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
        ]);

        $category->update($request->all());

        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully');
    }

    public function destroy(Category $category)
    {
        // $this->authorize('delete', $category);

        if ($category->products()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete category with associated products.');
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully');
    }
}
