{{-- resources/views/components/cashflow/summary-cards.blade.php --}}

@php
    use Carbon\Carbon;
    
    $currentYear = Carbon::now()->year;
    $startOfYear = Carbon::create($currentYear, 1, 1)->startOfDay();
    $endOfYear = Carbon::create($currentYear, 12, 31)->endOfDay();
    
    // Current year stats
    $yearIncome = auth()->user()->transactions()
        ->where('type', 'income')
        ->whereBetween('date', [$startOfYear, $endOfYear])
        ->sum('amount');
    
    $yearExpenses = auth()->user()->transactions()
        ->where('type', 'expense')
        ->whereBetween('date', [$startOfYear, $endOfYear])
        ->sum('amount');
    
    $yearNet = $yearIncome - $yearExpenses;
    
    // Previous year for comparison
    $prevYear = $currentYear - 1;
    $prevStart = Carbon::create($prevYear, 1, 1)->startOfDay();
    $prevEnd = Carbon::create($prevYear, 12, 31)->endOfDay();
    
    $prevIncome = auth()->user()->transactions()
        ->where('type', 'income')
        ->whereBetween('date', [$prevStart, $prevEnd])
        ->sum('amount');
    
    $prevExpenses = auth()->user()->transactions()
        ->where('type', 'expense')
        ->whereBetween('date', [$prevStart, $prevEnd])
        ->sum('amount');
    
    $prevNet = $prevIncome - $prevExpenses;
    
    // Calculate percentage changes
    $incomeChange = $prevIncome > 0 
        ? (($yearIncome - $prevIncome) / $prevIncome) * 100 
        : 0;
    
    $expenseChange = $prevExpenses > 0 
        ? (($yearExpenses - $prevExpenses) / $prevExpenses) * 100 
        : 0;
    
    $netChange = $prevNet > 0 
        ? (($yearNet - $prevNet) / $prevNet) * 100 
        : 0;
@endphp

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
    <!-- Total Income -->
    <div class="border border-slate-200 dark:border-slate-700 shadow-lg rounded-2xl p-6 bg-gradient-to-br from-indigo-500 to-indigo-600">
        <div class="flex items-start justify-between mb-4">
            <div class="w-10 h-10 md:w-12 md:h-12 bg-white/20 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
            <span class="text-sm text-white/80">This Year</span>
        </div>
        <p class="text-sm text-white/80 mb-1">Total Income</p>
        <p class="text-2xl md:text-3xl text-white mb-2">Rp {{ number_format($yearIncome, 0, ',', '.') }}</p>
        <div class="flex items-center gap-1 text-sm text-white">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                @if($incomeChange >= 0)
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                @else
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                @endif
            </svg>
            <span>{{ $incomeChange >= 0 ? '+' : '' }}{{ number_format(abs($incomeChange), 1) }}%</span>
        </div>
    </div>

    <!-- Total Expenses -->
    <div class="border border-slate-200 dark:border-slate-700 shadow-lg rounded-2xl p-6 bg-gradient-to-br from-cyan-500 to-cyan-600">
        <div class="flex items-start justify-between mb-4">
            <div class="w-10 h-10 md:w-12 md:h-12 bg-white/20 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                </svg>
            </div>
            <span class="text-sm text-white/80">This Year</span>
        </div>
        <p class="text-sm text-white/80 mb-1">Total Expenses</p>
        <p class="text-2xl md:text-3xl text-white mb-2">Rp {{ number_format($yearExpenses, 0, ',', '.') }}</p>
        <div class="flex items-center gap-1 text-sm text-white">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                @if($expenseChange >= 0)
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                @else
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                @endif
            </svg>
            <span>{{ $expenseChange >= 0 ? '+' : '' }}{{ number_format(abs($expenseChange), 1) }}%</span>
        </div>
    </div>

    <!-- Net Cash Flow -->
    <div class="border border-slate-200 dark:border-slate-700 shadow-lg rounded-2xl p-6 bg-gradient-to-br from-emerald-500 to-emerald-600">
        <div class="flex items-start justify-between mb-4">
            <div class="w-10 h-10 md:w-12 md:h-12 bg-white/20 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <span class="text-sm text-white/80">This Year</span>
        </div>
        <p class="text-sm text-white/80 mb-1">Net Cash Flow</p>
        <p class="text-2xl md:text-3xl text-white mb-2">Rp {{ number_format($yearNet, 0, ',', '.') }}</p>
        <div class="flex items-center gap-1 text-sm text-white">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                @if($netChange >= 0)
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                @else
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                @endif
            </svg>
            <span>{{ $netChange >= 0 ? '+' : '' }}{{ number_format(abs($netChange), 1) }}%</span>
        </div>
    </div>
</div>