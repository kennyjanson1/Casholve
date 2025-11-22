<!DOCTYPE html>
<html 
    lang="en"
    x-data
    x-bind:class="{ 'dark': $store.theme.dark }"
>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Moneta - Money Management Dashboard')</title>

    <!-- Tailwind CDN FIRST -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Then Tailwind Config -->
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        [x-cloak] { display: none !important; }
    </style>

    <!-- Alpine Theme Store -->
    <script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('theme', {
            dark: JSON.parse(localStorage.getItem('darkMode')) || false,

            toggle() {
                this.dark = !this.dark;
                localStorage.setItem('darkMode', JSON.stringify(this.dark));
            }
        });
    });

    // PRELOAD: apply dark mode before Alpine loads (eliminate flashing)
    if (localStorage.getItem('darkMode') === 'true') {
        document.documentElement.classList.add('dark');
    }
    </script>
</head>


<body 
    x-data="{ sidebarOpen: false }"
    class="bg-slate-100 dark:bg-slate-900"
>
    <div class="flex min-h-screen">

        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Mobile Overlay -->
        <div 
            x-show="sidebarOpen" 
            x-cloak
            @click="sidebarOpen = false"
            class="fixed inset-0 bg-black/50 z-40 lg:hidden"
        ></div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">

            <!-- Header -->
            @include('components.header')

            <!-- Page Content -->
            <main class="flex-1 p-6 lg:p-8 overflow-auto">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
