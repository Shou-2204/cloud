<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 dark:bg-gray-900 text-gray-700 dark:text-gray-200">
        <div class="text-6xl font-extrabold text-red-600 opacity-50">500</div>
        <h1 class="text-3xl font-bold mt-4">Erreur Serveur</h1>
        <p class="mt-2 text-lg text-center max-w-md text-gray-500 dark:text-gray-400">
            Oups, quelque chose s'est mal passé de notre côté. Nos serveurs rencontrent un problème technique.
        </p>
        <div class="mt-8">
            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 rounded-md hover:opacity-80 transition">
                Réessayer
            </a>
        </div>
    </div>
</x-guest-layout>