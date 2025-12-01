{{-- resources/views/components/goals/overview-cards.blade.php --}}

@php
    // Get active goals
    $activeGoals = auth()->user()->savingsPlans()
        ->where('status', 'active')
        ->get();
    
    // Get completed goals
    $completedGoals = auth()->user()->savingsPlans()
        ->where('status', 'completed')
        ->get();
    
    // Calculate totals
    $totalSaved = $activeGoals->sum('current_amount');
    $totalTarget = $activeGoals->sum('target_amount');
    $overallProgress = $totalTarget > 0 ? round(($totalSaved / $totalTarget) * 100) : 0;
@endphp

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
    <!-- Active Goals -->
    <div class="border border-slate-200 dark:border-slate-700 shadow-lg rounded-2xl p-4 md:p-6 bg-white dark:bg-slate-900">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <p class="text-sm md:text-base text-slate-600 dark:text-slate-400">Active Goals</p>
        </div>
        <p class="text-xl md:text-2xl text-slate-900 dark:text-slate-100">{{ $activeGoals->count() }} Goals</p>
    </div>

    <!-- Total Saved -->
    <div class="border border-slate-200 dark:border-slate-700 shadow-lg rounded-2xl p-4 md:p-6 bg-white dark:bg-slate-900">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-10 h-10 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <p class="text-sm md:text-base text-slate-600 dark:text-slate-400">Total Saved</p>
        </div>
        <p class="text-xl md:text-2xl text-slate-900 dark:text-slate-100">Rp {{ number_format($totalSaved, 0, ',', '.') }}</p>
    </div>

    <!-- Overall Progress -->
    <div class="border border-slate-200 dark:border-slate-700 shadow-lg rounded-2xl p-4 md:p-6 bg-white dark:bg-slate-900">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-10 h-10 bg-cyan-100 dark:bg-cyan-900/30 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-cyan-600 dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
            <p class="text-sm md:text-base text-slate-600 dark:text-slate-400">Overall Progress</p>
        </div>
        <p class="text-xl md:text-2xl text-slate-900 dark:text-slate-100">{{ $overallProgress }}%</p>
    </div>

    <!-- Completed Goals -->
    <div class="border border-slate-200 dark:border-slate-700 shadow-lg rounded-2xl p-4 md:p-6 bg-white dark:bg-slate-900">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            <p class="text-sm md:text-base text-slate-600 dark:text-slate-400">Completed</p>
        </div>
        <p class="text-xl md:text-2xl text-slate-900 dark:text-slate-100">{{ $completedGoals->count() }} Goals</p>
    </div>
</div>