<x-app-layout>
    <div x-data="{ 
            annual: false,
            plans: {
                starter: { 
                    monthly: '{{ config('services.stripe.plans.starter.monthly') }}', 
                    yearly:  '{{ config('services.stripe.plans.starter.yearly') }}' 
                },
                smart: { 
                    monthly: '{{ config('services.stripe.plans.smart.monthly') }}', 
                    yearly:  '{{ config('services.stripe.plans.smart.yearly') }}' 
                },
                pro: { 
                    monthly: '{{ config('services.stripe.plans.pro.monthly') }}', 
                    yearly:  '{{ config('services.stripe.plans.pro.yearly') }}' 
                }
            }
         }" class="relative min-h-screen bg-gray-50 dark:bg-gray-950 py-20 overflow-hidden font-sans">

        <div
            class="absolute top-0 left-1/2 -translate-x-1/2 w-[1000px] h-[600px] bg-indigo-600/20 dark:bg-indigo-500/10 rounded-full blur-[100px] pointer-events-none -z-10">
        </div>
        <div
            class="absolute bottom-0 right-0 w-[800px] h-[600px] bg-purple-600/10 dark:bg-purple-900/10 rounded-full blur-[120px] pointer-events-none -z-10">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2
                    class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-gray-900 to-gray-600 dark:from-white dark:to-gray-400 sm:text-5xl tracking-tight">
                    Des tarifs clairs, <br>une puissance illimitée.
                </h2>
                <p class="mt-6 text-xl text-gray-600 dark:text-gray-400">
                    Choisissez l'offre qui correspond à votre ambition. Changez d'avis à tout moment.
                </p>
            </div>

            <div class="flex justify-center items-center mb-16">
                <div
                    class="bg-white dark:bg-slate-900 p-1.5 rounded-full border border-gray-200 dark:border-slate-800 flex items-center shadow-sm">
                    <button @click="annual = false"
                        class="px-6 py-2 rounded-full text-sm font-semibold transition-all duration-300"
                        :class="!annual ? 'bg-indigo-600 text-white shadow-md' : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white'">
                        Mensuel
                    </button>
                    <button @click="annual = true"
                        class="px-6 py-2 rounded-full text-sm font-semibold transition-all duration-300 flex items-center"
                        :class="annual ? 'bg-indigo-600 text-white shadow-md' : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white'">
                        Annuel
                        <span
                            class="ml-2 bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 text-[10px] uppercase font-bold px-2 py-0.5 rounded-full">
                            -20%
                        </span>
                    </button>
                </div>
            </div>

            <div class="grid gap-8 lg:grid-cols-3 lg:gap-8 items-stretch max-w-7xl mx-auto">

                <div
                    class="group relative bg-white dark:bg-slate-900/80 backdrop-blur-xl rounded-[2rem] border border-gray-200 dark:border-slate-800 p-8 flex flex-col hover:shadow-2xl hover:shadow-gray-200/50 dark:hover:shadow-indigo-900/10 transition-all duration-500 hover:-translate-y-2">
                    <div class="mb-6">
                        <span
                            class="inline-block p-3 rounded-2xl bg-gray-100 dark:bg-slate-800 text-gray-900 dark:text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Starter</h3>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Idéal pour démarrer proprement.</p>

                    <div class="my-8 flex items-baseline">
                        <span class="text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight"
                            x-text="annual ? '490€ HT' : '49€ HT'"></span>
                        <span class="ml-2 text-sm font-medium text-gray-500 dark:text-gray-400"
                            x-text="annual ? '/an' : '/mois'"></span>
                    </div>

                    <ul class="space-y-4 mb-8 flex-1">
                        <li class="flex items-start text-gray-600 dark:text-gray-300 text-sm">
                            <svg class="h-5 w-5 text-indigo-500 mr-3 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Jusqu'à 5 membres
                        </li>
                        <li class="flex items-start text-gray-600 dark:text-gray-300 text-sm">
                            <svg class="h-5 w-5 text-indigo-500 mr-3 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Stockage 10 Go
                        </li>
                        <li class="flex items-start text-gray-600 dark:text-gray-300 text-sm">
                            <svg class="h-5 w-5 text-indigo-500 mr-3 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Support par email
                        </li>
                    </ul>

                    <a :href="'/subscribe/' + (annual ? plans.starter.yearly : plans.starter.monthly)"
                        class="block w-full py-3 px-6 text-center rounded-xl bg-gray-50 dark:bg-slate-800 text-gray-900 dark:text-white font-semibold hover:bg-gray-100 dark:hover:bg-slate-700 transition duration-200">
                        Choisir Starter
                    </a>
                </div>

                <div class="relative group transform lg:scale-110 z-20">
                    <div
                        class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-[2.2rem] blur opacity-25 group-hover:opacity-60 transition duration-500">
                    </div>

                    <div
                        class="relative h-full bg-gradient-to-b from-indigo-500 to-purple-600 rounded-[2.1rem] p-[2px]">
                        <div
                            class="h-full bg-white dark:bg-slate-900 rounded-[2rem] p-8 flex flex-col relative overflow-hidden">

                            <div class="absolute top-0 right-0">
                                <div
                                    class="bg-gradient-to-bl from-indigo-500 to-purple-600 text-white text-[10px] font-bold px-4 py-1.5 rounded-bl-2xl uppercase tracking-wider shadow-lg">
                                    Recommandé
                                </div>
                            </div>

                            <div class="mb-6">
                                <span
                                    class="inline-block p-3 rounded-2xl bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                                        </path>
                                    </svg>
                                </span>
                            </div>

                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Smart</h3>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Le parfait équilibre pour la
                                croissance.</p>

                            <div class="my-8 flex items-baseline">
                                <span
                                    class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600 dark:from-indigo-400 dark:to-purple-400 tracking-tight"
                                    x-text="annual ? '790€ HT' : '79€ HT'"></span>
                                <span class="ml-2 text-lg font-medium text-gray-500 dark:text-gray-400"
                                    x-text="annual ? '/an' : '/mois'"></span>
                            </div>

                            <ul class="space-y-4 mb-8 flex-1">
                                <li class="flex items-start text-gray-900 dark:text-white font-medium text-sm">
                                    <div class="p-0.5 rounded-full bg-indigo-100 dark:bg-indigo-900/50 mr-3 shrink-0">
                                        <svg class="h-4 w-4 text-indigo-600 dark:text-indigo-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    Jusqu'à 20 membres
                                </li>
                                <li class="flex items-start text-gray-900 dark:text-white font-medium text-sm">
                                    <div class="p-0.5 rounded-full bg-indigo-100 dark:bg-indigo-900/50 mr-3 shrink-0">
                                        <svg class="h-4 w-4 text-indigo-600 dark:text-indigo-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    Stockage 500 Go
                                </li>
                                <li class="flex items-start text-gray-900 dark:text-white font-medium text-sm">
                                    <div class="p-0.5 rounded-full bg-indigo-100 dark:bg-indigo-900/50 mr-3 shrink-0">
                                        <svg class="h-4 w-4 text-indigo-600 dark:text-indigo-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    Support Prioritaire
                                </li>
                            </ul>

                            <a :href="'/subscribe/' + (annual ? plans.smart.yearly : plans.smart.monthly)"
                                class="block w-full py-4 px-6 text-center rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold shadow-lg shadow-indigo-500/30 hover:shadow-indigo-500/50 hover:scale-[1.02] transition-all duration-200">
                                Je passe au niveau supérieur
                            </a>
                        </div>
                    </div>
                </div>

                <div
                    class="group relative bg-white dark:bg-slate-900/80 backdrop-blur-xl rounded-[2rem] border border-gray-200 dark:border-slate-800 p-8 flex flex-col hover:shadow-2xl hover:shadow-gray-200/50 dark:hover:shadow-indigo-900/10 transition-all duration-500 hover:-translate-y-2">
                    <div class="mb-6">
                        <span
                            class="inline-block p-3 rounded-2xl bg-gray-100 dark:bg-slate-800 text-gray-900 dark:text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                        </span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Pro</h3>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Pour les équipes structurées.</p>

                    <div class="my-8 flex items-baseline">
                        <span class="text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight"
                            x-text="annual ? '1490€ HT' : '149€ HT'"></span>
                        <span class="ml-2 text-sm font-medium text-gray-500 dark:text-gray-400"
                            x-text="annual ? '/an' : '/mois'"></span>
                    </div>

                    <ul class="space-y-4 mb-8 flex-1">
                        <li class="flex items-start text-gray-600 dark:text-gray-300 text-sm">
                            <svg class="h-5 w-5 text-indigo-500 mr-3 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Membres illimités
                        </li>
                        <li class="flex items-start text-gray-600 dark:text-gray-300 text-sm">
                            <svg class="h-5 w-5 text-indigo-500 mr-3 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Stockage 2 To
                        </li>
                        <li class="flex items-start text-gray-600 dark:text-gray-300 text-sm">
                            <svg class="h-5 w-5 text-indigo-500 mr-3 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Manager Dédié
                        </li>
                    </ul>

                    <a :href="'/subscribe/' + (annual ? plans.pro.yearly : plans.pro.monthly)"
                        class="block w-full py-3 px-6 text-center rounded-xl bg-gray-50 dark:bg-slate-800 text-gray-900 dark:text-white font-semibold hover:bg-gray-100 dark:hover:bg-slate-700 transition duration-200">
                        Choisir Pro
                    </a>
                </div>
            </div>

            <div class="mt-24 max-w-4xl mx-auto">
                <div
                    class="relative bg-indigo-900 rounded-3xl p-8 sm:p-12 overflow-hidden flex flex-col sm:flex-row items-center justify-between gap-8 shadow-2xl">
                    <div
                        class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-indigo-500 rounded-full blur-[80px] opacity-40">
                    </div>
                    <div
                        class="absolute bottom-0 left-0 -mb-10 -ml-10 w-64 h-64 bg-purple-500 rounded-full blur-[80px] opacity-40">
                    </div>

                    <div class="relative z-10 text-left">
                        <h3 class="text-2xl font-bold text-white mb-2">Besoins spécifiques ?</h3>
                        <p class="text-indigo-200 text-lg max-w-md">
                            Vous gérez une très grande structure ou avez des exigences de conformité particulières ?
                        </p>
                    </div>

                    <div class="relative z-10 shrink-0">
                        <a href="mailto:contact@shoucloud.com"
                            class="inline-flex items-center justify-center px-8 py-4 text-base font-bold text-indigo-900 transition-all duration-200 bg-white border border-transparent rounded-xl hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-indigo-900 focus:ring-white">
                            Obtenir un devis sur mesure
                            <svg class="w-5 h-5 ml-2 -mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                <p class="text-center text-gray-500 dark:text-gray-500 text-sm mt-8">
                    Tous les prix sont affichés hors taxes. TVA applicable selon votre pays de résidence.
                </p>
            </div>

        </div>
    </div>
</x-app-layout>