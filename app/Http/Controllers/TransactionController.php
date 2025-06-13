<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Account;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('account')
            ->where('tenant_id', auth()->user()->tenant_id)
            ->latest()
            ->paginate(20);

        $income = Transaction::where('tenant_id', auth()->user()->tenant_id)
            ->where('type', 'income')
            ->sum('amount');

        $expenses = Transaction::where('tenant_id', auth()->user()->tenant_id)
            ->where('type', 'expense')
            ->sum('amount');

        return view('admin.transactions.index', compact('transactions', 'income', 'expenses'));
    }

    public function create()
    {
        $accounts = Account::where('tenant_id', auth()->user()->tenant_id)
            ->where('is_active', true)
            ->get();

        return view('admin.transactions.create', compact('accounts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'type' => 'required|in:income,expense,transfer',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'reference' => 'nullable|string|max:255',
        ]);

        $transaction = Transaction::create([
            'tenant_id' => auth()->user()->tenant_id,
            'user_id' => auth()->id(),
            'account_id' => $validated['account_id'],
            'type' => $validated['type'],
            'amount' => $validated['amount'],
            'date' => $validated['date'],
            'category' => $validated['category'],
            'description' => $validated['description'],
            'reference' => $validated['reference'],
        ]);

        // Update account balance
        $account = Account::find($validated['account_id']);
        if ($validated['type'] === 'income') {
            $account->current_balance += $validated['amount'];
        } elseif ($validated['type'] === 'expense') {
            $account->current_balance -= $validated['amount'];
        }
        $account->save();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction created successfully');
    }

    public function show(Transaction $transaction)
    {
        abort_if($transaction->tenant_id !== auth()->user()->tenant_id, 403);

        return view('admin.transactions.show', compact('transaction'));
    }

    public function edit(Transaction $transaction)
    {
        abort_if($transaction->tenant_id !== auth()->user()->tenant_id, 403);

        $accounts = Account::where('tenant_id', auth()->user()->tenant_id)
            ->where('is_active', true)
            ->get();

        return view('admin.transactions.edit', compact('transaction', 'accounts'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        abort_if($transaction->tenant_id !== auth()->user()->tenant_id, 403);

        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'type' => 'required|in:income,expense,transfer',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'reference' => 'nullable|string|max:255',
        ]);

        // Revert old transaction amount from account
        $oldAccount = $transaction->account;
        if ($transaction->type === 'income') {
            $oldAccount->current_balance -= $transaction->amount;
        } elseif ($transaction->type === 'expense') {
            $oldAccount->current_balance += $transaction->amount;
        }
        $oldAccount->save();

        // Update transaction
        $transaction->update($validated);

        // Apply new transaction amount to account
        $newAccount = Account::find($validated['account_id']);
        if ($validated['type'] === 'income') {
            $newAccount->current_balance += $validated['amount'];
        } elseif ($validated['type'] === 'expense') {
            $newAccount->current_balance -= $validated['amount'];
        }
        $newAccount->save();

        return redirect()->route('admin.transactions.index')
            ->with('success', 'Transaction updated successfully');
    }

    public function destroy(Transaction $transaction)
    {
        abort_if($transaction->tenant_id !== auth()->user()->tenant_id, 403);

        // Revert transaction from account
        $account = $transaction->account;
        if ($transaction->type === 'income') {
            $account->current_balance -= $transaction->amount;
        } elseif ($transaction->type === 'expense') {
            $account->current_balance += $transaction->amount;
        }
        $account->save();

        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction deleted successfully');
    }
}
