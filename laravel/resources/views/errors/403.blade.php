<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 dark:bg-gray-900 text-gray-700 dark:text-gray-200">
        
        <div class="flex items-center justify-center w-24 h-24 bg-red-100 dark:bg-red-900/30 rounded-full mb-4">
            <svg class="w-12 h-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
        </div>

        <div class="text-6xl font-extrabold text-gray-300 dark:text-gray-700">
            403
        </div>

        <h1 class="text-3xl font-bold mt-2 text-red-600 dark:text-red-400">
            Accès Interdit
        </h1>

        <p class="mt-4 text-lg text-center max-w-lg text-gray-500 dark:text-gray-400">
            {{ $exception->getMessage() ?: "Vous n'avez pas les permissions nécessaires pour accéder à cette page." }}
        </p>

        <div class="mt-8 space-x-4">
            <a href="{{ url()->previous() }}" class="text-gray-600 dark:text-gray-400 hover:underline">
                Page précédente
            </a>
            
            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                Accueil
            </a>
        </div>
    </div>
</x-guest-layout>