<x-app-layout>
    <div class="relative min-h-screen bg-gray-100 dark:bg-gray-900 py-12 overflow-hidden">
        
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[800px] bg-indigo-500/30 dark:bg-indigo-600/20 rounded-full blur-3xl pointer-events-none -z-10 mix-blend-multiply dark:mix-blend-screen"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">
                    Choisissez le plan adapté à votre équipe
                </h2>
                <p class="mt-4 text-xl text-gray-600 dark:text-gray-400">
                    Débloquez tout le potentiel de ShouCloud dès aujourd'hui.
                </p>
            </div>

            <div class="grid gap-8 lg:grid-cols-3 lg:gap-8 max-w-7xl mx-auto">
                
                <div class="bg-white dark:bg-slate-950 rounded-2xl shadow-xl border border-gray-200 dark:border-slate-800 p-8 flex flex-col hover:border-indigo-500 transition-colors duration-300">
                    <div class="mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                            Démarrage
                        </span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Starter</h3>
                    <p class="mt-4 text-gray-500 dark:text-gray-400">L'essentiel pour commencer à structurer vos projets.</p>
                    <div class="my-8">
                        <span class="text-4xl font-extrabold text-gray-900 dark:text-white">49€</span>
                        <span class="text-base font-medium text-gray-500 dark:text-gray-400">/mois</span>
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
                    <a href="{{ route('subscription.checkout', config('services.stripe.plans.starter')) }}" class="block w-full py-3 px-6 text-center rounded-2xl shadow bg-indigo-600 hover:bg-indigo-500 text-white font-semibold transition duration-200">
                        Choisir Starter
                    </a>
                </div>

                <div class="bg-white dark:bg-slate-950 rounded-2xl shadow-xl border-2 border-indigo-500 dark:border-indigo-600 p-8 flex flex-col relative overflow-hidden transform scale-105 z-10">
                    <div class="absolute top-0 right-0 bg-indigo-600 text-white text-xs font-bold px-3 py-1 rounded-bl-lg uppercase tracking-wide">
                        Populaire
                    </div>
                    <div class="mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                            Entreprise
                        </span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Pro</h3>
                    <p class="mt-4 text-gray-500 dark:text-gray-400">Pour les équipes qui ont besoin de puissance.</p>
                    <div class="my-8">
                        <span class="text-4xl font-extrabold text-gray-900 dark:text-white">99€</span>
                        <span class="text-base font-medium text-gray-500 dark:text-gray-400">/mois</span>
                    </div>
                    <ul class="space-y-4 mb-8 flex-1">
                        <li class="flex items-center text-gray-600 dark:text-gray-300">
                            <svg class="h-5 w-5 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Membres illimités
                        </li>
                        <li class="flex items-center text-gray-600 dark:text-gray-300">
                            <svg class="h-5 w-5 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Stockage 1 To
                        </li>
                        <li class="flex items-center text-gray-600 dark:text-gray-300">
                            <svg class="h-5 w-5 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Support Prioritaire
                        </li>
                    </ul>
                    <a href="{{ route('subscription.checkout', config('services.stripe.plans.pro')) }}" class="block w-full py-3 px-6 text-center rounded-2xl shadow bg-gray-900 dark:bg-white hover:bg-gray-800 dark:hover:bg-gray-200 text-white dark:text-gray-900 font-semibold transition duration-200">
                        Choisir Pro
                    </a>
                </div>

                <div class="bg-white dark:bg-slate-950 rounded-2xl shadow-xl border border-gray-200 dark:border-slate-800 p-8 flex flex-col hover:border-indigo-500 transition-colors duration-300">
                    <div class="mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200">
                            Sur mesure
                        </span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Enterprise</h3>
                    <p class="mt-4 text-gray-500 dark:text-gray-400">Sécurité maximale et contrôle total.</p>
                    <div class="my-8">
                        <span class="text-4xl font-extrabold text-gray-900 dark:text-white">299€</span>
                        <span class="text-base font-medium text-gray-500 dark:text-gray-400">/mois</span>
                    </div>
                    <ul class="space-y-4 mb-8 flex-1">
                        <li class="flex items-center text-gray-600 dark:text-gray-300">
                            <svg class="h-5 w-5 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Tout illimité
                        </li>
                        <li class="flex items-center text-gray-600 dark:text-gray-300">
                            <svg class="h-5 w-5 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Audit Logs & SSO
                        </li>
                        <li class="flex items-center text-gray-600 dark:text-gray-300">
                            <svg class="h-5 w-5 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Manager Dédié
                        </li>
                    </ul>
                    <a href="{{ route('subscription.checkout', config('services.stripe.plans.enterprise')) }}" class="block w-full py-3 px-6 text-center rounded-2xl shadow bg-white dark:bg-slate-900 border border-gray-300 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-800 text-gray-900 dark:text-white font-semibold transition duration-200">
                        Choisir Enterprise
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>