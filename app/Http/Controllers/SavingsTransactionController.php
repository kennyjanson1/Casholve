<?php

namespace App\Http\Controllers;

use App\Models\SavingsPlan;
use App\Models\SavingsTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SavingsTransactionController extends Controller
{
    use AuthorizesRequests;

    public function store(Request $request, SavingsPlan $savingsPlan)
    {
        $this->authorize('update', $savingsPlan);

        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:deposit,withdraw',
            'date' => 'required|date',
            'note' => 'nullable|string',
        ]);

        if ($validated['type'] === 'withdraw' && $validated['amount'] > $savingsPlan->current_amount) {
            return redirect()->back()
                ->with('error', 'Withdraw amount cannot exceed current savings amount.');
        }

        DB::transaction(function () use ($validated, $savingsPlan) {
            $savingsPlan->savingsTransactions()->create([
                'user_id' => auth()->user()->id,
                'amount' => $validated['amount'],
                'type' => $validated['type'],
                'date' => $validated['date'],
                'note' => $validated['note'],
            ]);

            $newAmount = $validated['type'] === 'deposit'
                ? $savingsPlan->current_amount + $validated['amount']
                : $savingsPlan->current_amount - $validated['amount'];

            $savingsPlan->update([
                'current_amount' => $newAmount
            ]);

            if ($newAmount >= $savingsPlan->target_amount) {
                $savingsPlan->update(['status' => 'completed']);
            }
        });

        return redirect()->route('savings.show', $savingsPlan)
            ->with('success', ucfirst($validated['type']) . ' recorded successfully!');
    }

    public function destroy(SavingsTransaction $savingsTransaction)
    {
        $savingsPlan = $savingsTransaction->savingsPlan;
        
        $this->authorize('update', $savingsPlan);

        DB::transaction(function () use ($savingsTransaction, $savingsPlan) {
            $newAmount = $savingsTransaction->type === 'deposit'
                ? $savingsPlan->current_amount - $savingsTransaction->amount
                : $savingsPlan->current_amount + $savingsTransaction->amount;

            $savingsPlan->update([
                'current_amount' => max(0, $newAmount)
            ]);

            $savingsTransaction->delete();

            if ($savingsPlan->status === 'completed' && $savingsPlan->current_amount < $savingsPlan->target_amount) {
                $savingsPlan->update(['status' => 'active']);
            }
        });

        return redirect()->route('savings.show', $savingsPlan)
            ->with('success', 'Transaction deleted successfully!');
    }
}