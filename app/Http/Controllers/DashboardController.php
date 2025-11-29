<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\SavingsPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $period = $request->get('period', 'monthly');

        $dateRange = $this->getDateRange($period);
        
        $totalIncome = Transaction::where('user_id', $user->id)
            ->where('type', 'income')
            ->dateRange($dateRange['start'], $dateRange['end'])
            ->sum('amount');

        $totalExpense = Transaction::where('user_id', $user->id)
            ->where('type', 'expense')
            ->dateRange($dateRange['start'], $dateRange['end'])
            ->sum('amount');

        $currentBalance = $user->current_balance;

        $chartData = $this->getChartData($user->id, $period);

        $expenseByCategory = Transaction::where('user_id', $user->id)
            ->where('type', 'expense')
            ->dateRange($dateRange['start'], $dateRange['end'])
            ->select('category_id', DB::raw('SUM(amount) as total'))
            ->with('category')
            ->groupBy('category_id')
            ->orderBy('total', 'desc')
            ->get();

        $recentTransactions = Transaction::where('user_id', $user->id)
            ->with('category')
            ->recent(10)
            ->get();

        $savingsSummary = [
            'total_target' => SavingsPlan::where('user_id', $user->id)
                ->where('status', 'active')
                ->sum('target_amount'),
            'total_saved' => SavingsPlan::where('user_id', $user->id)
                ->where('status', 'active')
                ->sum('current_amount'),
            'active_plans' => SavingsPlan::where('user_id', $user->id)
                ->where('status', 'active')
                ->count(),
        ];

        return view('dashboard', compact(
            'totalIncome',
            'totalExpense',
            'currentBalance',
            'chartData',
            'expenseByCategory',
            'recentTransactions',
            'savingsSummary',
            'period'
        ));
    }

    private function getDateRange($period)
    {
        switch ($period) {
            case 'weekly':
                return [
                    'start' => now()->startOfWeek(),
                    'end' => now()->endOfWeek()
                ];
            case 'yearly':
                return [
                    'start' => now()->startOfYear(),
                    'end' => now()->endOfYear()
                ];
            case 'monthly':
            default:
                return [
                    'start' => now()->startOfMonth(),
                    'end' => now()->endOfMonth()
                ];
        }
    }

    private function getChartData($userId, $period)
    {
        if ($period === 'weekly') {
            $days = collect(range(6, 0))->map(function ($day) use ($userId) {
                $date = now()->subDays($day)->format('Y-m-d');
                return [
                    'label' => now()->subDays($day)->format('D'),
                    'income' => Transaction::where('user_id', $userId)
                        ->where('type', 'income')
                        ->whereDate('date', $date)
                        ->sum('amount'),
                    'expense' => Transaction::where('user_id', $userId)
                        ->where('type', 'expense')
                        ->whereDate('date', $date)
                        ->sum('amount'),
                ];
            });
            
            return [
                'labels' => $days->pluck('label'),
                'income' => $days->pluck('income'),
                'expense' => $days->pluck('expense'),
            ];
        }

        if ($period === 'yearly') {
            $months = collect(range(11, 0))->map(function ($month) use ($userId) {
                $date = now()->subMonths($month);
                return [
                    'label' => $date->format('M'),
                    'income' => Transaction::where('user_id', $userId)
                        ->where('type', 'income')
                        ->whereYear('date', $date->year)
                        ->whereMonth('date', $date->month)
                        ->sum('amount'),
                    'expense' => Transaction::where('user_id', $userId)
                        ->where('type', 'expense')
                        ->whereYear('date', $date->year)
                        ->whereMonth('date', $date->month)
                        ->sum('amount'),
                ];
            });

            return [
                'labels' => $months->pluck('label'),
                'income' => $months->pluck('income'),
                'expense' => $months->pluck('expense'),
            ];
        }

        $weeks = collect(range(3, 0))->map(function ($week) use ($userId) {
            $start = now()->subWeeks($week)->startOfWeek();
            $end = now()->subWeeks($week)->endOfWeek();
            
            return [
                'label' => 'Week ' . (4 - $week),
                'income' => Transaction::where('user_id', $userId)
                    ->where('type', 'income')
                    ->whereBetween('date', [$start, $end])
                    ->sum('amount'),
                'expense' => Transaction::where('user_id', $userId)
                    ->where('type', 'expense')
                    ->whereBetween('date', [$start, $end])
                    ->sum('amount'),
            ];
        });

        return [
            'labels' => $weeks->pluck('label'),
            'income' => $weeks->pluck('income'),
            'expense' => $weeks->pluck('expense'),
        ];
    }
}