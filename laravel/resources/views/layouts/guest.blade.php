<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $seoTitle = $seo['title'] ?? config('app.name', 'Laravel');
        $seoDescription = $seo['description'] ?? config('app.name') . ' - Growth Tools for Modern Businesses';
        $seoUrl = url()->current();

        $breadcrumbsData = null;
        if (isset($seo['breadcrumbs'])) {
            $items = [];
            foreach ($seo['breadcrumbs'] as $index => $crumb) {
                $items[] = [
                    "@type" => "ListItem",
                    "position" => $index + 1,
                    "name" => $crumb['name'],
                    "item" => $crumb['url']
                ];
            }
            $breadcrumbsData = [
                "@context" => "https://schema.org",
                "@type" => "BreadcrumbList",
                "itemListElement" => $items
            ];
        }
    @endphp

    <title>{{ $seoTitle }}</title>
    <meta name="description" content="{{ $seoDescription }}">
    <link rel="canonical" href="{{ $seoUrl }}">

    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $seoUrl }}">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDescription }}">

    {{-- Twitter --}}
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ $seoUrl }}">
    <meta property="twitter:title" content="{{ $seoTitle }}">
    <meta property="twitter:description" content="{{ $seoDescription }}">

    {{-- Structured Data (JSON-LD) --}}
    {{-- Structured Data (JSON-LD) --}}
    @if($breadcrumbsData)
        <script type="application/ld+json">
                                                    {!! json_encode($breadcrumbsData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
                                                </script>
    @endif

    @stack('structured-data')

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <x-google-analytics />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles

    {{-- Script Anti-Flash --}}
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>


</head>

<body class="font-sans antialiased text-gray-900 dark:text-gray-100 overflow-x-hidden" x-data="{ 
            theme: localStorage.getItem('theme') || 'light',
            sidebarOpen: false,
            init() {
                this.applyTheme(this.theme);
                this.$watch('theme', val => this.applyTheme(val));
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



    <div class="min-h-screen flex flex-col bg-ivory dark:bg-emerald-dark">
        @livewire('navigation-menu')

        <main class="flex-grow">
            {{ $slot }}
        </main>
        <x-public-footer />
    </div>

    <x-cookie-banner />

    @livewireScripts
</body>

</html>