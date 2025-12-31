<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 dark:bg-gray-900 text-gray-700 dark:text-gray-200">
        <div class="text-6xl font-extrabold text-orange-500 opacity-50">429</div>
        <h1 class="text-3xl font-bold mt-4">Trop de requêtes</h1>
        <p class="mt-2 text-lg text-center max-w-md text-gray-500 dark:text-gray-400">
            Vous avez envoyé trop de requêtes en peu de temps. Veuillez patienter un instant.
        </p>
        <div class="mt-8">
            <a href="{{ route('dashboard') }}" class="text-indigo-500 hover:underline">Retour à l'accueil</a>
        </div>
    </div>
</x-guest-layout>