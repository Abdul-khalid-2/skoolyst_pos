<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::where('tenant_id', auth()->user()->tenant_id)
            ->latest()
            ->paginate(20);

        // Calculate total balance by summing all account balances
        $totalBalance = Account::where('tenant_id', auth()->user()->tenant_id)
            ->sum('current_balance');

        // Count active accounts
        $activeAccounts = Account::where('tenant_id', auth()->user()->tenant_id)
            ->where('is_active', true)
            ->count();

        return view('admin.account.index', [
            'accounts' => $accounts,
            'totalBalance' => $totalBalance,
            'activeAccounts' => $activeAccounts
        ]);
    }
    public function create()
    {
        return view('admin.account.create');
    }

    public function store(Request $request)
    {

        // dd($request->currency);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'opening_balance' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $account = Account::create([
            'tenant_id' => auth()->user()->tenant_id,
            'name' => $validated['name'],
            'type' => $validated['type'],
            'account_number' => $validated['account_number'],
            'opening_balance' => $validated['opening_balance'],
            'current_balance' => $validated['opening_balance'],
            'currency' => $request->currency,
            'description' => $validated['description'],
        ]);

        return redirect()->route('accounts.index')
            ->with('success', 'Account created successfully');
    }

    public function show(Account $account)
    {
        abort_if($account->tenant_id !== auth()->user()->tenant_id, 403);

        $transactions = Transaction::where('account_id', $account->id)
            ->latest()
            ->paginate(20);

        return view('accounting.accounts.show', compact('account', 'transactions'));
    }

    public function edit(Account $account)
    {
        abort_if($account->tenant_id !== auth()->user()->tenant_id, 403);

        return view('admin.account.create', compact('account'));
    }

    public function update(Request $request, Account $account)
    {
        abort_if($account->tenant_id !== auth()->user()->tenant_id, 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'currency' => 'required|string|size:3',
            'is_active' => 'boolean',
            'description' => 'nullable|string',
        ]);

        $account->update($validated);

        return redirect()->route('accounts.index')
            ->with('success', 'Account updated successfully');
    }

    public function destroy(Account $account)
    {
        abort_if($account->tenant_id !== auth()->user()->tenant_id, 403);

        // Check if account has transactions
        if ($account->transactions()->exists()) {
            return redirect()->back()
                ->with('error', 'Cannot delete account with transactions');
        }

        $account->delete();

        return redirect()->route('accounts.index')
            ->with('success', 'Account deleted successfully');
    }
}
