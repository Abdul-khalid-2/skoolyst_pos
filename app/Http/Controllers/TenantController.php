<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Stancl\Tenancy\Database\Models\Domain;

class TenantController extends Controller
{
    /**
     * Display a listing of the tenants.
     */
    public function index()
    {
        $tenants = Tenant::withCount('businesses')->latest()->paginate(10);

        return view('admin.tenant.index', compact('tenants'));
    }

    /**
     * Show the form for creating a new tenant.
     */
    public function create()
    {
        return view('admin.tenant.form');
    }

    /**
     * Store a newly created tenant in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'domain' => 'required|string|max:255|unique:domains,domain',
            'database_name' => 'required|string|max:255|unique:tenants,database_name',
            'email' => 'required|email|unique:tenants,email',
            'timezone' => 'required|timezone',
            'currency' => 'required|string|size:3',
            'locale' => 'required|string|max:10',
            'is_active' => 'boolean',
            'trial_ends_at' => 'nullable|date',
        ]);

        DB::transaction(function () use ($validated) {
            $tenant = Tenant::create([
                'name' => $validated['name'],
                'slug' => strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $validated['name'])),
                'database_name' => $validated['database_name'],
                'email' => $validated['email'],
                'timezone' => $validated['timezone'],
                'currency' => $validated['currency'],
                'locale' => $validated['locale'],
                'is_active' => $validated['is_active'] ?? true,
                'trial_ends_at' => $validated['trial_ends_at'] ?? null,
            ]);

            $tenant->domains()->create([
                'domain' => $validated['domain'],
            ]);
        });

        return redirect()->route('tenants.index')->with('success', 'Tenant created successfully.');
    }

    /**
     * Display the specified tenant.
     */
    public function show(Tenant $tenant)
    {
        $tenant->loadCount('businesses');
        $businesses = $tenant->businesses()->withCount('branches')->latest()->paginate(5);

        return view('admin.tenant.show', compact('tenant', 'businesses'));
    }

    /**
     * Show the form for editing the specified tenant.
     */
    public function edit(Tenant $tenant)
    {
        return view('admin.tenant.form', compact('tenant'));
    }

    /**
     * Update the specified tenant in storage.
     */
    public function update(Request $request, Tenant $tenant)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'domain' => [
                'required',
                'string',
                'max:255',
                Rule::unique('domains', 'domain')->ignore($tenant->domains->first()->id),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('tenants', 'email')->ignore($tenant->id),
            ],
            'timezone' => 'required|timezone',
            'currency' => 'required|string|size:3',
            'locale' => 'required|string|max:10',
            'is_active' => 'boolean',
            'trial_ends_at' => 'nullable|date',
        ]);

        DB::transaction(function () use ($validated, $tenant) {
            $tenant->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'timezone' => $validated['timezone'],
                'currency' => $validated['currency'],
                'locale' => $validated['locale'],
                'is_active' => $validated['is_active'] ?? $tenant->is_active,
                'trial_ends_at' => $validated['trial_ends_at'] ?? $tenant->trial_ends_at,
            ]);

            $tenant->domains()->update([
                'domain' => $validated['domain'],
            ]);
        });

        return redirect()->route('tenants.index')->with('success', 'Tenant updated successfully.');
    }

    /**
     * Remove the specified tenant from storage.
     */
    public function destroy(Tenant $tenant)
    {
        DB::transaction(function () use ($tenant) {
            $tenant->domains()->delete();
            $tenant->delete();
        });

        return redirect()->route('tenants.index')->with('success', 'Tenant deleted successfully.');
    }

    /**
     * Show the tenant dashboard with business progress.
     */
    public function dashboard(Tenant $tenant)
    {
        $tenant->load([
            'businesses' => function ($query) {
                $query->withCount('branches');
            },
            'businesses.branches'
        ]);

        // Get sales data for the last 30 days
        $salesData = DB::table('sales')
            ->where('tenant_id', $tenant->id)
            ->select(
                DB::raw('DATE(sale_date) as date'),
                DB::raw('COUNT(*) as sales_count'),
                DB::raw('SUM(total_amount) as sales_total')
            )
            ->where('sale_date', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Get top products
        $topProducts = DB::table('sale_items')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->where('sale_items.tenant_id', $tenant->id)
            ->select(
                'products.name',
                DB::raw('SUM(sale_items.quantity) as total_quantity'),
                DB::raw('SUM(sale_items.total_price) as total_revenue')
            )
            ->groupBy('products.name')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();

        // Get business metrics
        $metrics = [
            'total_businesses' => $tenant->businesses->count(),
            'total_branches' => $tenant->businesses->sum('branches_count'),
            'active_branches' => $tenant->businesses->sum(function ($business) {
                return $business->branches->where('is_active', true)->count();
            }),
            'total_sales' => DB::table('sales')
                ->where('tenant_id', $tenant->id)
                ->where('sale_date', '>=', now()->startOfMonth())
                ->sum('total_amount'),
        ];

        return view('admin.tenant.dashboard', compact('tenant', 'salesData', 'topProducts', 'metrics'));
    }
}
