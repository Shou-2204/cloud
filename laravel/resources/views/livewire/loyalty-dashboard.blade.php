<div>
    <div class="max-w-7xl mx-auto">
        {{-- Page Header --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Fidélité</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Gérez votre programme de fidélité et retrouvez vos clients</p>
        </div>

        {{-- Boxes Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- BOX 1: Retrouver un client --}}
            <a href="{{ route('loyalty.search') }}" wire:navigate
                class="group bg-white dark:bg-emerald-dark-500 rounded-2xl shadow-lg border border-gray-100 dark:border-emerald-dark-400 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="p-8 flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-emerald-100 dark:bg-emerald-900/50 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Retrouver un client</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6 max-w-xs">
                        Recherchez un client par nom, email, téléphone ou scannez un code-barres / QR code.
                    </p>
                    <div class="w-full px-6 py-3 bg-gradient-to-r from-emerald-600 to-teal-500 text-white font-semibold rounded-xl flex items-center justify-center gap-2 group-hover:from-emerald-500 group-hover:to-teal-400 transition-all">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Rechercher
                    </div>
                </div>
            </a>

            {{-- BOX 2: Ajouter un client --}}
            <a href="{{ route('loyalty.add-client') }}" wire:navigate
                class="group bg-white dark:bg-emerald-dark-500 rounded-2xl shadow-lg border border-gray-100 dark:border-emerald-dark-400 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="p-8 flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900/50 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Ajouter un client</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6 max-w-xs">
                        Inscrivez un nouveau client et associez une carte de fidélité vierge via scan.
                    </p>
                    <div class="w-full px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-500 text-white font-semibold rounded-xl flex items-center justify-center gap-2 group-hover:from-blue-500 group-hover:to-indigo-400 transition-all">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Nouveau client
                    </div>
                </div>
            </a>

        </div>
    </div>
</div>
