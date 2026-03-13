<div>
    <div class="max-w-7xl mx-auto">
        {{-- Page Header --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Campagne Marketing</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Créez des campagnes pour relancer et fidéliser vos clients</p>
        </div>

        {{-- Boxes Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- BOX 1: Campagne Email --}}
            <div class="group bg-white dark:bg-emerald-dark-500 rounded-2xl shadow-lg border border-gray-100 dark:border-emerald-dark-400 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="p-8 flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900/30 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Campagne Email</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6 max-w-xs">
                        Envoyez des emails personnalisés à vos clients pour les informer de vos offres et promotions.
                    </p>
                    <button disabled
                        class="w-full px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl opacity-50 cursor-not-allowed flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Créer une campagne email
                    </button>
                    <p class="mt-3 text-xs text-gray-400">Bientôt disponible</p>
                </div>
            </div>

            {{-- BOX 2: Campagne SMS --}}
            <div class="group bg-white dark:bg-emerald-dark-500 rounded-2xl shadow-lg border border-gray-100 dark:border-emerald-dark-400 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="p-8 flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-purple-100 dark:bg-purple-900/30 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Campagne SMS</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6 max-w-xs">
                        Envoyez des SMS ciblés à vos clients pour les relancer avec des offres personnalisées.
                    </p>
                    <button disabled
                        class="w-full px-6 py-3 bg-purple-600 text-white font-semibold rounded-xl opacity-50 cursor-not-allowed flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Créer une campagne SMS
                    </button>
                    <p class="mt-3 text-xs text-gray-400">Bientôt disponible</p>
                </div>
            </div>

            {{-- BOX 3: Campagne Apple Wallet --}}
            <div class="group bg-white dark:bg-emerald-dark-500 rounded-2xl shadow-lg border border-gray-100 dark:border-emerald-dark-400 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="p-8 flex flex-col items-center text-center h-full">
                    <div class="w-16 h-16 bg-emerald-100 dark:bg-emerald-900/30 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Campagne Apple Wallet</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6 max-w-xs">
                        Envoyez une notification avec un message personnalisé qui s'affichera directement sur l'écran verrouillé de vos clients.
                    </p>
                    <a href="{{ route('campaigns.wallet') }}"
                        class="w-full px-6 py-3 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold rounded-xl flex items-center justify-center gap-2 transition-colors shadow-lg shadow-emerald-500/20">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Créer une campagne Wallet
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
