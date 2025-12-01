{{-- resources/views/components/goals/completed-goals.blade.php --}}

@php
    use Carbon\Carbon;
    
    $completedGoals = auth()->user()->savingsPlans()
        ->where('status', 'completed')
        ->orderBy('updated_at', 'desc')
        ->get();
@endphp

<div class="border border-slate-200 dark:border-slate-700 shadow-lg rounded-2xl p-4 md:p-6 bg-white dark:bg-slate-900">
    <h3 class="text-lg md:text-xl text-slate-900 dark:text-slate-100 mb-6">Completed Goals</h3>
    
    @if($completedGoals->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($completedGoals as $goal)
            <div class="bg-slate-50 dark:bg-slate-800 rounded-xl p-4 border border-slate-200 dark:border-slate-700">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center text-xl flex-shrink-0">
                        🎯
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-sm md:text-base text-slate-900 dark:text-slate-100 truncate">{{ $goal->title }}</h4>
                        <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400">
                            {{ Carbon::parse($goal->updated_at)->format('M Y') }}
                        </p>
                    </div>
                </div>
                <div class="pt-3 border-t border-slate-200 dark:border-slate-700">
                    <p class="text-xs md:text-sm text-slate-600 dark:text-slate-400 mb-1">Amount Saved</p>
                    <p class="text-base md:text-lg text-emerald-600 dark:text-emerald-400">
                        Rp {{ number_format($goal->current_amount, 0, ',', '.') }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="flex flex-col items-center justify-center py-12 text-center">
            <svg class="w-16 h-16 text-slate-300 dark:text-slate-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
            </svg>
            <p class="text-slate-600 dark:text-slate-400 text-base mb-2">No completed goals yet</p>
            <p class="text-slate-500 dark:text-slate-500 text-sm">Keep working towards your active goals!</p>
        </div>
    @endif
</div>