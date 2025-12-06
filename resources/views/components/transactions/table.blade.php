{{-- resources/views/components/transactions/table-header.blade.php --}}

<div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">
    <div>
        <h3 class="text-lg md:text-xl font-semibold text-slate-900 dark:text-slate-100">All Transactions</h3>
        @if(request()->hasAny(['search', 'type', 'category_id']))
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                Showing filtered results
                @if(request('search'))
                    <span class="inline-flex items-center gap-1">
                        • Search: "<span class="font-medium">{{ request('search') }}</span>"
                    </span>
                @endif
                @if(request('type'))
                    <span class="inline-flex items-center gap-1">
                        • Type: <span class="font-medium">{{ ucfirst(request('type')) }}</span>
                    </span>
                @endif
                @if(request('category_id'))
                    @php
                        $selectedCategory = $categories->firstWhere('id', request('category_id'));
                    @endphp
                    @if($selectedCategory)
                        <span class="inline-flex items-center gap-1">
                            • Category: <span class="font-medium">{{ $selectedCategory->icon }} {{ $selectedCategory->name }}</span>
                        </span>
                    @endif
                @endif
                <a href="{{ route('transactions.index') }}" class="ml-2 text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 text-xs">
                    Clear filters
                </a>
            </p>
        @endif
    </div>

    <div class="flex flex-wrap items-center gap-2">
        <!-- Search Input -->
        <form method="GET" action="{{ route('transactions.index') }}" class="w-full sm:w-64" id="searchForm">
            <!-- Preserve other filters -->
            @if(request('type'))
                <input type="hidden" name="type" value="{{ request('type') }}">
            @endif
            @if(request('category_id'))
                <input type="hidden" name="category_id" value="{{ request('category_id') }}">
            @endif
            
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="search" name="search" value="{{ request('search') }}"
                    placeholder="Search transactions..."
                    class="pl-10 w-full rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                
                @if(request('search'))
                    <button type="button" onclick="document.querySelector('input[name=search]').value=''; document.getElementById('searchForm').submit();"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                @endif
            </div>
        </form>

        <!-- Type Filter -->
        <form method="GET" action="{{ route('transactions.index') }}" class="inline" id="typeFilterForm">
            <!-- Preserve other filters -->
            @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif
            @if(request('category_id'))
                <input type="hidden" name="category_id" value="{{ request('category_id') }}">
            @endif
            
            <select name="type"
                class="rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                onchange="this.form.submit()">
                <option value="">All Types</option>
                <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>Income</option>
                <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>Expense</option>
            </select>
        </form>

        <!-- Category Filter with Custom Dropdown -->
        <form method="GET" action="{{ route('transactions.index') }}" class="inline" id="categoryFilterForm">
            <!-- Preserve other filters -->
            @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif
            @if(request('type'))
                <input type="hidden" name="type" value="{{ request('type') }}">
            @endif
            
            <input type="hidden" name="category_id" id="categoryIdInput" value="{{ request('category_id') }}">
            
            <div class="relative inline-block" id="categoryDropdown">
                <button type="button" 
                    class="rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 flex items-center gap-2 min-w-[160px] justify-between"
                    onclick="toggleCategoryDropdown()">
                    <span id="selectedCategoryText">
                        @if(request('category_id'))
                            @php
                                $selectedCat = $categories->firstWhere('id', request('category_id'));
                            @endphp
                            {{ $selectedCat ? $selectedCat->icon . ' ' . $selectedCat->name : 'All Categories' }}
                        @else
                            All Categories
                        @endif
                    </span>
                    <svg class="w-4 h-4 transition-transform" id="categoryDropdownArrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                
                <div id="categoryDropdownMenu" 
                    class="hidden absolute top-full left-0 mt-1 w-full min-w-[200px] bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg shadow-lg z-50 max-h-[240px] overflow-y-auto">
                    <div class="py-1">
                        <button type="button" 
                            onclick="selectCategory('', 'All Categories')"
                            class="w-full text-left px-4 py-2 text-sm text-slate-900 dark:text-slate-100 hover:bg-slate-100 dark:hover:bg-slate-700 {{ !request('category_id') ? 'bg-indigo-50 dark:bg-indigo-900/30' : '' }}">
                            All Categories
                        </button>
                        @foreach ($categories as $category)
                            <button type="button" 
                                onclick="selectCategory('{{ $category->id }}', '{{ $category->icon }} {{ $category->name }}')"
                                class="w-full text-left px-4 py-2 text-sm text-slate-900 dark:text-slate-100 hover:bg-slate-100 dark:hover:bg-slate-700 {{ request('category_id') == $category->id ? 'bg-indigo-50 dark:bg-indigo-900/30' : '' }}">
                                {{ $category->icon }} {{ $category->name }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </form>
        
        <script>
            function toggleCategoryDropdown() {
                const menu = document.getElementById('categoryDropdownMenu');
                const arrow = document.getElementById('categoryDropdownArrow');
                
                if (menu.classList.contains('hidden')) {
                    menu.classList.remove('hidden');
                    arrow.style.transform = 'rotate(180deg)';
                } else {
                    menu.classList.add('hidden');
                    arrow.style.transform = 'rotate(0deg)';
                }
            }
            
            function selectCategory(categoryId, categoryText) {
                document.getElementById('categoryIdInput').value = categoryId;
                document.getElementById('selectedCategoryText').textContent = categoryText;
                document.getElementById('categoryFilterForm').submit();
            }
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                const dropdown = document.getElementById('categoryDropdown');
                const menu = document.getElementById('categoryDropdownMenu');
                const arrow = document.getElementById('categoryDropdownArrow');
                
                if (dropdown && !dropdown.contains(event.target)) {
                    menu.classList.add('hidden');
                    arrow.style.transform = 'rotate(0deg)';
                }
            });
        </script>

        <!-- Add Transaction Button -->
        <a href="{{ route('transactions.create') }}"
            class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg px-4 py-2 text-sm font-medium flex items-center gap-2 transition">
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
                    <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                        Description
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider hidden md:table-cell">
                        Category
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider hidden lg:table-cell">
                        Date
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider hidden xl:table-cell">
                        Type
                    </th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                        Amount
                    </th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider hidden sm:table-cell">
                        Action
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                @forelse ($transactions as $transaction)
                    @include('components.transactions.table-row')
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center">
                            <svg class="w-16 h-16 mx-auto text-slate-300 dark:text-slate-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                            <p class="text-slate-500 dark:text-slate-400 text-base mb-2">
                                @if(request()->hasAny(['search', 'type', 'category_id']))
                                    No transactions found matching your filters
                                @else
                                    No transactions yet
                                @endif
                            </p>
                            <p class="text-slate-400 dark:text-slate-500 text-sm mb-4">
                                @if(request()->hasAny(['search', 'type', 'category_id']))
                                    Try adjusting your search or filter criteria
                                @else
                                    Start by adding your first transaction
                                @endif
                            </p>
                            @if(request()->hasAny(['search', 'type', 'category_id']))
                                <a href="{{ route('transactions.index') }}" 
                                   class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 text-sm font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Clear all filters
                                </a>
                            @else
                                <a href="{{ route('transactions.create') }}" 
                                   class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg px-4 py-2 text-sm font-medium transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Add Transaction
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    @if($transactions->hasPages())
        <div class="px-4 py-4 border-t border-slate-200 dark:border-slate-700">
            {{ $transactions->links() }}
        </div>
    @endif
</div>