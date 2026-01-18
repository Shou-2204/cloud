<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <x-google-analytics />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles

    {{-- Script Anti-Flash (S'exécute avant le chargement du body) --}}
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body class="font-sans antialiased" x-data="{ 
            theme: localStorage.getItem('theme') || 'system',
            sidebarOpen: false, /* Mobile sidebar state */
            sidebarCollapsed: localStorage.getItem('sidebarCollapsed') === 'true', /* Desktop collapse state */
            init() {
                // Apply initial theme
                this.applyTheme(this.theme);

                // Watch for changes
                this.$watch('theme', val => this.applyTheme(val));
                this.$watch('sidebarCollapsed', val => localStorage.setItem('sidebarCollapsed', val));

                // Listen for system preference changes
                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                    if (this.theme === 'system') {
                        this.applyTheme('system');
                    }
                });
            },
            applyTheme(val) {
                if (val === 'system') {
                    localStorage.removeItem('theme');
                    if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                } else {
                    localStorage.setItem('theme', val);
                    if (val === 'dark') {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                }
            }
        }" x-init="init()">
    <x-banner />

    <div class="flex h-screen overflow-hidden bg-ivory dark:bg-emerald-dark">
        {{-- SIDEBAR --}}
        {{-- SIDEBAR --}}
        @auth
            <x-app-sidebar />
        @endauth

        {{-- MAIN CONTENT WRAPPER --}}
        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">
            {{-- TOPBAR (Navigation Menu) --}}
            @include('navigation-menu')

            {{-- MAIN PAGE CONTENT --}}
            <main class="flex-grow p-4 sm:p-6 lg:p-8">
                {{ $slot }}
            </main>

            {{-- FOOTER --}}
            <x-app-footer />
        </div>
    </div>

    @stack('modals')

    @livewireScripts
</body>

</html>