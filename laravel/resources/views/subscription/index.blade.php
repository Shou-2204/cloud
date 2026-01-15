<x-app-layout>
    <div x-data="{ 
            annual: true,
            selected: 'smart',
            plans: {
                starter: { 
                    monthly: '{{ config('services.stripe.plans.starter.monthly') }}', 
                    yearly:  '{{ config('services.stripe.plans.starter.yearly') }}',
                    price_monthly: 29,
                    price_yearly: 290
                },
                smart: { 
                    monthly: '{{ config('services.stripe.plans.smart.monthly') }}', 
                    yearly:  '{{ config('services.stripe.plans.smart.yearly') }}',
                    price_monthly: 79,
                    price_yearly: 790
                },
                pro: { 
                    monthly: '{{ config('services.stripe.plans.pro.monthly') }}', 
                    yearly:  '{{ config('services.stripe.plans.pro.yearly') }}',
                    price_monthly: 149,
                    price_yearly: 1490
                }
            }
         }" class="bg-white dark:bg-gray-950 font-sans text-gray-900 dark:text-gray-100">

        {{-- HERO SECTION --}}
        <div class="relative overflow-hidden pt-16 pb-12 lg:pt-24 lg:pb-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
                <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight mb-6">
                    Boostez votre <span class="text-indigo-600 dark:text-indigo-400">fidélisation client</span>.
                </h1>
                <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500 dark:text-gray-400">
                    Des outils puissants pour collecter des avis, engager vos clients et automatiser votre marketing.
                </p>

                {{-- TOGGLE ANNUEL / MENSUEL --}}
                <div class="mt-12 flex justify-center">
                    <div class="relative bg-gray-100 dark:bg-gray-800 p-1 rounded-full inline-flex items-center">
                        {{-- Sliding Background --}}
                        <div class="absolute inset-y-1 left-1 w-[calc(50%-4px)] bg-white dark:bg-gray-700 rounded-full shadow-sm transition-transform duration-300 ease-in-out"
                            :class="annual ? 'translate-x-full' : 'translate-x-0'"></div>

                        <button @click="annual = false"
                            class="relative z-10 w-32 py-2.5 rounded-full text-sm font-semibold transition-colors duration-200 text-center"
                            :class="!annual ? 'text-gray-900 dark:text-gray-100' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700'">
                            Mensuel
                        </button>
                        <button @click="annual = true"
                            class="relative z-10 w-32 py-2.5 rounded-full text-sm font-semibold transition-colors duration-200 flex items-center justify-center gap-2"
                            :class="annual ? 'text-gray-900 dark:text-gray-100' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700'">
                            Annuel
                            <span
                                class="text-[10px] font-bold tracking-wide uppercase bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 px-2 py-0.5 rounded-full">
                                -2 mois
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- PRICING CARDS (GRID) --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">
            <div class="grid md:grid-cols-3 gap-8 items-start">

                {{-- STARTER --}}
                <div
                    class="h-full p-8 bg-gray-50 dark:bg-gray-900 rounded-3xl border border-gray-200 dark:border-gray-800 flex flex-col hover:border-gray-300 dark:hover:border-gray-700 transition-colors">
                    <div class="mb-4">
                        <h3 class="text-xl font-bold">Starter</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 min-h-[40px]">L'essentiel pour maîtriser
                            votre e-réputation.</p>
                    </div>
                    <div class="mb-6 flex items-baseline gap-1">
                        <span class="text-4xl font-extrabold"
                            x-text="annual ? Math.round(plans.starter.price_yearly / 12) : plans.starter.price_monthly"></span>
                        <span class="text-xl font-bold">€</span>
                        <span class="text-gray-500 dark:text-gray-400">/mois</span>
                        <span class="text-xs text-gray-400 ml-2" x-show="annual" x-cloak>(facturé annuellement)</span>
                    </div>

                    <a :href="'/subscribe/' + (annual ? plans.starter.yearly : plans.starter.monthly)"
                        class="w-full block text-center bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white font-semibold py-3 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors mb-8">
                        Commencer
                    </a>

                    <div class="flex-1 space-y-4">
                        <p class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-4">Fonctionnalités
                            incluses :</p>
                        <ul class="space-y-3 text-sm">
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Collecte de <strong>Feedback</strong></span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Gestion des <strong>Avis Google</strong></span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span><strong>Roue de la Fortune</strong> (Capture Data)</span>
                            </li>
                            <li class="flex items-start gap-3 text-gray-400 dark:text-gray-600">
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                <span>Wallet Mobile</span>
                            </li>
                            <li class="flex items-start gap-3 text-gray-400 dark:text-gray-600">
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                <span>Campagnes SMS</span>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- SMART (Highlighted) --}}
                <div
                    class="h-full relative p-8 bg-white dark:bg-gray-800 rounded-3xl border-2 border-indigo-600 shadow-2xl z-10 scale-105 flex flex-col">
                    <div class="absolute top-0 right-0 transform translate-x-2 -translate-y-2">
                        <span
                            class="bg-indigo-600 text-white text-[10px] font-bold uppercase py-1 px-3 rounded-bl-xl rounded-tr-xl shadow-sm">Populaire</span>
                    </div>
                    <div class="mb-4">
                        <h3 class="text-xl font-bold text-indigo-600 dark:text-indigo-400">Smart</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 min-h-[40px]">Fidélisez votre clientèle
                            avec le Wallet Mobile.</p>
                    </div>
                    <div class="mb-6 flex items-baseline gap-1">
                        <span class="text-5xl font-extrabold"
                            x-text="annual ? Math.round(plans.smart.price_yearly / 12) : plans.smart.price_monthly"></span>
                        <span class="text-xl font-bold">€</span>
                        <span class="text-gray-500 dark:text-gray-400">/mois</span>
                        <span class="text-xs text-gray-400 ml-2" x-show="annual" x-cloak>(facturé annuellement)</span>
                    </div>

                    <a :href="'/subscribe/' + (annual ? plans.smart.yearly : plans.smart.monthly)"
                        class="w-full block text-center bg-indigo-600 text-white font-semibold py-4 rounded-xl hover:bg-indigo-700 shadow-lg shadow-indigo-500/30 transition-all mb-8">
                        Choisir Smart
                    </a>

                    <div class="flex-1 space-y-4">
                        <p class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-4">Tout de Starter, plus :
                        </p>
                        <ul class="space-y-3 text-sm">
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400 shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Cartes de Fidélité <strong>Wallet</strong> (Apple/Google)</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400 shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span><strong>CRM Clé en main</strong></span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400 shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Notifications Push illimitées</span>
                            </li>
                            <li class="flex items-start gap-3 text-gray-400 dark:text-gray-600">
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                <span>Automatisation IA</span>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- PRO --}}
                <div
                    class="h-full p-8 bg-gray-50 dark:bg-gray-900 rounded-3xl border border-gray-200 dark:border-gray-800 flex flex-col hover:border-gray-300 dark:hover:border-gray-700 transition-colors">
                    <div class="mb-4">
                        <h3 class="text-xl font-bold">Pro</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 min-h-[40px]">Automatisez tout. Dominez
                            votre marché.</p>
                    </div>
                    <div class="mb-6 flex items-baseline gap-1">
                        <span class="text-4xl font-extrabold"
                            x-text="annual ? Math.round(plans.pro.price_yearly / 12) : plans.pro.price_monthly"></span>
                        <span class="text-xl font-bold">€</span>
                        <span class="text-gray-500 dark:text-gray-400">/mois</span>
                        <span class="text-xs text-gray-400 ml-2" x-show="annual" x-cloak>(facturé annuellement)</span>
                    </div>

                    <a :href="'/subscribe/' + (annual ? plans.pro.yearly : plans.pro.monthly)"
                        class="w-full block text-center bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white font-semibold py-3 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors mb-8">
                        Choisir Pro
                    </a>

                    <div class="flex-1 space-y-4">
                        <p class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-4">Tout de Smart, plus :
                        </p>
                        <ul class="space-y-3 text-sm">
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-purple-500 shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Marketing <strong>SMS Automatisé</strong></span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-purple-500 shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Réponses Avis Google via <strong>IA (SEO)</strong></span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-purple-500 shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Dashboard Analytics Avancé</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-purple-500 shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Manager de Compte Dédié</span>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>

        {{-- COMPARISON TABLE SECTION --}}
        <div class="bg-gray-50 dark:bg-gray-900/50 py-24 border-t border-gray-200 dark:border-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-bold">Comparatif détaillé</h2>
                    <p class="mt-4 text-gray-500">Un regard approfondi sur ce qui est inclus.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr>
                                <th class="py-4 px-6 bg-transparent w-1/4"></th>
                                <th class="py-4 px-6 text-center text-lg font-bold w-1/4">Starter</th>
                                <th
                                    class="py-4 px-6 text-center text-lg font-bold text-indigo-600 dark:text-indigo-400 w-1/4 bg-white dark:bg-gray-800 rounded-t-xl border-x-2 border-t-2 border-indigo-600 border-b-0 shadow-lg">
                                    Smart
                                </th>
                                <th class="py-4 px-6 text-center text-lg font-bold w-1/4">Pro</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                            {{-- SECTION: AVIS & RÉPUTATION --}}
                            {{-- SECTION: AVIS & RÉPUTATION --}}
                            <tr>
                                <td class="py-6 px-6 text-xs font-bold uppercase tracking-widest text-gray-500">Avis &
                                    Réputation</td>
                                <td></td>
                                <td class="bg-white dark:bg-gray-800 border-x-2 border-indigo-600"></td>
                                <td></td>
                            </tr>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                <td class="py-4 px-6 text-sm font-medium">Collecte d'avis (Email/QR)</td>
                                <td class="text-center py-4 text-green-500"><svg class="w-6 h-6 mx-auto" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg></td>
                                <td
                                    class="text-center py-4 bg-white dark:bg-gray-800 border-x-2 border-indigo-600 text-green-500">
                                    <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </td>
                                <td class="text-center py-4 text-green-500"><svg class="w-6 h-6 mx-auto" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg></td>
                            </tr>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                <td class="py-4 px-6 text-sm font-medium">Centralisation Google Reviews</td>
                                <td class="text-center py-4 text-green-500"><svg class="w-6 h-6 mx-auto" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg></td>
                                <td
                                    class="text-center py-4 bg-white dark:bg-gray-800 border-x-2 border-indigo-600 text-green-500">
                                    <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </td>
                                <td class="text-center py-4 text-green-500"><svg class="w-6 h-6 mx-auto" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg></td>
                            </tr>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                <td class="py-4 px-6 text-sm font-medium">Jeux / Roue de la Fortune (Data)</td>
                                <td class="text-center py-4 text-green-500"><svg class="w-6 h-6 mx-auto" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg></td>
                                <td
                                    class="text-center py-4 bg-white dark:bg-gray-800 border-x-2 border-indigo-600 text-green-500">
                                    <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </td>
                                <td class="text-center py-4 text-green-500"><svg class="w-6 h-6 mx-auto" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg></td>
                            </tr>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                <td class="py-4 px-6 text-sm font-medium">Réponses Automatisées (IA)</td>
                                <td class="text-center py-4 text-gray-300">-</td>
                                <td
                                    class="text-center py-4 bg-white dark:bg-gray-800 border-x-2 border-indigo-600 text-gray-300">
                                    -</td>
                                <td class="text-center py-4 text-green-500"><svg class="w-6 h-6 mx-auto" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg></td>
                            </tr>

                            {{-- SECTION: FIDÉLISATION (WALLET) --}}
                            {{-- SECTION: FIDÉLISATION (WALLET) --}}
                            <tr>
                                <td class="py-6 px-6 text-xs font-bold uppercase tracking-widest text-gray-500">
                                    Fidélisation & Wallet</td>
                                <td></td>
                                <td class="bg-white dark:bg-gray-800 border-x-2 border-indigo-600"></td>
                                <td></td>
                            </tr>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                <td class="py-4 px-6 text-sm font-medium">Cartes de Fidélité Digitales</td>
                                <td class="text-center py-4 text-gray-300">-</td>
                                <td
                                    class="text-center py-4 bg-white dark:bg-gray-800 border-x-2 border-indigo-600 text-green-500">
                                    <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </td>
                                <td class="text-center py-4 text-green-500"><svg class="w-6 h-6 mx-auto" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg></td>
                            </tr>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                <td class="py-4 px-6 text-sm font-medium">Notifications Push (Geo-fencing)</td>
                                <td class="text-center py-4 text-gray-300">-</td>
                                <td
                                    class="text-center py-4 bg-white dark:bg-gray-800 border-x-2 border-indigo-600 text-green-500">
                                    <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </td>
                                <td class="text-center py-4 text-green-500"><svg class="w-6 h-6 mx-auto" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg></td>
                            </tr>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                <td class="py-4 px-6 text-sm font-medium">CRM Client</td>
                                <td class="text-center py-4 text-gray-300">Basic</td>
                                <td
                                    class="text-center py-4 bg-white dark:bg-gray-800 border-x-2 border-indigo-600 font-bold text-indigo-600">
                                    Avancé</td>
                                <td class="text-center py-4 font-bold text-indigo-600">Expert</td>
                            </tr>

                            {{-- SECTION: MARKETING AUTOMATION --}}
                            {{-- SECTION: MARKETING AUTOMATION --}}
                            <tr>
                                <td class="py-6 px-6 text-xs font-bold uppercase tracking-widest text-gray-500">
                                    Marketing & Automation</td>
                                <td></td>
                                <td class="bg-white dark:bg-gray-800 border-x-2 border-indigo-600"></td>
                                <td></td>
                            </tr>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                <td class="py-4 px-6 text-sm font-medium">Campagnes SMS Marketing</td>
                                <td class="text-center py-4 text-gray-300">-</td>
                                <td
                                    class="text-center py-4 bg-white dark:bg-gray-800 border-x-2 border-indigo-600 text-gray-300">
                                    -</td>
                                <td class="text-center py-4 text-green-500"><svg class="w-6 h-6 mx-auto" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg></td>
                            </tr>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                <td class="py-4 px-6 text-sm font-medium">Support Client</td>
                                <td class="text-center py-4 text-sm">Email 48h</td>
                                <td
                                    class="text-center py-4 bg-white dark:bg-gray-800 border-x-2 border-indigo-600 border-b-2 rounded-b-xl text-sm font-bold">
                                    Chat & Email 24h</td>
                                <td class="text-center py-4 text-sm font-bold">Dédié + Téléphone</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>