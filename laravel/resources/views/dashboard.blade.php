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

            {{-- BENTO GRID DASHBOARD --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 auto-rows-fr">

                {{-- CARD 1: ACTIVE TEAM (Large) --}}
                <div
                    class="md:col-span-3 relative group overflow-hidden bg-white dark:bg-emerald-dark-500 rounded-3xl p-8 shadow-sm border border-gray-100 dark:border-emerald-dark-600 hover:shadow-md transition-all duration-300">
                    <div class="absolute top-0 right-0 p-6 opacity-10 group-hover:opacity-20 transition-opacity">
                        <svg class="w-32 h-32 text-gray-900 dark:text-white" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>

                    <div class="relative z-10 flex flex-col h-full justify-between">
                        <div>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100/50 dark:bg-emerald-500/10 text-emerald-800 dark:text-emerald-400 mb-4">
                                Équipe Active
                            </span>
                            <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-1">
                                {{ Auth::user()->currentTeam ? Auth::user()->currentTeam->name : __('Aucune équipe') }}
                            </h3>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">
                                Membre depuis le {{ Auth::user()->created_at->format('d M Y') }}
                            </p>
                        </div>

                        <div class="mt-8 flex gap-3">
                            @if(Auth::user()->currentTeam)
                                <a href="{{ route('teams.show', Auth::user()->currentTeam) }}"
                                    class="inline-flex items-center justify-center px-5 py-2.5 border border-transparent text-sm font-medium rounded-xl text-white bg-gray-900 dark:bg-white dark:text-black hover:bg-gray-800 dark:hover:bg-gray-200 transition-colors">
                                    Paramètres d'équipe
                                </a>
                                @if(Auth::user()->currentTeam->subscribed())
                                    <a href="{{ route('subscription.show', Auth::user()->currentTeam) }}"
                                        class="inline-flex items-center justify-center px-5 py-2.5 border border-gray-200 dark:border-emerald-dark-600 text-sm font-medium rounded-xl text-gray-700 dark:text-gray-200 bg-white dark:bg-emerald-dark-600 hover:bg-gray-50 dark:hover:bg-emerald-dark-500 transition-colors">
                                        Abonnement
                                    </a>
                                @else
                                    <a href="{{ route('subscription.index') }}"
                                        class="inline-flex items-center justify-center px-5 py-2.5 border border-transparent text-sm font-medium rounded-xl text-white bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-700 hover:to-teal-600 shadow-lg shadow-emerald-500/20 transition-all">
                                        Passer Premium
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('teams.create') }}"
                                    class="inline-flex items-center justify-center px-5 py-2.5 border border-transparent text-sm font-medium rounded-xl text-white bg-emerald-600 hover:bg-emerald-700 transition-colors">
                                    Créer une équipe
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- CARD 2: QUICK STATS --}}
                <div
                    class="bg-white dark:bg-emerald-dark-500 rounded-3xl p-8 shadow-sm border border-gray-100 dark:border-emerald-dark-600 flex flex-col justify-center items-center text-center hover:shadow-md transition-all duration-300">
                    <div
                        class="p-3 bg-emerald-50 dark:bg-emerald-500/10 rounded-2xl mb-4 text-emerald-600 dark:text-emerald-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-8 h-8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                        </svg>
                    </div>
                    <span class="text-3xl font-bold text-gray-900 dark:text-white">Actif</span>
                    <span class="text-sm text-gray-500 dark:text-gray-400 mt-1">Statut du compte</span>
                </div>

                {{-- CARD 3: PENDING TEAMS (Conditional) --}}
                @php
                    $pendingTeams = Auth::user()->teams()->wherePivot('is_approved', 0)->get();
                @endphp

                @if($pendingTeams->isNotEmpty())
                    <div
                        class="md:col-span-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-700/50 rounded-3xl p-6 flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-amber-800 dark:text-amber-200">
                                Invitations en attente
                            </h3>
                            <p class="mt-1 text-sm text-amber-700 dark:text-amber-300">
                                Vous avez des invitations en attente pour :
                                <span class="font-medium">
                                    {{ $pendingTeams->pluck('name')->join(', ') }}
                                </span>
                            </p>
                        </div>
                    </div>
                @endif

                {{-- QUICK LINKS GRID --}}
                <div class="md:col-span-4 grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                    <a href="{{ route('profile.show') }}"
                        class="group bg-white dark:bg-emerald-dark-500 border border-gray-100 dark:border-emerald-dark-600 rounded-2xl p-6 hover:border-emerald-500 dark:hover:border-emerald-500 transition-all duration-300">
                        <div
                            class="text-gray-400 dark:text-gray-500 group-hover:text-emerald-500 transition-colors mb-3">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-900 dark:text-white">Mon Profil</h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Gérer vos informations</p>
                    </a>



                    {{-- Add more quick links as needed --}}

                </div>

            </div>
        </div>
    </div>
</x-app-layout>