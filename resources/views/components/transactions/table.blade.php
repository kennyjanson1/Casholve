{{-- resources/views/components/transactions/table-header.blade.php --}}


<div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">
    <h3 class="text-lg md:text-xl text-slate-900 dark:text-slate-100">All Transactions</h3>

    <div class="flex flex-wrap items-center gap-2">
        <!-- Search Input -->
        <form method="GET" action="{{ route('transactions.index') }}" class="w-full sm:w-64">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="search" name="search" value="{{ request('search') }}"
                    placeholder="Search transactions..."
                    class="pl-10 w-full rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            </div>
        </form>

        <!-- Type Filter -->
        <form method="GET" action="{{ route('transactions.index') }}" class="inline" id="typeFilterForm">
            <input type="hidden" name="search" value="{{ request('search') }}">
            <input type="hidden" name="category_id" value="{{ request('category_id') }}">
            <select name="type"
                class="rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                onchange="this.form.submit()">
                <option value="">All Types</option>
                <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>Income</option>
                <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>Expense</option>
            </select>
        </form>

        <!-- Category Filter -->
        <form method="GET" action="{{ route('transactions.index') }}" class="inline" id="categoryFilterForm">
            <input type="hidden" name="search" value="{{ request('search') }}">
            <input type="hidden" name="type" value="{{ request('type') }}">
            <select name="category_id"
                class="rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                onchange="this.form.submit()">
                <option value="">All Categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->icon }} {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </form>

        <!-- Export Button -->
        <a href="#"
            class="hidden sm:flex border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
            </svg>
            Export
        </a>

        <!-- Add Transaction Button -->
        <a href="{{ route('transactions.create') }}"
            class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg px-4 py-2 text-sm font-medium flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <span class="hidden sm:inline">Add Transaction</span>
            <span class="sm:hidden">Add</span>
        </a>
    </div>
</div>

<!-- TABLE DATA -->
<div class="bg-white dark:bg-slate-900 rounded-xl shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50 dark:bg-slate-800">
                <tr>
                    <th class="px-6 py-3 text-left">Date</th>
                    <th class="px-6 py-3 text-left">Title</th>
                    <th class="px-6 py-3 text-left">Category</th>
                    <th class="px-6 py-3 text-left">Type</th>
                    <th class="px-6 py-3 text-right">Amount</th>
                    <th class="px-6 py-3 text-right">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($transactions as $transaction)
                    {{-- INI INTINYA --}}
                    @include('components.transactions.table-row')

                @empty
                    <tr>
                        <td colspan="6" class="text-center px-6 py-8 text-slate-500">
                            No transactions found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    <div class="p-4">
        {{ $transactions->links() }}
    </div>
</div>
