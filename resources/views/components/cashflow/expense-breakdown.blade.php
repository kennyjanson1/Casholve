{{-- resources/views/components/cashflow/expense-breakdown.blade.php --}}

@php
    use Carbon\Carbon;
    
    $currentYear = Carbon::now()->year;
    $startOfYear = Carbon::create($currentYear, 1, 1)->startOfDay();
    $endOfYear = Carbon::create($currentYear, 12, 31)->endOfDay();
    
    // Get expenses by category for this year
    $categoryExpenses = auth()->user()->transactions()
        ->where('type', 'expense')
        ->whereBetween('date', [$startOfYear, $endOfYear])
        ->with('category')
        ->get()
        ->groupBy('category_id')
        ->map(function($transactions) {
            $category = $transactions->first()->category;
            return [
                'category' => $category->name ?? 'Uncategorized',
                'amount' => $transactions->sum('amount'),
                'color' => $category->color ?? '#94a3b8',
            ];
        })
        ->sortByDesc('amount')
        ->values();
    
    $totalExpenses = $categoryExpenses->sum('amount');
    
    // Calculate percentages
    $categoryBreakdown = $categoryExpenses->map(function($item) use ($totalExpenses) {
        return [
            'category' => $item['category'],
            'amount' => $item['amount'],
            'percentage' => $totalExpenses > 0 ? round(($item['amount'] / $totalExpenses) * 100) : 0,
            'color' => $item['color'],
        ];
    })->toArray();
@endphp

<div class="border border-slate-200 dark:border-slate-700 shadow-lg rounded-2xl p-4 md:p-6 bg-white dark:bg-slate-900">
    <h3 class="text-lg md:text-xl text-slate-900 dark:text-slate-100 mb-6">Expense Breakdown by Category</h3>
    
    @if(count($categoryBreakdown) > 0)
        <div class="space-y-4">
            @foreach($categoryBreakdown as $item)
            <div>
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full" style="background-color: {{ $item['color'] }}"></div>
                        <span class="text-sm md:text-base text-slate-900 dark:text-slate-100">{{ $item['category'] }}</span>
                    </div>
                    <div class="flex items-center gap-2 md:gap-4">
                        <span class="text-sm md:text-base text-slate-600 dark:text-slate-400">
                            Rp {{ number_format($item['amount'], 0, ',', '.') }}
                        </span>
                        <span class="text-sm md:text-base text-slate-900 dark:text-slate-100 w-10 md:w-12 text-right">
                            {{ $item['percentage'] }}%
                        </span>
                    </div>
                </div>
                <div class="w-full bg-slate-100 dark:bg-slate-800 rounded-full h-2">
                    <div class="h-2 rounded-full transition-all duration-500" style="width: {{ $item['percentage'] }}%; background-color: {{ $item['color'] }}"></div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="flex flex-col items-center justify-center py-12 text-center">
            <svg class="w-16 h-16 text-slate-300 dark:text-slate-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            <p class="text-slate-600 dark:text-slate-400 text-base mb-2">No expenses recorded this year</p>
            <p class="text-slate-500 dark:text-slate-500 text-sm mb-4">Start tracking your expenses</p>
            <a href="{{ route('transactions.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg px-4 py-2 text-sm font-medium">
                Add Expense
            </a>
        </div>
    @endif
</div>