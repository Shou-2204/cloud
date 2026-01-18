<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $seoTitle = $seo['title'] ?? config('app.name', 'Laravel');
        $seoDescription = $seo['description'] ?? 'ShouCloud - Growth Tools for Modern Businesses';
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

<body class="font-sans antialiased text-gray-900 dark:text-gray-100" x-data="{ 
            darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) 
        }" x-init="$watch('darkMode', val => {
            localStorage.setItem('theme', val ? 'dark' : 'light');
            val ? document.documentElement.classList.add('dark') : document.documentElement.classList.remove('dark');
        })">

    <div class="min-h-screen flex flex-col">
        <main class="flex-grow">
            {{ $slot }}
        </main>
        <x-app-footer />
    </div>

    @livewireScripts
</body>

</html>