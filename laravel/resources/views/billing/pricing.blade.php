<x-app-layout>
    <div x-data="{ 
            annual: false,
            plans: {
                starter: { monthly: '{{ config('services.stripe.plans.starter') }}', yearly: 'price_ID_STARTER_YEARLY_A_REMPLACER' },
                smart:   { monthly: '{{ config('services.stripe.plans.pro') }}',     yearly: 'price_ID_SMART_YEARLY_A_REMPLACER' },
                pro:     { monthly: '{{ config('services.stripe.plans.enterprise') }}', yearly: 'price_ID_PRO_YEARLY_A_REMPLACER' }
            }
         }" 
         class="relative min-h-screen bg-gray-100 dark:bg-gray-900 py-12 overflow-hidden">
        
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[800px] bg-indigo-500/30 dark:bg-indigo-600/20 rounded-full blur-3xl pointer-events-none -z-10 mix-blend-multiply dark:mix-blend-screen"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">
                    Choisissez le plan adapté à votre équipe
                </h2>
                <p class="mt-4 text-xl text-gray-600 dark:text-gray-400">
                    Débloquez tout le potentiel de ShouCloud dès aujourd'hui.
                </p>
            </div>

            <div class="flex justify-center items-center mb-12 space-x-4">
                <span class="text-base font-medium" :class="!annual ? 'text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400'">Mensuel</span>
                
                <button type="button" 
                        @click="annual = !annual" 
                        class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2"
                        :class="annual ? 'bg-indigo-600' : 'bg-gray-200 dark:bg-gray-700'"
                        role="switch" 
                        :aria-checked="annual">
                    <span aria-hidden="true" 
                          class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                          :class="annual ? 'translate-x-5' : 'translate-x-0'"></span>
                </button>

                <span class="text-base font-medium flex items-center" :class="annual ? 'text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400'">
                    Annuel 
                    <span class="ml-2 inline-flex items-center rounded-full bg-indigo-100 px-2.5 py-0.5 text-xs font-medium text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                        2 mois offerts
                    </span>
                </span>
            </div>

            <div class="grid gap-8 lg:grid-cols-3 lg:gap-8 max-w-7xl mx-auto items-start">
                
                <div class="bg-white dark:bg-slate-950 rounded-2xl shadow-xl border border-gray-200 dark:border-slate-800 p-8 flex flex-col hover:border-indigo-500 transition-colors duration-300">
                    <div class="mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200">
                            Démarrage
                        </span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Starter</h3>
                    <p class="mt-4 text-gray-500 dark:text-gray-400">Pour structurer vos premiers projets.</p>
                    <div class="my-8 flex items-baseline">
                        <span class="text-4xl font-extrabold text-gray-900 dark:text-white" x-text="annual ? '490€' : '49€'"></span>
                        <span class="ml-2 text-base font-medium text-gray-500 dark:text-gray-400" x-text="annual ? '/an' : '/mois'"></span>
                    </div>
                    <ul class="space-y-4 mb-8 flex-1">
                        <li class="flex items-center text-gray-600 dark:text-gray-300">
                            <svg class="h-5 w-5 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Jusqu'à 5 membres
                        </li>
                        <li class="flex items-center text-gray-600 dark:text-gray-300">
                            <svg class="h-5 w-5 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Stockage 10 Go
                        </li>
                    </ul>
                    <a :href="'/subscribe/' + (annual ? plans.starter.yearly : plans.starter.monthly)" 
                       class="block w-full py-3 px-6 text-center rounded-2xl shadow bg-white dark:bg-slate-900 border border-gray-300 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-800 text-gray-900 dark:text-white font-semibold transition duration-200">
                        Choisir Starter
                    </a>
                </div>

                <div class="relative bg-white dark:bg-slate-950 rounded-2xl shadow-2xl border-2 border-indigo-500 dark:border-indigo-500 p-8 flex flex-col transform lg:scale-105 z-10">
                    <div class="absolute top-0 inset-x-0 -mt-px h-1 bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-t-2xl"></div>
                    <div class="absolute top-0 right-0 bg-indigo-600 text-white text-xs font-bold px-3 py-1 rounded-bl-lg uppercase tracking-wide shadow-sm">
                        Recommandé
                    </div>
                    <div class="mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                            Croissance
                        </span>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white">Smart</h3>
                    <p class="mt-4 text-gray-500 dark:text-gray-400">Le meilleur rapport qualité/prix.</p>
                    <div class="my-8 flex items-baseline">
                        <span class="text-5xl font-extrabold text-indigo-600 dark:text-indigo-500" x-text="annual ? '790€' : '79€'"></span>
                        <span class="ml-2 text-lg font-medium text-gray-500 dark:text-gray-400" x-text="annual ? '/an' : '/mois'"></span>
                    </div>
                    <ul class="space-y-4 mb-8 flex-1">
                        <li class="flex items-center text-gray-900 dark:text-white font-medium">
                            <svg class="h-5 w-5 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Jusqu'à 20 membres
                        </li>
                        <li class="flex items-center text-gray-900 dark:text-white font-medium">
                            <svg class="h-5 w-5 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Stockage 500 Go
                        </li>
                        <li class="flex items-center text-gray-900 dark:text-white font-medium">
                            <svg class="h-5 w-5 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Support Prioritaire
                        </li>
                    </ul>
                    <a :href="'/subscribe/' + (annual ? plans.smart.yearly : plans.smart.monthly)" 
                       class="block w-full py-4 px-6 text-center rounded-2xl shadow-lg bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-lg transition duration-200 transform hover:-translate-y-1">
                        Choisir Smart
                    </a>
                </div>

                <div class="bg-white dark:bg-slate-950 rounded-2xl shadow-xl border border-gray-200 dark:border-slate-800 p-8 flex flex-col hover:border-indigo-500 transition-colors duration-300">
                    <div class="mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200">
                            Expert
                        </span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Pro</h3>
                    <p class="mt-4 text-gray-500 dark:text-gray-400">Puissance illimitée pour grandes équipes.</p>
                    <div class="my-8 flex items-baseline">
                        <span class="text-4xl font-extrabold text-gray-900 dark:text-white" x-text="annual ? '1490€' : '149€'"></span>
                        <span class="ml-2 text-base font-medium text-gray-500 dark:text-gray-400" x-text="annual ? '/an' : '/mois'"></span>
                    </div>
                    <ul class="space-y-4 mb-8 flex-1">
                        <li class="flex items-center text-gray-600 dark:text-gray-300">
                            <svg class="h-5 w-5 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Membres illimités
                        </li>
                        <li class="flex items-center text-gray-600 dark:text-gray-300">
                            <svg class="h-5 w-5 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Stockage 2 To
                        </li>
                        <li class="flex items-center text-gray-600 dark:text-gray-300">
                            <svg class="h-5 w-5 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Manager Dédié
                        </li>
                    </ul>
                    <a :href="'/subscribe/' + (annual ? plans.pro.yearly : plans.pro.monthly)" 
                       class="block w-full py-3 px-6 text-center rounded-2xl shadow bg-white dark:bg-slate-900 border border-gray-300 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-800 text-gray-900 dark:text-white font-semibold transition duration-200">
                        Choisir Pro
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>