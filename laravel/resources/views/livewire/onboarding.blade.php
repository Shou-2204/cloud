<div>
    {{-- Le Header doit être défini ici, dans la racine --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Bienvenue sur') }} {{ config('app.name') }}
        </h2>
    </x-slot>

    {{-- Contenu principal avec gestion de la hauteur pour éviter la barre blanche --}}
    <div class="relative py-12 min-h-[calc(100vh-4rem)] flex flex-col justify-center overflow-hidden">

        {{-- Effet Blob Flou --}}
        <div
            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-indigo-500/20 dark:bg-indigo-600/10 blur-[100px] rounded-full -z-10 pointer-events-none">
        </div>

        <div class="max-w-4xl w-full mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-8 relative z-10">

            {{-- CARTE 1 : CRÉER --}}
            <div
                class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 flex flex-col justify-between hover:border-indigo-300 dark:hover:border-indigo-700 transition-all duration-300">
                <div>
                    <div
                        class="h-12 w-12 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg flex items-center justify-center mb-6 text-indigo-600 dark:text-indigo-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-7">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Créer une organisation</h2>
                    <p class="text-gray-500 dark:text-gray-400 mb-6 leading-relaxed">
                        Fondez votre propre espace de travail. Vous serez l'administrateur unique.
                    </p>
                </div>

                <form wire:submit.prevent="createTeam" class="mt-4">
                    <label for="newTeamName" class="sr-only">Nom</label>
                    <div class="relative">
                        <input type="text" id="newTeamName" wire:model="newTeamName"
                            class="block w-full rounded-md border-0 py-2.5 px-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:bg-gray-900 dark:ring-gray-700 dark:text-white dark:focus:ring-indigo-500 sm:text-sm sm:leading-6"
                            placeholder="Nom de votre organisation">
                    </div>
                    @error('newTeamName') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror

                    <button type="submit"
                        class="mt-4 w-full flex justify-center py-2.5 px-4 border border-transparent rounded-md shadow-sm text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 transition-colors">
                        Créer et Démarrer
                    </button>
                </form>
            </div>

            {{-- CARTE 2 : REJOINDRE --}}
            <div
                class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 flex flex-col justify-between hover:border-indigo-300 dark:hover:border-indigo-700 transition-all duration-300">
                <div>
                    <div
                        class="h-12 w-12 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center mb-6 text-gray-600 dark:text-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-7">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Rejoindre une organisation</h2>
                    <p class="text-gray-500 dark:text-gray-400 mb-6 leading-relaxed">
                        Vous avez reçu un code d'invitation ? Entrez-le ci-dessous.
                    </p>
                </div>

                <form wire:submit.prevent="joinTeam" class="mt-4">
                    <label for="joinCode" class="sr-only">Code</label>
                    <div class="relative">
                        <input type="text" id="joinCode" wire:model="joinCode"
                            class="block w-full rounded-md border-0 py-2.5 px-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 dark:bg-gray-900 dark:ring-gray-700 dark:text-white dark:focus:ring-indigo-500 sm:text-sm sm:leading-6 uppercase tracking-widest font-mono"
                            placeholder="X8J2P...">
                    </div>
                    @error('joinCode') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror

                    <button type="submit"
                        class="mt-4 w-full flex justify-center py-2.5 px-4 border border-transparent rounded-md shadow-sm text-sm font-semibold text-white bg-gray-900 hover:bg-gray-800 dark:bg-gray-700 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-colors">
                        Rejoindre
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>