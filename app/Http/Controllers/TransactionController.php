<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TransactionController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = Transaction::where('user_id', auth()->user()->id)
            ->with('category');

        if ($request->has('type') && in_array($request->type, ['income', 'expense'])) {
            $query->where('type', $request->type);
        }

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->dateRange($request->start_date, $request->end_date);
        } elseif ($request->has('period')) {
            switch ($request->period) {
                case 'weekly':
                    $query->thisWeek();
                    break;
                case 'yearly':
                    $query->thisYear();
                    break;
                case 'monthly':
                default:
                    $query->thisMonth();
                    break;
            }
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $query->orderBy('date', 'desc')->orderBy('created_at', 'desc');

        $transactions = $query->paginate(15);
        $categories = Category::forUser(auth()->user()->id)->get();

        return view('transactions.index', compact('transactions', 'categories'));
    }

    public function create()
    {
        $categories = Category::forUser(auth()->user()->id)->get();
        return view('transactions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:income,expense',
            'date' => 'required|date',
        ]);

        $validated['user_id'] = auth()->user()->id;

        Transaction::create($validated);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction created successfully!');
    }

    public function show(Transaction $transaction)
    {
        $this->authorize('view', $transaction);
        
        $transaction->load('category');
        return view('transactions.show', compact('transaction'));
    }

    public function edit(Transaction $transaction)
    {
        $this->authorize('update', $transaction);
        
        $categories = Category::forUser(auth()->user()->id)->get();
        return view('transactions.edit', compact('transaction', 'categories'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $this->authorize('update', $transaction);

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:income,expense',
            'date' => 'required|date',
        ]);

        $transaction->update($validated);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction updated successfully!');
    }

    public function destroy(Transaction $transaction)
    {
        $this->authorize('delete', $transaction);

        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction deleted successfully!');
    }

    public function restore($id)
    {
        $transaction = Transaction::withTrashed()->findOrFail($id);
        
        $this->authorize('restore', $transaction);

        $transaction->restore();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction restored successfully!');
    }

    public function trash()
    {
        $transactions = Transaction::onlyTrashed()
            ->where('user_id', auth()->user()->id)
            ->with('category')
            ->orderBy('deleted_at', 'desc')
            ->paginate(15);

        return view('transactions.trash', compact('transactions'));
    }
}