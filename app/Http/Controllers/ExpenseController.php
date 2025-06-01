<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Account;
use App\Models\Branch;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::with(['category', 'account', 'branch', 'user'])
            ->where('tenant_id', auth()->user()->tenant_id)
            ->latest()
            ->paginate(20);

        $totalExpenses = Expense::where('tenant_id', auth()->user()->tenant_id)
            ->sum('amount');

        return view('admin.expense.index', compact('expenses', 'totalExpenses'));
    }

    public function create()
    {
        $categories = ExpenseCategory::where('tenant_id', auth()->user()->tenant_id)->get();
        $accounts = Account::where('tenant_id', auth()->user()->tenant_id)
            ->where('is_active', true)
            ->get();
        $branches = Branch::where('tenant_id', auth()->user()->tenant_id)->get();

        return view('admin.expense.create', compact('categories', 'accounts', 'branches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'expense_category_id' => 'required|exists:expense_categories,id',
            'account_id' => 'required|exists:accounts,id',
            'branch_id' => 'required|exists:branches,id',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'description' => 'nullable|string',
            'reference' => 'nullable|string|max:255',
        ]);

        $expense = Expense::create([
            'tenant_id' => auth()->user()->tenant_id,
            'user_id' => auth()->id(),
            'expense_category_id' => $validated['expense_category_id'],
            'account_id' => $validated['account_id'],
            'branch_id' => $validated['branch_id'],
            'amount' => $validated['amount'],
            'date' => $validated['date'],
            'description' => $validated['description'],
            'reference' => $validated['reference'],
        ]);

        // Deduct from account balance
        $account = Account::find($validated['account_id']);
        $account->current_balance -= $validated['amount'];
        $account->save();

        // Create transaction record
        Transaction::create([
            'tenant_id' => auth()->user()->tenant_id,
            'user_id' => auth()->id(),
            'account_id' => $validated['account_id'],
            'type' => 'expense',
            'amount' => $validated['amount'],
            'date' => $validated['date'],
            'category' => $expense->category->name,
            'description' => $validated['description'],
            'reference' => $validated['reference'],
        ]);

        return redirect()->route('expenses.index')
            ->with('success', 'Expense recorded successfully');
    }

    public function show(Expense $expense)
    {
        abort_if($expense->tenant_id !== auth()->user()->tenant_id, 403);

        return view('admin.expense.show', compact('expense'));
    }

    public function edit(Expense $expense)
    {
        abort_if($expense->tenant_id !== auth()->user()->tenant_id, 403);

        $categories = ExpenseCategory::where('tenant_id', auth()->user()->tenant_id)->get();
        $accounts = Account::where('tenant_id', auth()->user()->tenant_id)
            ->where('is_active', true)
            ->get();
        $branches = Branch::where('tenant_id', auth()->user()->tenant_id)->get();

        return view('admin.expense.create', compact('expense', 'categories', 'accounts', 'branches'));
    }

    public function update(Request $request, Expense $expense)
    {
        abort_if($expense->tenant_id !== auth()->user()->tenant_id, 403);

        $validated = $request->validate([
            'expense_category_id' => 'required|exists:expense_categories,id',
            'account_id' => 'required|exists:accounts,id',
            'branch_id' => 'required|exists:branches,id',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'description' => 'nullable|string',
            'reference' => 'nullable|string|max:255',
        ]);

        // Revert old expense amount from account
        $oldAccount = $expense->account;
        $oldAccount->current_balance += $expense->amount;
        $oldAccount->save();

        // Update expense
        $expense->update($validated);

        // Deduct new expense amount from account
        $newAccount = Account::find($validated['account_id']);
        $newAccount->current_balance -= $validated['amount'];
        $newAccount->save();

        // Update transaction record if exists
        $transaction = Transaction::where('reference', $expense->reference)
            ->where('type', 'expense')
            ->first();

        if ($transaction) {
            $transaction->update([
                'account_id' => $validated['account_id'],
                'amount' => $validated['amount'],
                'date' => $validated['date'],
                'category' => $expense->category->name,
                'description' => $validated['description'],
            ]);
        }

        return redirect()->route('expenses.index')
            ->with('success', 'Expense updated successfully');
    }

    public function destroy(Expense $expense)
    {
        abort_if($expense->tenant_id !== auth()->user()->tenant_id, 403);

        // Revert expense from account
        $account = $expense->account;
        $account->current_balance += $expense->amount;
        $account->save();

        // Delete transaction record if exists
        Transaction::where('reference', $expense->reference)
            ->where('type', 'expense')
            ->delete();

        $expense->delete();

        return redirect()->route('expenses.index')
            ->with('success', 'Expense deleted successfully');
    }

    public function categories()
    {
        $categories = ExpenseCategory::where('tenant_id', auth()->user()->tenant_id)
            ->latest()
            ->paginate(20);

        return view('admin.expense.categories', compact('categories'));
    }

    public function expenseCategoryStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Add tenant_id separately
        $validated['tenant_id'] = auth()->user()->tenant_id;

        try {
            $category = ExpenseCategory::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Category added successfully.',
                'data' => $category
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add category.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function expenseCategoryUpdate(Request $request, ExpenseCategory $expenseCategory)
    {
        // Authorization check - ensure user can update this category
        if ($expenseCategory->tenant_id !== auth()->user()->tenant_id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action.'
            ], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        try {
            $expenseCategory->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Category updated successfully.',
                'data' => $expenseCategory
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update category.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
