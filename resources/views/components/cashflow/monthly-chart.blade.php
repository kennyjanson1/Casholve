{{-- resources/views/components/cashflow/monthly-chart.blade.php --}}

@php
    use Carbon\Carbon;
    
    $currentYear = Carbon::now()->year;
    $monthlyData = [];
    
    // Get data for each month
    for ($month = 1; $month <= 12; $month++) {
        $startOfMonth = Carbon::create($currentYear, $month, 1)->startOfDay();
        $endOfMonth = Carbon::create($currentYear, $month, 1)->endOfMonth()->endOfDay();
        
        $income = auth()->user()->transactions()
            ->where('type', 'income')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');
        
        $expense = auth()->user()->transactions()
            ->where('type', 'expense')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');
        
        $monthlyData[] = [
            'month' => $startOfMonth->format('M'),
            'income' => $income,
            'expense' => $expense,
            'net' => $income - $expense,
        ];
    }
@endphp

<div class="border border-slate-200 dark:border-slate-700 shadow-lg rounded-2xl p-4 md:p-6 bg-white dark:bg-slate-900">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <h3 class="text-lg md:text-xl text-slate-900 dark:text-slate-100">Monthly Cash Flow Analysis</h3>
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
            <div class="flex flex-wrap items-center gap-3 md:gap-4">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-indigo-600 rounded"></div>
                    <span class="text-xs md:text-sm text-slate-600 dark:text-slate-400">Income</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-cyan-400 rounded"></div>
                    <span class="text-xs md:text-sm text-slate-600 dark:text-slate-400">Expenses</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-emerald-500 rounded"></div>
                    <span class="text-xs md:text-sm text-slate-600 dark:text-slate-400">Net</span>
                </div>
            </div>
            <button class="border border-slate-200 dark:border-slate-700 rounded-lg px-3 py-1.5 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 flex items-center gap-1">
                {{ $currentYear }}
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
        </div>
    </div>

    <div class="h-64 md:h-80 lg:h-96">
        <canvas id="cashFlowChart"></canvas>
    </div>
</div>

@push('scripts')
<script>
    const monthlyData = @json($monthlyData);
    
    const cashFlowCtx = document.getElementById('cashFlowChart').getContext('2d');
    new Chart(cashFlowCtx, {
        type: 'bar',
        data: {
            labels: monthlyData.map(d => d.month),
            datasets: [
                {
                    label: 'Income',
                    data: monthlyData.map(d => d.income),
                    backgroundColor: '#6366f1',
                    borderRadius: 8,
                    borderSkipped: false,
                },
                {
                    label: 'Expenses',
                    data: monthlyData.map(d => d.expense),
                    backgroundColor: '#22d3ee',
                    borderRadius: 8,
                    borderSkipped: false,
                },
                {
                    label: 'Net Cash Flow',
                    data: monthlyData.map(d => d.net),
                    backgroundColor: '#10b981',
                    borderRadius: 8,
                    borderSkipped: false,
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
                            return context.dataset.label + ': Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#94a3b8'
                    }
                },
                y: {
                    grid: {
                        color: '#e2e8f0',
                        drawBorder: false
                    },
                    ticks: {
                        color: '#94a3b8',
                        callback: function(value) {
                            return 'Rp ' + (value / 1000).toFixed(0) + 'k';
                        }
                    }
                }
            }
        }
    });
</script>
@endpush