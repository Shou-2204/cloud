<div x-data="{ 
    show: !localStorage.getItem('cookieconfig'),
    accept() {
        localStorage.setItem('cookieconfig', 'accepted');
        this.show = false;
        // Reload to trigger GTM/Analytics scripts that check localStorage
        window.location.reload();
    },
    refuse() {
        localStorage.setItem('cookieconfig', 'refused');
        this.show = false;
    }
}" x-show="show" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="translate-y-full opacity-0" x-transition:enter-end="translate-y-0 opacity-100"
    x-transition:leave="transition ease-in duration-300" x-transition:leave-start="translate-y-0 opacity-100"
    x-transition:leave-end="translate-y-full opacity-0" class="fixed bottom-0 left-0 right-0 z-[60] p-4 md:p-6"
    style="display: none;">

    <div
        class="max-w-4xl mx-auto bg-white/95 dark:bg-gray-800/95 backdrop-blur-md rounded-2xl shadow-2xl border border-gray-100 dark:border-gray-700 p-6 md:flex md:items-center md:justify-between gap-6">

        <div class="flex-1">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                🍪 On utilise des cookies
            </h3>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                Nous utilisons des cookies pour améliorer votre expérience utilisateur et réaliser des statistiques de
                visites.
                Votre vie privée compte pour nous.
            </p>
        </div>

        <div class="mt-4 md:mt-0 flex flex-col sm:flex-row gap-3">
            <button @click="refuse()"
                class="px-5 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-xl transition-colors">
                Continuer sans accepter
            </button>
            <button @click="accept()"
                class="px-5 py-2.5 text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-500 rounded-xl shadow-lg shadow-emerald-500/20 transition-all transform hover:-translate-y-0.5">
                Tout accepter
            </button>
        </div>
    </div>
</div>