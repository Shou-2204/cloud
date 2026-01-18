<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ShouCloud - Marketing Digital pour Commerçants</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-gray-900 text-gray-100 font-sans selection:bg-emerald-500 selection:text-white">

    <!-- HEADER / NAV -->
    <nav class="absolute top-0 left-0 w-full z-50">
        <div class="max-w-7xl mx-auto px-6 py-6 flex justify-between items-center">
            <!-- Brand -->
            <div class="flex items-center gap-2">
                <div
                    class="h-8 w-8 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-lg flex items-center justify-center text-white font-bold shadow-lg shadow-emerald-500/20">
                    S
                </div>
                <span class="text-xl font-bold tracking-tight text-white">
                    <span class="text-emerald-400">Shou</span>Cloud
                </span>
            </div>

            <!-- Auth Links -->
            <div class="hidden sm:flex items-center gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="text-sm font-medium text-gray-300 hover:text-white transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-sm font-medium text-gray-300 hover:text-white transition">Connexion</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="px-4 py-2 text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-500 rounded-full transition-all shadow-lg shadow-emerald-900/40">
                                Commencer
                            </a>
                        @endif
                    @endauth
                @endif
            </div>

            <!-- Mobile Menu Button (Simple Placeholder) -->
            <div class="sm:hidden text-white cursor-pointer">
                {{-- Simple hamburger if needed, for now just relying on top links visible or simplified --}}
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden pt-20">
        <!-- Background Gradients -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full max-w-7xl pointer-events-none">
            <div
                class="absolute top-20 left-10 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl rounded-full mix-blend-screen animate-pulse">
            </div>
            <div
                class="absolute bottom-20 right-10 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl rounded-full mix-blend-screen">
            </div>
        </div>

        <div class="relative max-w-7xl mx-auto px-6 text-center z-10">
            <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight mb-8">
                Boostez votre commerce avec le <br class="hidden md:block" />
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-300">
                    marketing digital tout-en-un.
                </span>
            </h1>
            <p class="text-lg md:text-xl text-gray-400 max-w-3xl mx-auto mb-10 leading-relaxed">
                Fidélisez vos clients, améliorez votre visibilité Google et lancez des campagnes percutantes. Le tout,
                <strong class="text-white">automatiquement</strong>.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('register') }}"
                    class="w-full sm:w-auto px-8 py-4 text-lg font-bold text-white bg-emerald-600 hover:bg-emerald-500 rounded-xl transition-all shadow-xl shadow-emerald-500/20 transform hover:-translate-y-1">
                    Commencer gratuitement
                </a>
                <a href="#features"
                    class="w-full sm:w-auto px-8 py-4 text-lg font-medium text-gray-300 bg-gray-800 hover:bg-gray-700 rounded-xl transition-all border border-gray-700">
                    En savoir plus
                </a>
            </div>

            <div class="mt-16 text-sm text-gray-500 font-medium">
                Déjà utilisé par <span class="text-emerald-400 font-bold">+500 commerçants</span> satisfaits.
            </div>
        </div>
    </section>

    <!-- FEATURES GRID -->
    <section id="features" class="py-24 bg-gray-900 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Trois piliers pour votre croissance</h2>
                <p class="text-gray-400 max-w-2xl mx-auto">
                    Une suite d'outils puissants conçus spécifiquement pour les commerces physiques.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- FEATURE 1: GOOGLE REVIEWS -->
                <div
                    class="group p-8 bg-gray-800 rounded-3xl border border-gray-700 hover:border-emerald-500/50 hover:bg-gray-800/80 transition-all duration-300 hover:-translate-y-1">
                    <div
                        class="h-14 w-14 bg-emerald-900/50 rounded-2xl flex items-center justify-center text-emerald-400 mb-6 group-hover:bg-emerald-500 group-hover:text-white transition-colors">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Avis Google & Réputation</h3>
                    <p class="text-gray-400 mb-4">
                        Multipliez vos avis 5 étoiles grâce à la sollicitation automatique. Collectez aussi des
                        <strong>retours d'expérience clients</strong> précis et en direct pour améliorer votre service.
                    </p>
                    <ul class="text-sm text-gray-500 space-y-2">
                        <li class="flex items-center gap-2"><span class="text-emerald-500">✓</span> Envoi SMS
                            automatique</li>
                        <li class="flex items-center gap-2"><span class="text-emerald-500">✓</span> Filtrage NPS &
                            Feedback</li>
                    </ul>
                </div>

                <!-- FEATURE 2: WALLET -->
                <div
                    class="group p-8 bg-gray-800 rounded-3xl border border-gray-700 hover:border-emerald-500/50 hover:bg-gray-800/80 transition-all duration-300 hover:-translate-y-1">
                    <div
                        class="h-14 w-14 bg-emerald-900/50 rounded-2xl flex items-center justify-center text-emerald-400 mb-6 group-hover:bg-emerald-500 group-hover:text-white transition-colors">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Fidélité Wallet (Mobile)</h3>
                    <p class="text-gray-400 mb-4">
                        Oubliez les cartes plastiques. Vos clients installent votre carte de fidélité directement dans
                        leur <strong>Apple Wallet</strong> ou <strong>Google Wallet</strong> en un clic.
                    </p>
                    <ul class="text-sm text-gray-500 space-y-2">
                        <li class="flex items-center gap-2"><span class="text-emerald-500">✓</span> Notifications Push
                            ciblées</li>
                        <li class="flex items-center gap-2"><span class="text-emerald-500">✓</span> <strong>Coupons de
                                réduction</strong> digitaux</li>
                    </ul>
                </div>

                <!-- FEATURE 3: CAMPAIGNS -->
                <div
                    class="group p-8 bg-gray-800 rounded-3xl border border-gray-700 hover:border-emerald-500/50 hover:bg-gray-800/80 transition-all duration-300 hover:-translate-y-1">
                    <div
                        class="h-14 w-14 bg-emerald-900/50 rounded-2xl flex items-center justify-center text-emerald-400 mb-6 group-hover:bg-emerald-500 group-hover:text-white transition-colors">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Marketing Automatisé</h3>
                    <p class="text-gray-400 mb-4">
                        Lancez des campagnes SMS et Emailing qui convertissent. Réengagez les clients dormants et
                        célébrez les anniversaires sans lever le petit doigt.
                    </p>
                    <ul class="text-sm text-gray-500 space-y-2">
                        <li class="flex items-center gap-2"><span class="text-emerald-500">✓</span> Scénarios
                            automatisés</li>
                        <li class="flex items-center gap-2"><span class="text-emerald-500">✓</span> Promos & Offres
                            Flash</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-black py-12 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="flex items-center gap-2">
                <div
                    class="h-6 w-6 bg-emerald-600 rounded flex items-center justify-center text-white text-xs font-bold">
                    S</div>
                <span class="text-white font-bold">ShouCloud</span>
            </div>

            <div class="flex flex-wrap gap-6 text-sm text-gray-400">
                <a href="{{ route('terms.show') }}" class="hover:text-white transition">CGU</a>
                <a href="{{ route('policy.show') }}" class="hover:text-white transition">Confidentialité</a>
                <a href="{{ route('sales.show') }}" class="hover:text-white transition">CGV</a>
            </div>

            <div class="text-gray-600 text-sm">
                &copy; {{ date('Y') }} ShouCloud. Tous droits réservés.
            </div>
        </div>
    </footer>

</body>

</html>