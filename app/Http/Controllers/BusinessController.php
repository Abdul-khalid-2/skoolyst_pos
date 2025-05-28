<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class BusinessController extends Controller
{
    public function index()
    {
        $businesses = Business::with(['tenant', 'branches'])
            ->where('tenant_id', auth()->user()->tenant_id)
            ->latest()
            ->paginate(10);

        return view('admin.business.index', compact('businesses'));
    }

    public function create()
    {
        return view('admin.business.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'tax_number' => 'nullable|string|max:50',
            'registration_number' => 'nullable|string|max:50',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'receipt_header' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'receipt_footer' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $validated['tenant_id'] = auth()->user()->tenant_id;

        // Handle file uploads
        if ($request->hasFile('logo')) {
            $validated['logo_path'] = $request->file('logo')->store('business/logos', 'public');
        }

        if ($request->hasFile('receipt_header')) {
            $validated['receipt_header'] = $request->file('receipt_header')->store('business/receipts/headers', 'public');
        }

        if ($request->hasFile('receipt_footer')) {
            $validated['receipt_footer'] = $request->file('receipt_footer')->store('business/receipts/footers', 'public');
        }

        $business = Business::create($validated);

        return redirect()->route('businesses.index')
            ->with('success', 'Business created successfully.');
    }

    public function show(Business $business)
    {
        $this->authorize('view', $business);

        return view('businesses.show', compact('business'));
    }

    public function edit(Business $business)
    {
        $this->authorize('update', $business);

        return view('businesses.edit', compact('business'));
    }

    public function update(Request $request, Business $business)
    {
        $this->authorize('update', $business);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'tax_number' => 'nullable|string|max:50',
            'registration_number' => 'nullable|string|max:50',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'receipt_header' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'receipt_footer' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle file uploads
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($business->logo_path) {
                Storage::disk('public')->delete($business->logo_path);
            }
            $validated['logo_path'] = $request->file('logo')->store('business/logos', 'public');
        }

        if ($request->hasFile('receipt_header')) {
            if ($business->receipt_header) {
                Storage::disk('public')->delete($business->receipt_header);
            }
            $validated['receipt_header'] = $request->file('receipt_header')->store('business/receipts/headers', 'public');
        }

        if ($request->hasFile('receipt_footer')) {
            if ($business->receipt_footer) {
                Storage::disk('public')->delete($business->receipt_footer);
            }
            $validated['receipt_footer'] = $request->file('receipt_footer')->store('business/receipts/footers', 'public');
        }

        $business->update($validated);

        return redirect()->route('businesses.index')
            ->with('success', 'Business updated successfully.');
    }

    public function destroy(Business $business)
    {
        $this->authorize('delete', $business);

        // Check if business has branches
        if ($business->branches()->exists()) {
            return redirect()->back()
                ->with('error', 'Cannot delete business with associated branches.');
        }

        // Delete associated files
        if ($business->logo_path) {
            Storage::disk('public')->delete($business->logo_path);
        }
        if ($business->receipt_header) {
            Storage::disk('public')->delete($business->receipt_header);
        }
        if ($business->receipt_footer) {
            Storage::disk('public')->delete($business->receipt_footer);
        }

        $business->delete();

        return redirect()->route('businesses.index')
            ->with('success', 'Business deleted successfully.');
    }
}
