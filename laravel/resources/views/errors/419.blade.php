<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 dark:bg-gray-900 text-gray-700 dark:text-gray-200">
        <div class="text-6xl font-extrabold text-yellow-500 opacity-50">419</div>
        <h1 class="text-3xl font-bold mt-4">Page Expirée</h1>
        <p class="mt-2 text-lg text-center max-w-md text-gray-500 dark:text-gray-400">
            Votre session a expiré par inactivité. Veuillez rafraîchir la page et réessayer.
        </p>
        <div class="mt-8">
            <button onclick="window.location.reload()" class="px-4 py-2 bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 rounded-md hover:opacity-80 transition">
                Rafraîchir la page
            </button>
        </div>
    </div>
</x-guest-layout>