@php
    $cashFlowData = [
        ['month' => 'Jan', 'income' => 300, 'expense' => 100],
        ['month' => 'Feb', 'income' => 350, 'expense' => 150],
        ['month' => 'Mar', 'income' => 280, 'expense' => 120],
        ['month' => 'Apr', 'income' => 320, 'expense' => 140],
        ['month' => 'May', 'income' => 380, 'expense' => 160],
        ['month' => 'Jun', 'income' => 450, 'expense' => 200],
        ['month' => 'Jul', 'income' => 0, 'expense' => 0],
        ['month' => 'Aug', 'income' => 0, 'expense' => 0],
        ['month' => 'Sep', 'income' => 350, 'expense' => 150],
        ['month' => 'Oct', 'income' => 400, 'expense' => 180],
        ['month' => 'Nov', 'income' => 420, 'expense' => 200],
        ['month' => 'Dec', 'income' => 380, 'expense' => 320],
    ];
@endphp

<div class="border border-slate-200 dark:border-slate-700 shadow-lg rounded-2xl p-6 bg-white dark:bg-slate-900">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-medium text-slate-900 dark:text-slate-100">Cash Flow</h3>
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-indigo-600 rounded"></div>
                    <span class="text-sm text-slate-600 dark:text-slate-400">Income</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-cyan-400 rounded"></div>
                    <span class="text-sm text-slate-600 dark:text-slate-400">Expends</span>
                </div>
            </div>
            <button class="border border-slate-200 dark:border-slate-700 rounded-lg px-3 py-1 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 flex items-center gap-1">
                This Year
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
        </div>
    </div>

    <div class="flex items-center gap-8 mb-6">
        <div class="flex items-center gap-2">
            <span class="text-xl font-medium text-slate-900 dark:text-slate-100">$324,435</span>
            <span class="text-green-500 flex items-center gap-1 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
                8.3%
            </span>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-xl font-medium text-slate-900 dark:text-slate-100">$243,234</span>
            <span class="text-red-500 flex items-center gap-1 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                </svg>
                2.3%
            </span>
        </div>
    </div>

    <div class="h-72">
        <canvas id="cashFlowChart"></canvas>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('cashFlowChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json(array_column($cashFlowData, 'month')),
                datasets: [
                    {
                        label: 'Income',
                        data: @json(array_column($cashFlowData, 'income')),
                        backgroundColor: '#6366f1',
                        borderRadius: 8
                    },
                    {
                        label: 'Expense',
                        data: @json(array_column($cashFlowData, 'expense')),
                        backgroundColor: '#22d3ee',
                        borderRadius: 8
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#e2e8f0'
                        },
                        ticks: {
                            callback: function(value) {
                                return '$' + value;
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }
});
</script>
@endpush
