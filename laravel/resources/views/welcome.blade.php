{{-- 
  File: resources/views/welcome.blade.php
  Description: Page Responsive (Scroll sur Mobile / Fixe 100vh sur Desktop)
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      class="dark" 
      x-data="{ 
          darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && true) 
      }" 
      x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
      :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Shou Cloud') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
{{-- 
    CORRECTION PRINCIPALE ICI :
    1. overflow-y-auto : Permet le scroll sur mobile.
    2. md:overflow-hidden : Bloque le scroll sur écran large (Desktop).
    3. md:h-screen : Force la hauteur 100% sur Desktop uniquement.
--}}
<body class="antialiased transition-colors duration-300 ease-in-out bg-gray-50 dark:bg-slate-900 text-slate-900 dark:text-white min-h-screen md:h-screen overflow-x-hidden overflow-y-auto md:overflow-y-hidden selection:bg-indigo-500 selection:text-white flex flex-col">

    {{-- 1. NAVIGATION --}}
    {{-- px-4 sur mobile, px-8 sur desktop --}}
    <nav class="flex-none w-full py-4 md:py-5 px-4 md:px-8 flex justify-between items-center z-20 transition-colors duration-300 bg-white dark:bg-slate-950 border-b border-gray-200 dark:border-slate-800 shadow-sm dark:shadow-xl">
        <div class="text-lg md:text-xl font-bold tracking-tighter">
            <span class="text-indigo-600 dark:text-indigo-500">Shou</span>Cloud
        </div>
        
        <div class="flex items-center space-x-3 md:space-x-6">
            {{-- Switch Theme --}}
            <button @click="darkMode = !darkMode" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2">
                <svg x-show="darkMode" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 100 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                <svg x-show="!darkMode" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
            </button>

            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-slate-700 dark:text-slate-200 hover:text-indigo-600 dark:hover:text-indigo-400 transition">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-700 dark:text-slate-200 hover:text-indigo-600 dark:hover:text-indigo-400 transition">Connexion</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="hidden sm:inline-block px-4 py-2 text-sm font-semibold bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 dark:hover:bg-indigo-500 transition shadow-lg shadow-indigo-500/30">Inscription</a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    {{-- 2. MAIN CONTENT --}}
    {{-- Mobile : h-auto et py-12 pour scroller / Desktop : flex-1 et pas de padding vertical excessif --}}
    <main class="flex-1 relative flex items-center justify-center px-6 md:px-12 w-full py-12 md:py-0">
        
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[300px] md:w-[700px] h-[300px] md:h-[500px] bg-indigo-500/10 dark:bg-indigo-600/10 blur-[80px] md:blur-[120px] rounded-full -z-10 pointer-events-none"></div>

        <div class="w-full max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-12 md:gap-16 items-center">
            
            {{-- Texte Marketing --}}
            <div class="space-y-6 md:space-y-8 text-center md:text-left">
                <div class="inline-block px-3 py-1 text-xs font-medium tracking-wide text-indigo-600 dark:text-indigo-300 bg-indigo-100 dark:bg-indigo-900/50 rounded-full border border-indigo-200 dark:border-indigo-700">
                    v1.0 &bull; Infrastructure Haute Performance
                </div>
                {{-- Taille de texte adaptative : text-4xl sur mobile, text-7xl sur desktop --}}
                <h1 class="text-4xl md:text-5xl lg:text-7xl font-extrabold tracking-tight leading-tight text-slate-900 dark:text-white">
                    Infrastructure <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-cyan-500 dark:from-indigo-400 dark:to-cyan-400">Cloud Simplifiée</span>
                </h1>
                <p class="text-base md:text-lg text-slate-600 dark:text-slate-400 max-w-lg mx-auto md:mx-0 leading-relaxed">
                    Une stack technique pragmatique et robuste. PHP 8.3 natif sur Ubuntu 24.04, bases de données managées et stockage S3 redondant.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                    <a href="{{ route('login') }}" class="px-8 py-4 text-base font-bold bg-slate-900 text-white dark:bg-white dark:text-slate-900 rounded-xl hover:bg-slate-700 dark:hover:bg-slate-200 transition shadow-xl w-full sm:w-auto">
                        Accéder au Cloud
                    </a>
                    <a href="#features" class="px-8 py-4 text-base font-bold border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-white rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition w-full sm:w-auto">
                        Documentation
                    </a>
                </div>
            </div>

            {{-- Terminal Technique --}}
            {{-- Hidden sur mobile car prend trop de place, Block sur Desktop (md:) --}}
            {{-- Si tu veux VRAIMENT l'afficher sur mobile, enlève 'hidden' et remplace par 'block mt-8', mais ça risque de faire beaucoup de scroll --}}
            <div class="relative hidden md:block group">
                <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-cyan-500 rounded-2xl blur opacity-20 dark:opacity-25 group-hover:opacity-40 transition duration-1000"></div>
                <div class="relative bg-slate-800 rounded-2xl p-6 border border-slate-700/50 shadow-2xl dark:shadow-none">
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
                                <div class="flex justify-between"><span>✅ Laravel 12 Core</span><span class="text-slate-500 text-xs">PHP 8.3 Native</span></div>
                                <div class="flex justify-between"><span>✅ MariaDB 10.11</span><span class="text-slate-500 text-xs">Managed SQL</span></div>
                                <div class="flex justify-between"><span>✅ Redis 7</span><span class="text-slate-500 text-xs">Cache & Queue</span></div>
                                <div class="flex justify-between"><span>✅ Meilisearch</span><span class="text-slate-500 text-xs">Full-Text</span></div>
                                <div class="flex justify-between"><span>✅ AWS S3</span><span class="text-slate-500 text-xs">3AZ Storage</span></div>
                            </div>
                            <p class="pt-2"><span class="text-green-400">user@shou-cloud</span>:<span class="text-blue-400">~</span>$ <span class="animate-pulse">_</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    {{-- 3. SECTION BASSE (FEATURES) --}}
    {{-- Mobile : h-auto (hauteur auto pour empiler) / Desktop : min-h-[20vh] (hauteur fixe) --}}
    <section id="features" class="h-auto md:min-h-[20vh] transition-colors duration-300 bg-white/80 dark:bg-slate-800/50 border-t border-gray-200 dark:border-slate-700 backdrop-blur-sm flex items-center shrink-0 py-8 md:py-4">
        <div class="w-full max-w-7xl mx-auto px-6 h-full">
            {{-- Grid : 1 colonne sur mobile, 3 sur Desktop --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 h-full">
                
                {{-- Carte 1 --}}
                <div class="px-6 py-4 rounded-xl bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 hover:border-indigo-400 dark:hover:border-indigo-500/50 transition duration-300 shadow-sm hover:shadow-md dark:shadow-lg flex items-center space-x-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white">Stockage AWS S3</h3>
                        <p class="text-slate-500 dark:text-slate-400 text-xs leading-tight">Triple redondance (3AZ), fichiers isolés et hébergement en France.</p>
                    </div>
                </div>

                {{-- Carte 2 --}}
                <div class="px-6 py-4 rounded-xl bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 hover:border-indigo-400 dark:hover:border-indigo-500/50 transition duration-300 shadow-sm hover:shadow-md dark:shadow-lg flex items-center space-x-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white">Recherche Instantanée</h3>
                        <p class="text-slate-500 dark:text-slate-400 text-xs leading-tight">Indexation ultra-rapide et tolérante aux fautes via Meilisearch.</p>
                    </div>
                </div>

                {{-- Carte 3 --}}
                <div class="px-6 py-4 rounded-xl bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 hover:border-indigo-400 dark:hover:border-indigo-500/50 transition duration-300 shadow-sm hover:shadow-md dark:shadow-lg flex items-center space-x-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white">Performance Linux</h3>
                        <p class="text-slate-500 dark:text-slate-400 text-xs leading-tight">Fluidité maximale : PHP 8.3 natif sur Ubuntu 24.04 & MariaDB.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

</body>
</html>