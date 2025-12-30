<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 relative overflow-hidden">
        {{-- Effet Blob Flou d'arrière-plan --}}
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[600px] bg-indigo-500/10 dark:bg-indigo-600/10 blur-[100px] rounded-full -z-10 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-10">
            
            {{-- LOGIQUE PHP : Récupération des équipes en attente --}}
            @php
                $pendingTeams = Auth::user()->teams()
                    ->wherePivot('is_approved', 0)
                    ->get();
            @endphp

            {{-- SECTION ALERTE : Design optimisé Dark Mode --}}
            @if($pendingTeams->isNotEmpty())
                <div class="mb-6 bg-yellow-50 dark:bg-yellow-900/30 border border-yellow-200 dark:border-yellow-700 rounded-2xl p-4 shadow-sm backdrop-blur-sm transition-colors duration-300">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400 dark:text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm leading-5 font-medium text-yellow-800 dark:text-yellow-100">
                                {{ __('Demandes d\'adhésion en attente') }}
                            </h3>
                            <div class="mt-2 text-sm leading-5 text-yellow-700 dark:text-yellow-200">
                                <p>{{ __('Vous avez demandé à rejoindre les équipes suivantes. Vous devez attendre la validation par un administrateur :') }}</p>
                                <ul class="list-disc list-inside mt-2">
                                    @foreach($pendingTeams as $team)
                                        <li class="font-bold">{{ $team->name }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- CARTE PRINCIPALE --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-2xl border border-gray-200 dark:border-gray-700 transition-colors duration-300">
                
                <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <h1 class="mt-2 text-2xl font-medium text-gray-900 dark:text-white">
                        Bienvenue, <span class="text-indigo-600 dark:text-indigo-400 font-bold">{{ Auth::user()->name }}</span> !
                    </h1>

                    <p class="mt-6 text-gray-500 dark:text-gray-400 leading-relaxed">
                        {{ __('Bienvenue sur votre interface ShouCloud. Voici votre tableau de bord centralisé pour gérer vos projets et votre équipe.') }}
                    </p>
                </div>

                <div class="bg-gray-50 dark:bg-gray-800/50 grid grid-cols-1 md:grid-cols-2 gap-6 p-6 lg:p-8">
                    
                    {{-- Bloc Équipe Actuelle --}}
                    <div class="flex items-center space-x-4 p-4 rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 shadow-sm transition-colors duration-300">
                        <div class="p-3 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg text-indigo-600 dark:text-indigo-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Équipe Actuelle') }}</div>
                            <div class="text-lg font-bold text-gray-900 dark:text-white">
                                {{ Auth::user()->currentTeam ? Auth::user()->currentTeam->name : 'Aucune' }}
                            </div>
                        </div>
                    </div>

                    {{-- Bloc Statut Compte --}}
                    <div class="flex items-center space-x-4 p-4 rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 shadow-sm transition-colors duration-300">
                        <div class="p-3 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg text-indigo-600 dark:text-indigo-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Statut Compte') }}</div>
                            <div class="text-lg font-bold text-gray-900 dark:text-white">{{ __('Actif') }}</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>