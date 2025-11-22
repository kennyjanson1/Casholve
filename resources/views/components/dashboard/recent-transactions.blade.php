@php
    $transactions = [
        ['id' => 1, 'merchant' => 'Icloud Monthly', 'icon' => '☁️', 'category' => 'Premium', 'categoryIcon' => '🏷️', 'date' => '08 Des 2024', 'amount' => -1000.00, 'status' => 'Pending'],
        ['id' => 2, 'merchant' => 'Shopping', 'icon' => '🛍️', 'category' => 'Shopping', 'categoryIcon' => '🛒', 'date' => '07 Des 2024', 'amount' => -1000.00, 'status' => 'Complete'],
        ['id' => 3, 'merchant' => 'Design Logo', 'icon' => '💼', 'category' => 'Freelance', 'categoryIcon' => '💻', 'date' => '06 Des 2024', 'amount' => 2000.00, 'status' => 'Complete'],
        ['id' => 4, 'merchant' => 'Grocry', 'icon' => '🛒', 'category' => 'Eat', 'categoryIcon' => '🍽️', 'date' => '05 Des 2024', 'amount' => -2000.00, 'status' => 'Complete'],
    ];
@endphp

<div class="border border-slate-200 dark:border-slate-700 shadow-lg rounded-2xl p-6 bg-white dark:bg-slate-900">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-medium text-slate-900 dark:text-slate-100">Recent Transaction</h3>
        <div class="flex items-center gap-2">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="search" placeholder="Search" class="pl-10 w-48 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <button class="border border-slate-200 dark:border-slate-700 rounded-lg p-2 hover:bg-slate-50 dark:hover:bg-slate-800">
                <svg class="w-4 h-4 text-slate-600 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                </svg>
            </button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-slate-200 dark:border-slate-700">
                    <th class="text-left py-3 px-4 text-sm font-medium text-slate-600 dark:text-slate-400">Merchant Name</th>
                    <th class="text-left py-3 px-4 text-sm font-medium text-slate-600 dark:text-slate-400">Category</th>
                    <th class="text-left py-3 px-4 text-sm font-medium text-slate-600 dark:text-slate-400">Date</th>
                    <th class="text-right py-3 px-4 text-sm font-medium text-slate-600 dark:text-slate-400">Amount</th>
                    <th class="text-right py-3 px-4 text-sm font-medium text-slate-600 dark:text-slate-400">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                <tr class="border-b border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800">
                    <td class="py-3 px-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 flex items-center justify-center text-xl">{{ $transaction['icon'] }}</div>
                            <span class="text-sm font-medium text-slate-900 dark:text-slate-100">{{ $transaction['merchant'] }}</span>
                        </div>
                    </td>
                    <td class="py-3 px-4">
                        <div class="flex items-center gap-2">
                            <span class="text-lg">{{ $transaction['categoryIcon'] }}</span>
                            <span class="text-sm text-slate-600 dark:text-slate-400">{{ $transaction['category'] }}</span>
                        </div>
                    </td>
                    <td class="py-3 px-4 text-sm text-slate-600 dark:text-slate-400">{{ $transaction['date'] }}</td>
                    <td class="py-3 px-4 text-right text-sm font-medium {{ $transaction['amount'] > 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                        {{ $transaction['amount'] > 0 ? '+' : '-' }}${{ number_format(abs($transaction['amount']), 2) }}
                    </td>
                    <td class="py-3 px-4 text-right">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $transaction['status'] === 'Complete' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400' }}">
                            {{ $transaction['status'] }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
