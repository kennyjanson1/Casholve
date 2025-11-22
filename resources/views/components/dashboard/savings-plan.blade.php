@php
    $savingsPlans = [
        ['id' => 1, 'name' => 'Financial Saving', 'icon' => '📊', 'iconBg' => 'bg-emerald-100 dark:bg-emerald-900/30', 'current' => 8000, 'goal' => 20000, 'percentage' => 50],
        ['id' => 2, 'name' => 'Educational Plan', 'icon' => '📚', 'iconBg' => 'bg-indigo-100 dark:bg-indigo-900/30', 'current' => 8000, 'goal' => 20000, 'percentage' => 32],
        ['id' => 3, 'name' => 'Retirement Plan', 'icon' => '🏖️', 'iconBg' => 'bg-amber-100 dark:bg-amber-900/30', 'current' => 8000, 'goal' => 20000, 'percentage' => 9],
    ];
@endphp

<div class="border border-slate-200 dark:border-slate-700 shadow-lg rounded-2xl p-6 bg-white dark:bg-slate-900 h-full">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-medium text-slate-900 dark:text-slate-100">My Savings Plan</h3>
        <button class="p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800">
            <svg class="w-5 h-5 text-slate-600 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path>
            </svg>
        </button>
    </div>

    <div class="text-3xl font-medium text-slate-900 dark:text-slate-100 mb-6">$24,000.00</div>

    <div class="space-y-4">
        @foreach($savingsPlans as $plan)
        <div class="bg-slate-50 dark:bg-slate-800 rounded-xl p-4">
            <div class="flex items-start justify-between mb-3">
                <div class="flex items-center gap-3">
                    <div class="{{ $plan['iconBg'] }} w-10 h-10 rounded-lg flex items-center justify-center text-xl">
                        {{ $plan['icon'] }}
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-900 dark:text-slate-100">{{ $plan['name'] }}</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            ${{ number_format($plan['current']) }}/${{ number_format($plan['goal']) }}
                        </p>
                    </div>
                </div>
                <span class="text-sm font-medium text-slate-900 dark:text-slate-100">{{ $plan['percentage'] }}%</span>
            </div>
            <div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-2">
                <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ $plan['percentage'] }}%"></div>
            </div>
        </div>
        @endforeach
    </div>
</div>
