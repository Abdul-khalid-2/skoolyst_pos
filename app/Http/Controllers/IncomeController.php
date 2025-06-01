<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Account;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function index()
    {
        $income = Transaction::with('account')
            ->where('tenant_id', auth()->user()->tenant_id)
            ->where('type', 'income')
            ->latest()
            ->paginate(20);

        $totalIncome = Transaction::where('tenant_id', auth()->user()->tenant_id)
            ->where('type', 'income')
            ->sum('amount');

        return view('admin.income.index', compact('income', 'totalIncome'));
    }

    public function create()
    {
        $accounts = Account::where('tenant_id', auth()->user()->tenant_id)
            ->where('is_active', true)
            ->get();

        return view('admin.income.create', compact('accounts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'reference' => 'nullable|string|max:255',
        ]);

        $transaction = Transaction::create([
            'tenant_id' => auth()->user()->tenant_id,
            'user_id' => auth()->id(),
            'account_id' => $validated['account_id'],
            'type' => 'income',
            'amount' => $validated['amount'],
            'date' => $validated['date'],
            'category' => $validated['category'],
            'description' => $validated['description'],
            'reference' => $validated['reference'],
        ]);

        // Update account balance
        $account = Account::find($validated['account_id']);
        $account->current_balance += $validated['amount'];
        $account->save();

        return redirect()->route('income.index')
            ->with('success', 'Income recorded successfully');
    }

    public function show(Transaction $income)
    {
        abort_if($income->tenant_id !== auth()->user()->tenant_id || $income->type !== 'income', 403);

        return view('admin.income.show', compact('income'));
    }

    public function edit(Transaction $income)
    {
        abort_if($income->tenant_id !== auth()->user()->tenant_id || $income->type !== 'income', 403);

        $accounts = Account::where('tenant_id', auth()->user()->tenant_id)
            ->where('is_active', true)
            ->get();

        return view('admin.income.create', compact('income', 'accounts'));
    }

    public function update(Request $request, Transaction $income)
    {
        abort_if($income->tenant_id !== auth()->user()->tenant_id || $income->type !== 'income', 403);

        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'reference' => 'nullable|string|max:255',
        ]);

        // Revert old income amount from account
        $oldAccount = $income->account;
        $oldAccount->current_balance -= $income->amount;
        $oldAccount->save();

        // Update income
        $income->update($validated);

        // Apply new income amount to account
        $newAccount = Account::find($validated['account_id']);
        $newAccount->current_balance += $validated['amount'];
        $newAccount->save();

        return redirect()->route('accounting.income.index')
            ->with('success', 'Income updated successfully');
    }

    public function destroy(Transaction $income)
    {
        abort_if($income->tenant_id !== auth()->user()->tenant_id || $income->type !== 'income', 403);

        // Revert income from account
        $account = $income->account;
        $account->current_balance -= $income->amount;
        $account->save();

        $income->delete();

        return redirect()->route('accounting.income.index')
            ->with('success', 'Income deleted successfully');
    }
}
