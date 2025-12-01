{{-- resources/views/components/goals/active-goals.blade.php --}}

@php
    $savingsPlans = auth()->user()->savingsPlans()
        ->where('status', 'active')
        ->orderBy('deadline', 'asc')
        ->get();
@endphp

<div class="border border-slate-200 dark:border-slate-700 shadow-lg rounded-2xl p-4 md:p-6 bg-white dark:bg-slate-900">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <h3 class="text-lg md:text-xl text-slate-900 dark:text-slate-100">Active Savings Goals</h3>
        <a href="{{ route('goals.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg px-4 py-2 text-sm font-medium flex items-center gap-2 w-fit">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Create New Goal
        </a>
    </div>

    @if($savingsPlans->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            @foreach($savingsPlans as $goal)
                @include('components.goals.goal-card', ['goal' => $goal])
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="flex flex-col items-center justify-center py-12 text-center">
            <svg class="w-16 h-16 text-slate-300 dark:text-slate-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-slate-600 dark:text-slate-400 text-base mb-2">No active goals yet</p>
            <p class="text-slate-500 dark:text-slate-500 text-sm mb-4">Start saving for your dreams today</p>
            <a href="{{ route('goals.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg px-4 py-2 text-sm font-medium">
                Create Your First Goal
            </a>
        </div>
    @endif
</div>