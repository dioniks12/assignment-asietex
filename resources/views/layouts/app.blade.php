<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Textile Inventory') }}</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Anti-FOUC script for Theme Toggle -->
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        .dark ::-webkit-scrollbar-track {
            background: #0f172a;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        .dark ::-webkit-scrollbar-thumb {
            background: #334155;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        .dark ::-webkit-scrollbar-thumb:hover {
            background: #475569;
        }
    </style>

    <!-- Vite Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full antialiased selection:bg-indigo-500 selection:text-white bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 transition-colors duration-200">

    <div class="min-h-full flex flex-col">
        @auth
            <!-- Authenticated App Shell -->
            <div class="flex flex-1 flex-col lg:flex-row min-h-screen">
                
                <!-- Sidebar -->
                <aside class="w-full lg:w-64 bg-slate-100 dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 flex flex-col shrink-0 transition-colors duration-200">
                    <!-- Brand Logo -->
                    <div class="h-16 flex items-center px-6 border-b border-slate-200 dark:border-slate-800 bg-slate-200/50 dark:bg-slate-950">
                        <span class="text-xl font-extrabold tracking-tight bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 dark:from-indigo-400 dark:via-purple-400 dark:to-pink-400 bg-clip-text text-transparent">
                            Asietex Textile
                        </span>
                    </div>

                    <!-- User Brief Info -->
                    <div class="p-4 border-b border-slate-200 dark:border-slate-800 bg-slate-150/40 dark:bg-slate-900/50">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-500 to-purple-600 flex items-center justify-center font-bold text-white shadow-lg shadow-indigo-500/20">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-slate-800 dark:text-slate-200">{{ auth()->user()->name }}</h4>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ auth()->user()->role === 'manajer' ? 'bg-purple-500/10 text-purple-600 dark:text-purple-400 border border-purple-500/20' : 'bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-500/20' }}">
                                    {{ auth()->user()->role === 'manajer' ? __('Manager') : __('Warehouse Admin') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Links -->
                    <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
                        <a href="{{ route('dashboard') }}" 
                           class="flex items-center px-4 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-100' }}">
                            <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            {{ __('Dashboard') }}
                        </a>

                        <div class="pt-4 pb-2">
                            <span class="px-4 text-xs font-semibold tracking-wider text-slate-400 dark:text-slate-500 uppercase">{{ __('Data Master') }}</span>
                        </div>

                        <a href="{{ route('categories.index') }}" 
                           class="flex items-center px-4 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('categories.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-100' }}">
                            <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                            </svg>
                            {{ __('Material Categories') }}
                        </a>

                        <a href="{{ route('suppliers.index') }}" 
                           class="flex items-center px-4 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('suppliers.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-100' }}">
                            <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            {{ __('Suppliers') }}
                        </a>

                        <a href="{{ route('products.index') }}" 
                           class="flex items-center px-4 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('products.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-100' }}">
                            <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            {{ __('Raw Material Products') }}
                        </a>

                        <div class="pt-4 pb-2">
                            <span class="px-4 text-xs font-semibold tracking-wider text-slate-400 dark:text-slate-500 uppercase">{{ __('Transactions') }}</span>
                        </div>

                        <a href="{{ route('transactions.index') }}" 
                           class="flex items-center px-4 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('transactions.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-100' }}">
                            <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                            </svg>
                            {{ __('Stock Mutation Logs') }}
                        </a>
                    </nav>

                    <!-- Logout Button -->
                    <div class="p-4 border-t border-slate-200 dark:border-slate-800 bg-slate-200/20 dark:bg-slate-950">
                        <form method="POST" action="{{ route('logout') }}" data-confirm="{{ __('Are you sure you want to log out of the system?') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center justify-center px-4 py-2.5 text-sm font-medium text-rose-600 dark:text-rose-400 bg-rose-500/10 hover:bg-rose-500/20 border border-rose-200 dark:border-rose-500/20 rounded-xl transition-all duration-200 cursor-pointer">
                                <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                {{ __('Logout') }}
                            </button>
                        </form>
                    </div>
                </aside>

                <!-- Main Content Area -->
                <main class="flex-1 flex flex-col min-w-0 bg-slate-50 dark:bg-slate-950 transition-colors duration-200">
                    <!-- Top Bar -->
                    <header class="h-16 bg-slate-100 dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between px-6 lg:px-8 transition-colors duration-200">
                        <div class="flex items-center lg:hidden">
                            <span class="text-lg font-bold text-slate-800 dark:text-white">Asietex Textile</span>
                        </div>
                        <div class="hidden lg:flex items-center">
                            <h2 class="text-lg font-bold text-slate-800 dark:text-slate-100">@yield('page_title', 'Dashboard')</h2>
                        </div>
                        
                        <!-- Header Utilities (Real-time Clock, Language Switcher & Dark Mode Toggle) -->
                        <div class="flex items-center space-x-3">
                            <!-- Language Switcher Button -->
                            <a href="{{ app()->getLocale() === 'id' ? route('lang.switch', 'en') : route('lang.switch', 'id') }}" 
                               class="inline-flex items-center space-x-1.5 px-3.5 py-2 text-xs font-semibold text-slate-600 dark:text-slate-400 bg-slate-200/50 dark:bg-slate-950 border border-slate-300/60 dark:border-slate-800 rounded-xl hover:bg-slate-200/80 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-150 transition duration-200 cursor-pointer shadow-sm"
                               title="{{ app()->getLocale() === 'id' ? 'Switch to English' : 'Ubah ke Bahasa Indonesia' }}">
                                <span>🌐</span>
                                <span>{{ app()->getLocale() === 'id' ? 'EN' : 'ID' }}</span>
                            </a>

                            <span id="live-clock" class="text-xs text-slate-600 dark:text-slate-400 font-semibold bg-slate-200/50 dark:bg-slate-950 border border-slate-300/60 dark:border-slate-800 px-3.5 py-2 rounded-xl transition duration-200">
                                {{ now()->format('d-m H:i') }}
                            </span>
                            
                            <button id="theme-toggle" class="p-2 text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 bg-slate-200/50 dark:bg-slate-950 border border-slate-300/60 dark:border-slate-800 rounded-xl transition duration-200 cursor-pointer" aria-label="{{ __('Ganti Tema') }}">
                                <!-- Moon Icon (visible in light mode) -->
                                <svg id="theme-toggle-dark-icon" class="hidden h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                                </svg>
                                <!-- Sun Icon (visible in dark mode) -->
                                <svg id="theme-toggle-light-icon" class="hidden h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M14 12a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </button>
                        </div>
                    </header>

                    <!-- Page Content Wrapper -->
                    <div class="flex-1 p-6 lg:p-8 overflow-y-auto">
                        <!-- Flash Status Notification -->
                        @if(session('success'))
                            <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl flex items-center space-x-3 text-emerald-600 dark:text-emerald-400 shadow-md">
                                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-sm font-medium">{{ session('success') }}</span>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="mb-6 p-4 bg-rose-500/10 border border-rose-500/20 rounded-2xl flex items-center space-x-3 text-rose-600 dark:text-rose-400 shadow-md">
                                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                <span class="text-sm font-medium">{{ session('error') }}</span>
                            </div>
                        @endif

                        @yield('content')
                    </div>
                </main>
            </div>
        @else
            <!-- Guest / Centered Page -->
            <div class="flex-1 flex flex-col justify-center py-12 sm:px-6 lg:px-8 bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-900 dark:to-slate-950 relative overflow-hidden transition-colors duration-200 min-h-screen">
                <!-- Background visual grids -->
                <div class="absolute inset-0 bg-[linear-gradient(to_right,#cbd5e1_1px,transparent_1px),linear-gradient(to_bottom,#cbd5e1_1px,transparent_1px)] dark:bg-[linear-gradient(to_right,#0f172a_1px,transparent_1px),linear-gradient(to_bottom,#0f172a_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_50%,#000_70%,transparent_100%)] opacity-30"></div>
                
                <div class="relative z-10">
                    <!-- Guest Header Utilities -->
                    <div class="absolute top-4 right-4 flex items-center space-x-3">
                        <button id="theme-toggle" class="p-2 text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl transition duration-200 cursor-pointer" aria-label="Ganti Tema">
                            <svg id="theme-toggle-dark-icon" class="hidden h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                            </svg>
                            <svg id="theme-toggle-light-icon" class="hidden h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M14 12a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </button>
                    </div>

                    @yield('content')
                </div>
            </div>
        @endauth
    </div>

    <!-- Theme Toggle Logic Script -->
    <script>
        const themeToggleBtn = document.getElementById('theme-toggle');
        const darkIcon = document.getElementById('theme-toggle-dark-icon');
        const lightIcon = document.getElementById('theme-toggle-light-icon');

        function updateThemeToggleUI() {
            if (document.documentElement.classList.contains('dark')) {
                lightIcon.classList.remove('hidden');
                darkIcon.classList.add('hidden');
            } else {
                darkIcon.classList.remove('hidden');
                lightIcon.classList.add('hidden');
            }
        }

        // Initial setup
        updateThemeToggleUI();

        if (themeToggleBtn) {
            themeToggleBtn.addEventListener('click', function() {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                }
                updateThemeToggleUI();
            });
        }
    </script>

    <!-- Real-time Clock Logic Script -->
    @auth
    <script>
        function updateClock() {
            const clockEl = document.getElementById('live-clock');
            if (!clockEl) return;
            const now = new Date();
            const dd = String(now.getDate()).padStart(2, '0');
            const mm = String(now.getMonth() + 1).padStart(2, '0');
            const hh = String(now.getHours()).padStart(2, '0');
            const mi = String(now.getMinutes()).padStart(2, '0');
            clockEl.textContent = dd + '-' + mm + ' ' + hh + ':' + mi;
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
    @endauth

    <!-- SweetAlert2 CRUD Notifications and Deletion Confirmation -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const isDark = document.documentElement.classList.contains('dark');
            const swalBg = isDark ? '#0f172a' : '#ffffff';
            const swalColor = isDark ? '#f1f5f9' : '#0f172a';

            // SweetAlert Form Submission Confirmation
            document.querySelectorAll('form[data-confirm]').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const message = this.getAttribute('data-confirm');
                    
                    // Determine if this is a deletion form (danger/rose color)
                    const isDelete = this.classList.contains('delete-form') || 
                                     this.action.includes('/destroy') || 
                                     this.querySelector('input[name="_method"]')?.value === 'DELETE';
                    const confirmColor = isDelete ? '#ef4444' : '#4f46e5';
                    const confirmText = isDelete ? "{{ __('Delete') }}" : "{{ __('Yes, Proceed!') }}";
                    const title = isDelete ? "{{ __('Confirm Delete') }}" : "{{ __('Confirm Action') }}";
                    const icon = isDelete ? 'warning' : 'question';

                    Swal.fire({
                        title: title,
                        text: message,
                        icon: icon,
                        showCancelButton: true,
                        confirmButtonColor: confirmColor,
                        cancelButtonColor: '#64748b',
                        confirmButtonText: confirmText,
                        cancelButtonText: "{{ __('Cancel') }}",
                        background: swalBg,
                        color: swalColor
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    });
                });
            });

            // SweetAlert Success Flash Messages
            @if(session('success'))
                Swal.fire({
                    title: "{{ __('Success!') }}",
                    text: "{{ session('success') }}",
                    icon: 'success',
                    confirmButtonColor: '#4f46e5',
                    background: swalBg,
                    color: swalColor
                });
            @endif

            // SweetAlert Error Flash Messages
            @if(session('error'))
                Swal.fire({
                    title: "{{ __('Error!') }}",
                    text: "{{ session('error') }}",
                    icon: 'error',
                    confirmButtonColor: '#ef4444',
                    background: swalBg,
                    color: swalColor
                });
            @endif

            // Lazy Loading tables
            document.querySelectorAll('table[data-lazy-load="true"]').forEach(table => {
                const tbody = table.querySelector('tbody');
                if (!tbody) return;
                
                const rows = Array.from(tbody.querySelectorAll('tr'));
                const chunkSize = parseInt(table.getAttribute('data-lazy-chunk')) || 5;
                let visibleCount = chunkSize;
                
                // Hide all rows initially except the first chunk
                rows.forEach((row, idx) => {
                    if (idx >= visibleCount) {
                        row.style.display = 'none';
                    }
                });
                
                // Find parent overflow container of table or fallback to window
                let scrollContainer = window;
                let parent = table.parentElement;
                while (parent) {
                    const style = window.getComputedStyle(parent);
                    if (style.overflowY === 'auto' || style.overflowY === 'scroll') {
                        scrollContainer = parent;
                        break;
                    }
                    parent = parent.parentElement;
                }

                // Create loader indicator if there are more rows than the first chunk
                if (rows.length > chunkSize) {
                    const wrapper = table.parentElement;
                    const loader = document.createElement('div');
                    loader.className = 'py-4 text-center text-xs text-slate-500 font-semibold flex items-center justify-center space-x-2 border-t border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/30';
                    loader.innerHTML = `
                        <svg class="animate-spin h-4 w-4 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>{{ __('Loading more items...') }}</span>
                    `;
                    wrapper.appendChild(loader);

                    const updateLoader = () => {
                        if (visibleCount >= rows.length) {
                            loader.style.display = 'none';
                        } else {
                            loader.style.display = 'flex';
                        }
                    };

                    updateLoader();

                    let isDelaying = false;
                    const loadMore = () => {
                        if (visibleCount >= rows.length || isDelaying) return;

                        let scrollHeight, scrollTop, clientHeight;
                        if (scrollContainer === window) {
                            scrollHeight = document.documentElement.scrollHeight;
                            scrollTop = window.scrollY || document.documentElement.scrollTop;
                            clientHeight = window.innerHeight;
                        } else {
                            scrollHeight = scrollContainer.scrollHeight;
                            scrollTop = scrollContainer.scrollTop;
                            clientHeight = scrollContainer.clientHeight;
                        }

                        // Trigger when within 40px of bottom
                        if (scrollHeight - scrollTop - clientHeight < 40) {
                            isDelaying = true;
                            loader.querySelector('span').textContent = "{{ __('Loading...') }}";
                            setTimeout(() => {
                                const nextCount = visibleCount + chunkSize;
                                rows.forEach((row, idx) => {
                                    if (idx >= visibleCount && idx < nextCount) {
                                        row.style.display = '';
                                    }
                                });
                                visibleCount = nextCount;
                                updateLoader();
                                loader.querySelector('span').textContent = "{{ __('Loading more items...') }}";
                                isDelaying = false;
                            }, 400); // 400ms delay for simulation
                        }
                    };

                    scrollContainer.addEventListener('scroll', loadMore);
                }
            });
        });
    </script>

</body>
</html>
