@php
    $pageInfo = [
        'dashboard' => ['title' => 'Dashboard', 'description' => 'Track and Analyze Your Financial Performance'],
        'account' => ['title' => 'Account', 'description' => 'Manage Your Profile and Account Settings'],
        'transaction' => ['title' => 'Transaction', 'description' => 'View and Manage All Your Transactions'],
        'cashflow' => ['title' => 'Cash Flow', 'description' => 'Monitor Your Income and Expense Trends'],
        'goals' => ['title' => 'Goals', 'description' => 'Track Your Savings Goals and Progress'],
    ];
    
    $currentRoute = request()->route()->getName();
    $currentPage = $pageInfo[$currentRoute] ?? $pageInfo['dashboard'];
@endphp

<header class="bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-700 px-6 lg:px-8 py-4">
    <div class="flex items-center justify-between gap-6">
        <!-- Left: Menu & Title -->
        <div class="flex items-center gap-4">
            <button 
                @click="sidebarOpen = true"
                class="lg:hidden p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800"
            >
                <svg class="w-5 h-5 text-slate-600 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            <div>
                <h1 class="text-2xl font-medium text-slate-900 dark:text-slate-100">{{ $currentPage['title'] }}</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">{{ $currentPage['description'] }}</p>
            </div>
        </div>
        
        <!-- Right: Actions -->
        <div class="flex items-center gap-3">
            <!-- Theme Toggle -->
            <button 
                @click="$store.theme.toggle()"
                class="p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800"
            >
                <!-- Light icon (show when dark mode is OFF) -->
                <svg x-show="!$store.theme.dark" class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                </svg>

                <!-- Dark icon (show when dark mode is ON) -->
                <svg x-show="$store.theme.dark" x-cloak class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </button>
            
            <!-- Notifications -->
            <button class="relative p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800">
                <svg class="w-5 h-5 text-slate-600 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>
            
            <!-- User Profile Dropdown -->
            <div class="flex items-center gap-3 pl-3 border-l border-slate-200 dark:border-slate-700">
                <!-- User Avatar -->
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                
                <!-- User Info (Hidden on mobile) -->
                <div class="hidden md:block">
                    <p class="text-sm font-medium text-slate-900 dark:text-slate-100">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400">{{ Auth::user()->email }}</p>
                </div>
            </div>
        </div>
    </div>
</header>