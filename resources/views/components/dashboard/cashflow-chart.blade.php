<div class="border border-slate-200 dark:border-slate-700 shadow-lg rounded-2xl p-6 bg-white dark:bg-slate-900">

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-medium text-slate-900 dark:text-slate-100">
            Monthly Cash Flow
        </h3>

        <button
            class="border border-slate-200 dark:border-slate-700 rounded-lg px-3 py-1 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 flex items-center gap-1">
            This Year
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
    </div>

    <!-- Legends -->
    <div class="flex items-center gap-6 mb-6">
        <div class="flex items-center gap-2">
            <div class="w-3 h-3 bg-indigo-600 rounded"></div>
            <span class="text-sm text-slate-600 dark:text-slate-400">Income</span>
        </div>

        <div class="flex items-center gap-2">
            <div class="w-3 h-3 bg-cyan-400 rounded"></div>
            <span class="text-sm text-slate-600 dark:text-slate-400">Expenses</span>
        </div>
    </div>

    <!-- Chart -->
    <div class="h-72">
        <canvas id="cashFlowChart"></canvas>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const ctx = document.getElementById('cashFlowChart');
            if (!ctx) return;

            const labels = @json($months ?? []);
            const income = @json($monthlyIncome ?? []);
            const expenses = @json($monthlyExpenses ?? []);

            if (labels.length === 0) {
                console.warn("Cash Flow chart: No data available");
                return;
            }

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels,
                    datasets: [{
                            label: 'Income',
                            data: income,
                            backgroundColor: '#6366f1',
                            borderRadius: 6,
                            barThickness: 20
                        },
                        {
                            label: 'Expenses',
                            data: expenses,
                            backgroundColor: '#22d3ee',
                            borderRadius: 6,
                            barThickness: 20
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Rp ' + context.raw.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: value => 'Rp ' + value.toLocaleString('id-ID')
                            },
                            grid: {
                                color: 'rgba(148,163,184,0.15)'
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

        });
    </script>
@endpush
