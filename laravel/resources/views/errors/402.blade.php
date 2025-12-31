<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 dark:bg-gray-900 text-gray-700 dark:text-gray-200">
        <div class="text-6xl font-extrabold text-indigo-500 opacity-50">402</div>
        <h1 class="text-3xl font-bold mt-4">Paiement Requis</h1>
        <p class="mt-2 text-lg text-center max-w-md text-gray-500 dark:text-gray-400">
            Le paiement est nécessaire pour accéder à cette fonctionnalité. Veuillez mettre à jour vos informations de facturation.
        </p>
        <div class="mt-8">
            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-indigo-600 rounded-md text-white hover:bg-indigo-500 transition">
                Gérer mon abonnement
            </a>
        </div>
    </div>
</x-guest-layout>