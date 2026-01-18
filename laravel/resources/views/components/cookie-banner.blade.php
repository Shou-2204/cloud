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
    x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-4" class="fixed bottom-4 right-4 z-[100] max-w-sm w-full p-4"
    style="display: none;">

    <div
        class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-100 dark:border-gray-700 p-6 flex flex-col gap-4 transform transition-all">

        <div class="flex items-start gap-4">
            <div
                class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-full bg-emerald-100 dark:bg-emerald-900/30">
                <span class="text-xl">🍪</span>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                    On utilise des cookies
                </h3>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
                    Nous utilisons des cookies pour améliorer votre expérience et réaliser des statistiques.
                </p>
            </div>
        </div>

        <div class="flex gap-3 mt-2">
            <button @click="refuse()"
                class="flex-1 px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-xl transition-colors">
                Refuser
            </button>
            <button @click="accept()"
                class="flex-1 px-4 py-2 text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-500 rounded-xl shadow-lg shadow-emerald-500/20 transition-all transform hover:-translate-y-0.5">
                Accepter
            </button>
        </div>
    </div>
</div>