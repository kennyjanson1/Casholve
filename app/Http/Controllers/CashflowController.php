<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class CashflowController extends Controller
{
    public function getData(Request $request)
    {
        $period = $request->get('period', 'monthly');
        $userId = auth()->id();
        
        $data = [];
        
        switch ($period) {
            case 'weekly':
                $data = $this->getWeeklyData($userId);
                break;
            case 'yearly':
                $data = $this->getYearlyData($userId);
                break;
            case 'monthly':
            default:
                $data = $this->getMonthlyData($userId);
                break;
        }
        
        return response()->json($data);
    }
    
    private function getWeeklyData($userId)
    {
        $data = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $startOfDay = $date->copy()->startOfDay();
            $endOfDay = $date->copy()->endOfDay();
            
            $income = \App\Models\Transaction::where('user_id', $userId)
                ->where('type', 'income')
                ->whereBetween('date', [$startOfDay, $endOfDay])
                ->sum('amount');
            
            $expense = \App\Models\Transaction::where('user_id', $userId)
                ->where('type', 'expense')
                ->whereBetween('date', [$startOfDay, $endOfDay])
                ->sum('amount');
            
            $data[] = [
                'label' => $date->format('D'), // Mon, Tue, Wed
                'income' => (float) $income,
                'expense' => (float) $expense,
            ];
        }
        
        return $data;
    }
    
    private function getMonthlyData($userId)
    {
        $data = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $startOfMonth = $date->copy()->startOfMonth();
            $endOfMonth = $date->copy()->endOfMonth();
            
            $income = \App\Models\Transaction::where('user_id', $userId)
                ->where('type', 'income')
                ->whereBetween('date', [$startOfMonth, $endOfMonth])
                ->sum('amount');
            
            $expense = \App\Models\Transaction::where('user_id', $userId)
                ->where('type', 'expense')
                ->whereBetween('date', [$startOfMonth, $endOfMonth])
                ->sum('amount');
            
            $data[] = [
                'label' => $date->format('M'), // Jan, Feb, Mar
                'income' => (float) $income,
                'expense' => (float) $expense,
            ];
        }
        
        return $data;
    }
    
    private function getYearlyData($userId)
    {
        $data = [];
        
        for ($i = 4; $i >= 0; $i--) {
            $year = Carbon::now()->subYears($i)->year;
            $startOfYear = Carbon::create($year, 1, 1)->startOfDay();
            $endOfYear = Carbon::create($year, 12, 31)->endOfDay();
            
            $income = \App\Models\Transaction::where('user_id', $userId)
                ->where('type', 'income')
                ->whereBetween('date', [$startOfYear, $endOfYear])
                ->sum('amount');
            
            $expense = \App\Models\Transaction::where('user_id', $userId)
                ->where('type', 'expense')
                ->whereBetween('date', [$startOfYear, $endOfYear])
                ->sum('amount');
            
            $data[] = [
                'label' => (string) $year, // 2020, 2021, 2022
                'income' => (float) $income,
                'expense' => (float) $expense,
            ];
        }
        
        return $data;
    }
}