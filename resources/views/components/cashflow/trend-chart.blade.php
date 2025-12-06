{{-- resources/views/components/cashflow/trend-chart.blade.php --}}

@php
    use Carbon\Carbon;
@endphp

<div class="border border-slate-200 dark:border-slate-700 shadow-lg rounded-2xl p-4 md:p-6 bg-white dark:bg-slate-900">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <h3 class="text-lg md:text-xl font-semibold text-slate-900 dark:text-slate-100">Cash Flow Chart</h3>
        
        <!-- Period Filter Dropdown -->
        <div class="relative">
            <select id="periodFilter" 
                class="border border-slate-200 dark:border-slate-700 rounded-lg px-3 py-1.5 text-sm font-medium text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="weekly">Last 7 Days</option>
                <option value="monthly" selected>Last 12 Months</option>
                <option value="yearly">Last 5 Years</option>
            </select>
        </div>
    </div>

    <div class="h-64 md:h-80">
        <canvas id="trendChart"></canvas>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.getElementById('trendChart');
            const periodFilter = document.getElementById('periodFilter');
            
            if (!canvas) {
                console.error('Canvas element not found');
                return;
            }
            
            let chartInstance = null;
            
            // Check if dark mode is enabled
            const isDarkMode = document.documentElement.classList.contains('dark');
            const gridColor = isDarkMode ? 'rgba(71, 85, 105, 0.3)' : 'rgba(226, 232, 240, 0.8)';
            const textColor = isDarkMode ? '#94a3b8' : '#64748b';
            
            // Fetch data based on period
            async function fetchData(period) {
                try {
                    const response = await fetch(`/cashflow/data?period=${period}`, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                        }
                    });
                    
                    if (!response.ok) {
                        throw new Error('Failed to fetch data');
                    }
                    
                    const data = await response.json();
                    return data;
                } catch (error) {
                    console.error('Error fetching data:', error);
                    // Fallback to generate sample data
                    return generateSampleData(period);
                }
            }
            
            // Generate sample data (fallback)
            function generateSampleData(period) {
                const data = [];
                let count, format;
                
                if (period === 'weekly') {
                    count = 7;
                    format = 'ddd'; // Mon, Tue, Wed
                    for (let i = count - 1; i >= 0; i--) {
                        const date = new Date();
                        date.setDate(date.getDate() - i);
                        data.push({
                            label: date.toLocaleDateString('en-US', { weekday: 'short' }),
                            income: Math.random() * 500000 + 100000,
                            expense: Math.random() * 400000 + 50000
                        });
                    }
                } else if (period === 'monthly') {
                    count = 12;
                    for (let i = count - 1; i >= 0; i--) {
                        const date = new Date();
                        date.setMonth(date.getMonth() - i);
                        data.push({
                            label: date.toLocaleDateString('en-US', { month: 'short' }),
                            income: Math.random() * 2000000 + 500000,
                            expense: Math.random() * 1500000 + 300000
                        });
                    }
                } else { // yearly
                    count = 5;
                    for (let i = count - 1; i >= 0; i--) {
                        const year = new Date().getFullYear() - i;
                        data.push({
                            label: year.toString(),
                            income: Math.random() * 20000000 + 10000000,
                            expense: Math.random() * 15000000 + 8000000
                        });
                    }
                }
                
                return data;
            }
            
            // Render chart
            function renderChart(data) {
                const ctx = canvas.getContext('2d');
                
                // Destroy existing chart
                if (chartInstance) {
                    chartInstance.destroy();
                }
                
                chartInstance = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.map(d => d.label),
                        datasets: [
                            {
                                label: 'Income',
                                data: data.map(d => d.income),
                                borderColor: '#10b981',
                                backgroundColor: isDarkMode ? 'rgba(16, 185, 129, 0.15)' : 'rgba(16, 185, 129, 0.1)',
                                fill: true,
                                tension: 0.4,
                                borderWidth: 3,
                                pointRadius: 0,
                                pointHoverRadius: 6,
                                pointHoverBackgroundColor: '#10b981',
                                pointHoverBorderColor: '#fff',
                                pointHoverBorderWidth: 2,
                            },
                            {
                                label: 'Expense',
                                data: data.map(d => d.expense),
                                borderColor: '#ef4444',
                                backgroundColor: isDarkMode ? 'rgba(239, 68, 68, 0.15)' : 'rgba(239, 68, 68, 0.1)',
                                fill: true,
                                tension: 0.4,
                                borderWidth: 3,
                                pointRadius: 0,
                                pointHoverRadius: 6,
                                pointHoverBackgroundColor: '#ef4444',
                                pointHoverBorderColor: '#fff',
                                pointHoverBorderWidth: 2,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            mode: 'index',
                            intersect: false,
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                                align: 'end',
                                labels: {
                                    color: textColor,
                                    usePointStyle: true,
                                    pointStyle: 'circle',
                                    padding: 15,
                                    font: {
                                        size: 12,
                                        weight: '500'
                                    },
                                    boxWidth: 8,
                                    boxHeight: 8
                                }
                            },
                            tooltip: {
                                backgroundColor: isDarkMode ? 'rgba(15, 23, 42, 0.95)' : 'rgba(255, 255, 255, 0.95)',
                                titleColor: isDarkMode ? '#e2e8f0' : '#1e293b',
                                bodyColor: isDarkMode ? '#cbd5e1' : '#475569',
                                borderColor: isDarkMode ? 'rgba(71, 85, 105, 0.5)' : 'rgba(226, 232, 240, 1)',
                                borderWidth: 1,
                                padding: 12,
                                displayColors: true,
                                callbacks: {
                                    title: function(context) {
                                        return context[0].label;
                                    },
                                    label: function(context) {
                                        const label = context.dataset.label || '';
                                        const value = context.parsed.y;
                                        let formattedValue;
                                        
                                        if (value >= 1000000) {
                                            formattedValue = 'Rp ' + (value / 1000000).toFixed(1) + 'M';
                                        } else if (value >= 1000) {
                                            formattedValue = 'Rp ' + (value / 1000).toFixed(0) + 'K';
                                        } else {
                                            formattedValue = 'Rp ' + value.toLocaleString('id-ID');
                                        }
                                        
                                        return label + ': ' + formattedValue;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: true,
                                    color: gridColor,
                                    drawBorder: false,
                                    lineWidth: 1,
                                    borderDash: [5, 5]
                                },
                                border: {
                                    display: false
                                },
                                ticks: {
                                    color: textColor,
                                    font: {
                                        size: 11,
                                        weight: '500'
                                    },
                                    padding: 8
                                }
                            },
                            y: {
                                grid: {
                                    display: true,
                                    color: gridColor,
                                    drawBorder: false,
                                    lineWidth: 1,
                                    borderDash: [5, 5]
                                },
                                border: {
                                    display: false
                                },
                                ticks: {
                                    color: textColor,
                                    font: {
                                        size: 11,
                                        weight: '500'
                                    },
                                    padding: 8,
                                    callback: function(value) {
                                        if (value >= 1000000) {
                                            return 'Rp ' + (value / 1000000).toFixed(0) + 'M';
                                        } else if (value >= 1000) {
                                            return 'Rp ' + (value / 1000).toFixed(0) + 'K';
                                        }
                                        return 'Rp ' + value;
                                    }
                                }
                            }
                        }
                    }
                });
            }
            
            // Period filter change event
            periodFilter.addEventListener('change', async function() {
                const period = this.value;
                const data = await fetchData(period);
                renderChart(data);
            });
            
            // Initial render with monthly data
            fetchData('monthly').then(data => renderChart(data));
        });
    </script>
@endpush