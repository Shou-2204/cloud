<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- WELCOME HERO --}}
            <div class="mb-10 text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white tracking-tight mb-4">
                    Bienvenue, <span
                        class="bg-clip-text text-transparent bg-gradient-to-r from-emerald-500 to-teal-400">{{ Auth::user()->name }}</span>.
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    Gérez vos équipes, vos abonnements et accédez à tout votre univers ShouCloud depuis cet espace
                    unifié.
                </p>
            </div>

            {{-- SEARCH BAR --}}
            <div class="max-w-2xl mx-auto mb-16 relative z-20">
                <livewire:global-search />
            </div>

            {{-- DASHBOARD GRID (ALIGNED) --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                {{-- CARD 1: ACTIVE TEAM --}}
                <div
                    class="bg-white dark:bg-emerald-dark-500 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-emerald-dark-600 hover:shadow-md transition-all">
                    <div class="flex flex-col h-full justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Équipe</h3>
                            <div class="font-bold text-xl text-gray-900 dark:text-white truncate">
                                {{ Auth::user()->currentTeam ? Auth::user()->currentTeam->name : 'Aucune' }}
                            </div>
                        </div>
                        <div class="mt-4">
                            @if(Auth::user()->currentTeam)
                                <a href="{{ route('teams.show', Auth::user()->currentTeam) }}"
                                    class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">
                                    Gérer
                                </a>
                            @else
                                <a href="{{ route('teams.create') }}"
                                    class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">
                                    Créer
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- CARD 2: PROFILE --}}
                <div
                    class="bg-white dark:bg-emerald-dark-500 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-emerald-dark-600 hover:shadow-md transition-all">
                    <div class="flex flex-col h-full justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Profil</h3>
                            <div class="font-bold text-xl text-gray-900 dark:text-white truncate">
                                {{ Auth::user()->name }}
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('profile.show') }}"
                                class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">
                                Modifier
                            </a>
                        </div>
                    </div>
                </div>

                {{-- CARD 3: OFFER --}}
                <div
                    class="bg-white dark:bg-emerald-dark-500 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-emerald-dark-600 hover:shadow-md transition-all">
                    <div class="flex flex-col h-full justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Offre</h3>
                            <div class="font-bold text-xl text-gray-900 dark:text-white">
                                @if(Auth::user()->currentTeam && Auth::user()->currentTeam->subscribed())
                                    Premium
                                @else
                                    Gratuit
                                @endif
                            </div>
                        </div>
                        <div class="mt-4">
                            @if(Auth::user()->currentTeam && Auth::user()->currentTeam->subscribed())
                                <a href="{{ route('subscription.show', Auth::user()->currentTeam) }}"
                                    class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">
                                    Gérer
                                </a>
                            @else
                                <a href="{{ route('subscription.index') }}"
                                    class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">
                                    Passer Premium
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- CARD 4: STATUS --}}
                <div
                    class="bg-white dark:bg-emerald-dark-500 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-emerald-dark-600 hover:shadow-md transition-all">
                    <div class="flex flex-col h-full justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Statut du compte</h3>
                            <div class="flex items-center gap-2">
                                <div class="h-2.5 w-2.5 rounded-full bg-emerald-500 animate-pulse"></div>
                                <span class="font-bold text-xl text-gray-900 dark:text-white">Actif</span>
                            </div>
                        </div>
                        <div class="mt-4">
                            <span class="text-xs text-gray-400">Tout fonctionne</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>