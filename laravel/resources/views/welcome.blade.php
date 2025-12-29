{{-- 
  File: resources/views/welcome.blade.php
  Description: Page d'accueil finale - Cohérence Stack (AWS/MariaDB) & Design ajusté
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Shou Cloud') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-900 text-white h-screen overflow-hidden selection:bg-indigo-500 selection:text-white flex flex-col">

    {{-- 1. NAVIGATION --}}
    <nav class="flex-none w-full py-5 px-8 flex justify-between items-center z-20 bg-slate-950 border-b border-slate-800 shadow-xl">
        <div class="text-xl font-bold tracking-tighter">
            <span class="text-indigo-500">Shou</span>Cloud
        </div>
        <div class="flex items-center space-x-6">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm font-semibold hover:text-indigo-400 transition">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold hover:text-indigo-400 transition">Connexion</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-semibold bg-indigo-600 rounded-lg hover:bg-indigo-500 transition shadow-lg shadow-indigo-500/30">Inscription</a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    {{-- 2. MAIN CONTENT --}}
    <main class="flex-1 relative flex items-center justify-center px-8 sm:px-12 w-full">
        
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[500px] bg-indigo-600/10 blur-[120px] rounded-full -z-10 pointer-events-none"></div>

        <div class="w-full max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
            
            {{-- Texte Marketing --}}
            <div class="space-y-8 text-center md:text-left">
                <div class="inline-block px-3 py-1 text-xs font-medium tracking-wide text-indigo-300 bg-indigo-900/50 rounded-full border border-indigo-700">
                    v1.0 &bull; Infrastructure Haute Performance
                </div>
                <h1 class="text-5xl lg:text-7xl font-extrabold tracking-tight leading-tight">
                    Infrastructure <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-cyan-400">Cloud Simplifiée</span>
                </h1>
                <p class="text-lg text-slate-400 max-w-lg mx-auto md:mx-0 leading-relaxed">
                    Une stack technique pragmatique et robuste. PHP 8.3 natif sur Ubuntu 24.04, bases de données managées et stockage S3 redondant.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                    <a href="{{ route('login') }}" class="px-8 py-4 text-base font-bold bg-white text-slate-900 rounded-xl hover:bg-slate-200 transition shadow-xl">
                        Accéder au Cloud
                    </a>
                    <a href="#features" class="px-8 py-4 text-base font-bold border border-slate-700 rounded-xl hover:bg-slate-800 transition">
                        Documentation
                    </a>
                </div>
            </div>

            {{-- Terminal Technique --}}
            <div class="relative hidden md:block group">
                <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-cyan-500 rounded-2xl blur opacity-25 group-hover:opacity-40 transition duration-1000"></div>
                <div class="relative bg-slate-800 rounded-2xl p-6 border border-slate-700/50 shadow-2xl">
                    <div class="space-y-4 font-mono text-sm text-slate-300">
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-3 h-3 rounded-full bg-red-500"></div>
                            <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                            <div class="w-3 h-3 rounded-full bg-green-500"></div>
                        </div>
                        <div class="space-y-2">
                            <p><span class="text-green-400">user@shou-cloud</span>:<span class="text-blue-400">~</span>$ stack status --full</p>
                            <p class="text-slate-500 italic">Checking infrastructure integrity...</p>
                            
                            <div class="pl-4 border-l-2 border-slate-700/50 space-y-1 pt-2">
                                <div class="flex justify-between">
                                    <span>✅ Laravel 12 Core</span>
                                    <span class="text-slate-500 text-xs">PHP 8.3 Native</span>
                                </div>
                                {{-- MISE A JOUR ICI : MariaDB au lieu de MySQL --}}
                                <div class="flex justify-between">
                                    <span>✅ MariaDB 10.11</span>
                                    <span class="text-slate-500 text-xs">Managed SQL</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>✅ Redis 7</span>
                                    <span class="text-slate-500 text-xs">Cache & Queue</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>✅ Meilisearch</span>
                                    <span class="text-slate-500 text-xs">Full-Text</span>
                                </div>
                                {{-- MISE A JOUR ICI : AWS S3 au lieu de MinIO --}}
                                <div class="flex justify-between">
                                    <span>✅ AWS S3</span>
                                    <span class="text-slate-500 text-xs">3AZ Storage</span>
                                </div>
                            </div>
                            
                            <p class="pt-2"><span class="text-green-400">user@shou-cloud</span>:<span class="text-blue-400">~</span>$ <span class="animate-pulse">_</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    {{-- 3. SECTION BASSE (FEATURES) --}}
    {{-- Passage à min-h-[20vh] pour éviter que le texte ne soit coupé si la fenêtre est petite --}}
    <section class="min-h-[20vh] bg-slate-800/50 border-t border-slate-700 backdrop-blur-sm flex items-center shrink-0 py-4">
        <div class="w-full max-w-7xl mx-auto px-6 h-full">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 h-full">
                
                {{-- Carte 1 --}}
                <div class="px-6 py-4 rounded-xl bg-slate-800 border border-slate-700 hover:border-indigo-500/50 transition duration-300 shadow-lg flex items-center space-x-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-indigo-900/50 rounded-lg flex items-center justify-center text-indigo-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-white">Stockage AWS S3</h3>
                        <p class="text-slate-400 text-xs leading-tight">Triple redondance (3AZ), fichiers isolés et hébergement en France.</p>
                    </div>
                </div>

                {{-- Carte 2 --}}
                <div class="px-6 py-4 rounded-xl bg-slate-800 border border-slate-700 hover:border-indigo-500/50 transition duration-300 shadow-lg flex items-center space-x-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-indigo-900/50 rounded-lg flex items-center justify-center text-indigo-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-white">Recherche Instantanée</h3>
                        <p class="text-slate-400 text-xs leading-tight">Indexation ultra-rapide et tolérante aux fautes via Meilisearch.</p>
                    </div>
                </div>

                {{-- Carte 3 --}}
                <div class="px-6 py-4 rounded-xl bg-slate-800 border border-slate-700 hover:border-indigo-500/50 transition duration-300 shadow-lg flex items-center space-x-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-indigo-900/50 rounded-lg flex items-center justify-center text-indigo-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-white">Performance Linux</h3>
                        <p class="text-slate-400 text-xs leading-tight">Fluidité maximale : PHP 8.3 natif sur Ubuntu 24.04 & MariaDB.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

</body>
</html>