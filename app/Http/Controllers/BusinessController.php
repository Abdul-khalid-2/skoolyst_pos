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

        if ($request->hasFile('logo')) {
            $logo_path = Storage::disk('website')->put('business', $request->logo);
            $validated['logo_path'] = $logo_path;
        }

        if ($request->hasFile('receipt_header')) {
            $receipt_header_path = Storage::disk('website')->put('business', $request->receipt_header);
            $validated['receipt_header'] = $receipt_header_path;
        }

        if ($request->hasFile('receipt_footer')) {
            $receipt_footer_path = Storage::disk('website')->put('business', $request->receipt_footer);
            $validated['receipt_footer'] = $receipt_footer_path;
        }

        $business = Business::create($validated);

        return redirect()->route('businesses.index')
            ->with('success', 'Business created successfully.');
    }

    public function show(Business $business)
    {
        // $this->authorize('view', $business);

        return view('businesses.show', compact('business'));
    }

    public function edit(Business $business)
    {
        // $this->authorize('update', $business);

        return view('admin.business.form', compact('business'));
    }

    public function update(Request $request, Business $business)
    {
        // $this->authorize('update', $business);

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

        if ($request->hasFile('logo')) {
            if ($business->logo_path) {
                Storage::disk('website')->delete($business->logo_path);
            }
            $logo_path = Storage::disk('website')->put('business', $request->logo);
            $validated['logo_path'] = $logo_path;
        }

        if ($request->hasFile('receipt_header')) {
            if ($business->receipt_header) {
                Storage::disk('website')->delete($business->receipt_header);
            }
            $receipt_header_path = Storage::disk('website')->put('business', $request->receipt_header);
            $validated['receipt_header'] = $receipt_header_path;
        }

        if ($request->hasFile('receipt_footer')) {
            if ($business->receipt_footer) {
                Storage::disk('website')->delete($business->receipt_footer);
            }
            $receipt_footer_path = Storage::disk('website')->put('business', $request->receipt_footer);
            $validated['receipt_footer'] = $receipt_footer_path;
        }

        $business->update($validated);

        return redirect()->route('businesses.index')
            ->with('success', 'Business updated successfully.');
    }

    public function destroy(Business $business)
    {
        // $this->authorize('delete', $business);

        if ($business->branches()->exists()) {
            return redirect()->back()
                ->with('error', 'Cannot delete business with associated branches.');
        }

        if ($business->logo_path) {
            Storage::disk('website')->delete($business->logo_path);
        }

        if ($business->receipt_header) {
            Storage::disk('website')->delete($business->receipt_header);
        }

        if ($business->receipt_footer) {
            Storage::disk('website')->delete($business->receipt_footer);
        }

        $business->delete();

        return redirect()->route('businesses.index')
            ->with('success', 'Business deleted successfully.');
    }
}
