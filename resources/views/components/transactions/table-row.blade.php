{{-- resources/views/components/transactions/table-row.blade.php --}}

<tr class="border-b border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 cursor-pointer"
    onclick="window.location='{{ route('transactions.show', $transaction->id) }}'">
    
    <!-- Title -->
    <td class="px-4 py-4">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 md:w-10 md:h-10 bg-slate-100 dark:bg-slate-800 rounded-lg flex items-center justify-center text-lg md:text-xl flex-shrink-0">
                {{ $transaction->category->icon ?? '📝' }}
            </div>
            <div>
                <span class="text-sm md:text-base text-slate-900 dark:text-slate-100 block">
                    {{ $transaction->title }}
                </span>
                <span class="text-xs text-slate-600 dark:text-slate-400 md:hidden">
                    {{ $transaction->category->name ?? 'Uncategorized' }}
                </span>
            </div>
        </div>
    </td>
    
    <!-- Category -->
    <td class="px-4 py-4 hidden md:table-cell">
        <div class="flex items-center gap-2">
            <span class="text-lg">{{ $transaction->category->icon ?? '📝' }}</span>
            <span class="text-sm text-slate-600 dark:text-slate-400">
                {{ $transaction->category->name ?? 'Uncategorized' }}
            </span>
        </div>
    </td>
    
    <!-- Date & Time -->
    <td class="px-4 py-4 hidden lg:table-cell">
        <div>
            <p class="text-sm text-slate-900 dark:text-slate-100">
                {{ $transaction->date->format('d M Y') }}
            </p>
            <p class="text-xs text-slate-500 dark:text-slate-400">
                {{ $transaction->created_at->format('h:i A') }}
            </p>
        </div>
    </td>
    
    <!-- Type -->
    <td class="px-4 py-4 hidden xl:table-cell">
        <span class="inline-block px-2 py-1 rounded-md text-xs {{ $transaction->type === 'income' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' }}">
            {{ ucfirst($transaction->type) }}
        </span>
    </td>
    
    <!-- Amount -->
    <td class="px-4 py-4 text-right">
        <span class="text-sm md:text-base font-medium {{ $transaction->type === 'income' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
            {{ $transaction->type === 'income' ? '+' : '-' }}Rp {{ number_format($transaction->amount, 0, ',', '.') }}
        </span>
    </td>
    
    <!-- Actions -->
    <td class="px-4 py-4 text-right hidden sm:table-cell">
        <div class="flex items-center justify-end gap-2" onclick="event.stopPropagation()">
            <a href="{{ route('transactions.edit', $transaction->id) }}" 
               class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300"
               title="Edit">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
            </a>
            <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" class="inline"
                  onsubmit="return confirm('Are you sure you want to delete this transaction?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300" title="Delete">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </form>
        </div>
    </td>
</tr>