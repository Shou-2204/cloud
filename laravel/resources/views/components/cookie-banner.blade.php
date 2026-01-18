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
}" x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
    x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
    class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm"
    style="display: none;">

    <div
        class="w-full max-w-lg bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-100 dark:border-gray-700 p-6 flex flex-col gap-6 transform transition-all">

        <div class="text-center">
            <div
                class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-emerald-100 dark:bg-emerald-900/30 mb-4">
                <span class="text-2xl">🍪</span>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                On utilise des cookies
            </h3>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                Nous utilisons des cookies pour améliorer votre expérience utilisateur et réaliser des statistiques de
                visites.
            </p>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <button @click="refuse()"
                class="w-full sm:w-auto px-5 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-xl transition-colors">
                Continuer sans accepter
            </button>
            <button @click="accept()"
                class="w-full sm:w-auto px-5 py-2.5 text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-500 rounded-xl shadow-lg shadow-emerald-500/20 transition-all transform hover:-translate-y-0.5">
                Tout accepter
            </button>
        </div>
    </div>
</div>