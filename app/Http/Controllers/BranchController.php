<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Business;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::with(['business', 'tenant'])
            ->where('tenant_id', auth()->user()->tenant_id)
            ->latest()
            ->paginate(10);

        return view('admin.branch.index', compact('branches'));
    }

    public function create()
    {
        $businesses = Business::where('tenant_id', auth()->user()->tenant_id)
            ->pluck('name', 'id');

        return view('admin.branch.form', compact('businesses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'business_id' => 'required|exists:businesses,id',
            'name' => 'required|string|max:255',
            'code' => [
                'required',
                'string',
                'max:10',
                Rule::unique('branches')->where(function ($query) use ($request) {
                    return $query->where('tenant_id', auth()->user()->tenant_id);
                })
            ],
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'is_main' => 'boolean'
        ]);

        $validated['tenant_id'] = auth()->user()->tenant_id;

        // Ensure only one main branch per business
        if ($request->has('is_main') && $request->is_main) {
            Branch::where('business_id', $validated['business_id'])
                ->where('is_main', true)
                ->update(['is_main' => false]);
        }

        Branch::create($validated);

        return redirect()->route('branches.index')
            ->with('success', 'Branch created successfully.');
    }

    public function show(Branch $branch)
    {
        // $this->authorize('view', $branch);

        return view('branches.show', compact('branch'));
    }

    public function edit(Branch $branch)
    {
        // $this->authorize('update', $branch);

        $businesses = Business::where('tenant_id', auth()->user()->tenant_id)
            ->pluck('name', 'id');

        return view('admin.branch.form', compact('branch', 'businesses'));
    }

    public function update(Request $request, Branch $branch)
    {
        // $this->authorize('update', $branch);

        $validated = $request->validate([
            'business_id' => 'required|exists:businesses,id',
            'name' => 'required|string|max:255',
            'code' => [
                'required',
                'string',
                'max:10',
                Rule::unique('branches')
                    ->ignore($branch->id)
                    ->where(function ($query) use ($request) {
                        return $query->where('tenant_id', auth()->user()->tenant_id);
                    })
            ],
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'is_main' => 'boolean'
        ]);

        // Handle main branch update
        if ($request->has('is_main') && $request->is_main && !$branch->is_main) {
            Branch::where('business_id', $validated['business_id'])
                ->where('is_main', true)
                ->update(['is_main' => false]);
        }

        $branch->update($validated);

        return redirect()->route('branches.index')
            ->with('success', 'Branch updated successfully.');
    }

    public function destroy(Branch $branch)
    {
        // $this->authorize('delete', $branch);

        // Prevent deletion of main branch
        if ($branch->is_main) {
            return redirect()->back()
                ->with('error', 'Cannot delete the main branch.');
        }

        // Check if branch has any associated records
        if ($branch->sales()->exists() || $branch->purchases()->exists()) {
            return redirect()->back()
                ->with('error', 'Cannot delete branch with associated transactions.');
        }

        $branch->delete();

        return redirect()->route('branches.index')
            ->with('success', 'Branch deleted successfully.');
    }
}
