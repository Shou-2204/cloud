<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} - Bientôt Disponible | Solution Marketing pour Commerçants</title>
    <meta name="description"
        content="La solution tout-en-un pour booster votre commerce arrive bientôt. Réservez votre place et profitez de l'offre de lancement : 49€ HT au lieu de 79€ HT.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <x-google-analytics />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        @keyframes gradient-shift {

            0%,
            100% {
                background-position: 0% 50%;
            }

            @keyframes float {

                0%,
                100% {
                    transform: translateY(0px);
                }

                50% {
                    transform: translateY(-20px);
                }
            }

            .animate-float {
                animation: float 6s ease-in-out infinite;
            }

            @keyframes pulse-glow {

                0%,
                100% {
                    box-shadow: 0 0 20px rgba(16, 185, 129, 0.3);
                }

                50% {
                    box-shadow: 0 0 40px rgba(16, 185, 129, 0.6);
                }
            }

            .pulse-glow {
                animation: pulse-glow 2s ease-in-out infinite;
            }

            .glass {
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }

            .dark .glass {
                background: rgba(0, 0, 0, 0.2);
                border: 1px solid rgba(255, 255, 255, 0.1);
            }
    </style>

</head>

<body
    class="antialiased bg-ivory dark:bg-emerald-dark text-gray-900 dark:text-gray-100 font-sans selection:bg-emerald-500 selection:text-white overflow-x-hidden"
    x-data="{ 
        theme: localStorage.getItem('theme') || 'light',
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

    <!-- Navigation -->
    @livewire('navigation-menu')

    <!-- MAIN CONTENT -->
    <main class="relative min-h-screen pt-24 pb-20">

        <!-- Decorative Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div
                class="absolute top-20 right-10 w-72 h-72 bg-emerald-300/20 dark:bg-emerald-500/10 rounded-full blur-3xl animate-float">
            </div>
            <div class="absolute bottom-20 left-10 w-96 h-96 bg-blue-300/20 dark:bg-blue-500/10 rounded-full blur-3xl animate-float"
                style="animation-delay: 2s;"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">

            <!-- HERO SECTION -->
            <div class="text-center mb-20">
                <!-- Coming Soon Badge -->
                <div class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-emerald-600 text-white font-bold text-sm mb-8 shadow-lg pulse-glow"
                    x-data="{ show: true }" x-show="show" x-transition>
                    <svg class="w-5 h-5 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                            clip-rule="evenodd" />
                    </svg>
                    Bientôt disponible
                </div>

                <!-- Main Headline -->
                <h1 class="text-5xl sm:text-6xl lg:text-7xl font-black tracking-tight mb-6 leading-tight">
                    <span class="text-emerald-700 dark:text-emerald-400">
                        Boostez votre commerce
                    </span>
                    <br>
                    <span class="text-gray-900 dark:text-white">
                        en toute simplicité
                    </span>
                </h1>

                <!-- Subheadline -->
                <p class="text-xl sm:text-2xl text-gray-600 dark:text-gray-300 mb-12 max-w-3xl mx-auto leading-relaxed">
                    La solution tout-en-un pour gérer vos avis Google, fidéliser vos clients et développer votre
                    activité.
                    <span class="font-semibold text-emerald-600 dark:text-emerald-400">Sans être un expert en
                        informatique.</span>
                </p>

                <!-- Email Capture Form -->
                <div class="max-w-2xl mx-auto mb-8">
                    @livewire('lead-capture')
                </div>

                <!-- Trust Indicator -->
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    <span class="font-bold text-emerald-600 dark:text-emerald-400">+500 commerçants</span> nous font
                    déjà confiance
                </p>
            </div>

            <!-- PRICING SECTION -->
            <div class="max-w-4xl mx-auto mb-20">
                <div class="relative">
                    <!-- Subtle Glow Effect -->
                    <div class="absolute inset-0 bg-emerald-500/5 rounded-3xl blur-2xl">
                    </div>

                    <!-- Pricing Card -->
                    <div
                        class="relative bg-white dark:bg-emerald-dark-500 rounded-3xl shadow-2xl overflow-hidden border border-gray-100 dark:border-emerald-dark-400">

                        <!-- Launch Offer Badge -->
                        <div
                            class="absolute top-6 right-6 bg-rose-600 text-white px-6 py-2 rounded-full font-bold text-sm shadow-lg transform rotate-3">
                            -38% 🔥
                        </div>

                        <div class="p-8 sm:p-12">
                            <div class="text-center mb-8">
                                <h2 class="text-3xl sm:text-4xl font-black text-gray-900 dark:text-white mb-4">
                                    Offre de Lancement
                                </h2>
                                <p class="text-gray-600 dark:text-gray-300 text-lg">
                                    Réservez votre place maintenant et profitez d'un tarif exceptionnel
                                </p>
                            </div>

                            <!-- Pricing Display -->
                            <div class="flex items-center justify-center gap-6 mb-8">
                                <!-- Original Price -->
                                <div class="text-center">
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Prix normal</p>
                                    <p class="text-3xl font-bold text-gray-400 dark:text-gray-500 line-through">
                                        79€
                                    </p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500">HT/mois</p>
                                </div>

                                <!-- Arrow -->
                                <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>

                                <!-- Launch Price -->
                                <div class="text-center">
                                    <p class="text-sm text-emerald-600 dark:text-emerald-400 font-bold mb-1">Prix de
                                        lancement</p>
                                    <p class="text-6xl sm:text-7xl font-black text-emerald-700 dark:text-emerald-400">
                                        49€
                                    </p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">HT/mois</p>
                                </div>
                            </div>

                            <!-- Savings Badge -->
                            <div class="text-center mb-8">
                                <div
                                    class="inline-block bg-emerald-50 dark:bg-emerald-900/30 border-2 border-emerald-500 dark:border-emerald-400 rounded-2xl px-8 py-4">
                                    <p class="text-2xl font-black text-emerald-600 dark:text-emerald-400">
                                        Économisez 30€/mois
                                    </p>
                                    <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                        Soit 360€ d'économies par an !
                                    </p>
                                </div>
                            </div>

                            <!-- What's Included -->
                            <div class="grid sm:grid-cols-2 gap-4 mb-8">
                                <div class="flex items-start gap-3">
                                    <svg class="w-6 h-6 text-emerald-500 flex-shrink-0 mt-1" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <div>
                                        <p class="font-bold text-gray-900 dark:text-white">Avis Google illimités</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Collectez et gérez tous vos
                                            avis</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <svg class="w-6 h-6 text-emerald-500 flex-shrink-0 mt-1" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <div>
                                        <p class="font-bold text-gray-900 dark:text-white">Carte de fidélité digitale
                                        </p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Dans Apple Wallet & Google
                                            Wallet</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <svg class="w-6 h-6 text-emerald-500 flex-shrink-0 mt-1" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <div>
                                        <p class="font-bold text-gray-900 dark:text-white">SMS & Email marketing</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Relancez vos clients
                                            automatiquement</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <svg class="w-6 h-6 text-emerald-500 flex-shrink-0 mt-1" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <div>
                                        <p class="font-bold text-gray-900 dark:text-white">Support prioritaire</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Assistance rapide et
                                            personnalisée</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Limited Time Notice -->
                            <div
                                class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-700 rounded-xl p-4 text-center">
                                <p class="text-amber-800 dark:text-amber-200 font-bold">
                                    ⏰ Offre limitée aux 100 premiers inscrits
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FEATURES GRID -->
            <div class="mb-20">
                <h2 class="text-3xl sm:text-4xl font-black text-center text-gray-900 dark:text-white mb-12">
                    Tout ce dont vous avez besoin, en un seul endroit
                </h2>

                <div class="grid md:grid-cols-3 gap-6">
                    <!-- Feature 1 -->
                    <div
                        class="group bg-white dark:bg-emerald-dark-500 p-8 rounded-2xl shadow-lg border border-gray-100 dark:border-emerald-dark-400 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                        <div
                            class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12.48 10.92v3.28h7.84c-.24 1.84-.853 3.187-1.787 4.133-1.147 1.147-2.933 2.4-6.053 2.4-4.827 0-8.6-3.893-8.6-8.72s3.773-8.72 8.6-8.72c2.6 0 4.507 1.027 5.907 2.347l2.307-2.307C18.747 1.44 16.133 0 12.48 0 5.867 0 .533 5.333.533 12S5.867 24 12.48 24c3.44 0 6.013-1.133 8.053-3.24 2.107-2.107 2.76-5.067 2.76-7.84 0-.76-.08-1.467-.187-2l-10.627.001z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Réputation en ligne</h3>
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                            Collectez plus d'avis 5 étoiles sur Google et améliorez votre visibilité locale. Répondez
                            facilement à tous vos avis depuis un seul tableau de bord.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div
                        class="group bg-white dark:bg-emerald-dark-500 p-8 rounded-2xl shadow-lg border border-gray-100 dark:border-emerald-dark-400 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                        <div
                            class="w-16 h-16 bg-slate-900 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Fidélisation moderne</h3>
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                            Carte de fidélité digitale directement dans le smartphone de vos clients. Fini les cartes
                            papier perdues, place à la modernité !
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div
                        class="group bg-white dark:bg-emerald-dark-500 p-8 rounded-2xl shadow-lg border border-gray-100 dark:border-emerald-dark-400 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                        <div
                            class="w-16 h-16 bg-emerald-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Marketing automatisé</h3>
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                            Envoyez des SMS et emails personnalisés à vos clients. Relances automatiques pour les faire
                            revenir plus souvent dans votre commerce.
                        </p>
                    </div>
                </div>
            </div>

            <!-- FINAL CTA -->
            <div class="text-center">
                <div class="inline-block bg-emerald-600 p-1 rounded-3xl shadow-2xl">
                    <div class="bg-white dark:bg-emerald-dark-500 rounded-3xl px-12 py-10">
                        <h3 class="text-3xl font-black text-gray-900 dark:text-white mb-4">
                            Prêt à transformer votre commerce ?
                        </h3>
                        <p class="text-lg text-gray-600 dark:text-gray-300 mb-6">
                            Rejoignez les commerçants qui font confiance à {{ config('app.name') }}
                        </p>
                        <div class="max-w-xl mx-auto">
                            @livewire('lead-capture')
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- FOOTER -->
        <div class="max-w-7xl mx-auto px-6 w-full mt-20 text-center border-t border-gray-200 dark:border-gray-800 pt-8">
            <div
                class="flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-gray-400 dark:text-gray-500">
                <span>&copy; {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.</span>
                <div class="flex gap-4">
                    <a href="{{ route('terms.show') }}"
                        class="hover:text-emerald-600 dark:hover:text-emerald-400 transition">CGU</a>
                    <a href="{{ route('policy.show') }}"
                        class="hover:text-emerald-600 dark:hover:text-emerald-400 transition">Confidentialité</a>
                    <a href="{{ route('sales.show') }}"
                        class="hover:text-emerald-600 dark:hover:text-emerald-400 transition">CGV</a>
                </div>
            </div>
        </div>

    </main>

    <x-cookie-banner />

</body>

</html>