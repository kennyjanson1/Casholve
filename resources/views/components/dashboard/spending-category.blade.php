@php
    $categories = [
        ['name' => 'Eat', 'percentage' => 30, 'color' => '#6366f1'],
        ['name' => 'Shopping', 'percentage' => 20, 'color' => '#e2e8f0'],
        ['name' => 'Transport', 'percentage' => 20, 'color' => '#22d3ee'],
        ['name' => 'Subscription', 'percentage' => 15, 'color' => '#10b981'],
        ['name' => 'Cafe', 'percentage' => 10, 'color' => '#4f46e5'],
        ['name' => 'Utilities', 'percentage' => 5, 'color' => '#6366f1'],
    ];
@endphp

<div class="border border-slate-200 dark:border-slate-700 shadow-lg rounded-2xl p-6 bg-white dark:bg-slate-900 h-full">
    <div class="flex items-start justify-between mb-4">
        <h3 class="text-lg font-medium text-slate-900 dark:text-slate-100">Spending by Category</h3>
        <button class="border border-slate-200 dark:border-slate-700 rounded-lg px-3 py-1 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 flex items-center gap-1">
            This Month
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
    </div>

    <div class="text-3xl font-medium text-slate-900 dark:text-slate-100 mb-6">$15,000.00</div>

    <!-- Donut Chart Placeholder -->
    <div class="relative mb-6 flex items-center justify-center h-48">
        <canvas id="spendingChart"></canvas>
    </div>

    <!-- Legend -->
    <div class="grid grid-cols-2 gap-y-3 gap-x-6">
        @foreach($categories as $category)
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-3 h-3 rounded-sm" style="background-color: {{ $category['color'] }}"></div>
                <span class="text-sm text-slate-600 dark:text-slate-400">{{ $category['name'] }}</span>
            </div>
            <span class="text-sm font-medium text-slate-900 dark:text-slate-100">{{ $category['percentage'] }}%</span>
        </div>
        @endforeach
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('spendingChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: @json(array_column($categories, 'name')),
                datasets: [{
                    data: @json(array_column($categories, 'percentage')),
                    backgroundColor: @json(array_column($categories, 'color')),
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }
});
</script>
@endpush
