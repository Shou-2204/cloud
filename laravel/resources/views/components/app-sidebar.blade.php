<aside
    class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-emerald-dark-500 border-r border-gray-100 dark:border-emerald-dark-600 transform transition-transform duration-300 ease-in-out md:static md:translate-x-0"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

    <div class="flex flex-col h-full">
        {{-- PROFILE SECTION (TOP) --}}
        <div class="p-6 border-b border-gray-100 dark:border-emerald-dark-600 flex flex-col items-center text-center">
            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                <img class="h-20 w-20 rounded-full object-cover border-4 border-emerald-100 dark:border-emerald-900"
                    src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
            @endif
            <div class="mt-4">
                <h3 class="font-bold text-gray-900 dark:text-white">{{ Auth::user()->name }}</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</p>
            </div>
        </div>

        {{-- NAVIGATION LINKS (MIDDLE) --}}
        <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1">

            <a href="{{ route('dashboard') }}"
                class="flex items-center px-4 py-2 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('dashboard') ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/50 dark:text-emerald-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-emerald-dark-600 hover:text-gray-900 dark:hover:text-white' }}">
                <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                Dashboard
            </a>

            <a href="{{ route('profile.show') }}"
                class="flex items-center px-4 py-2 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('profile.show') ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/50 dark:text-emerald-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-emerald-dark-600 hover:text-gray-900 dark:hover:text-white' }}">
                <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Mon Profil
            </a>

            {{-- Team Section --}}
            @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        Équipe
                    </p>
                </div>

                @if(Auth::user()->currentTeam)
                    <a href="{{ route('teams.show', Auth::user()->currentTeam) }}"
                        class="flex items-center px-4 py-2 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('teams.show') ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/50 dark:text-emerald-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-emerald-dark-600 hover:text-gray-900 dark:hover:text-white' }}">
                        <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Paramètres Équipe
                    </a>

                    @if(Auth::user()->currentTeam->subscribed())
                        <a href="{{ route('subscription.show', Auth::user()->currentTeam) }}"
                            class="flex items-center px-4 py-2 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('subscription.show') ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/50 dark:text-emerald-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-emerald-dark-600 hover:text-gray-900 dark:hover:text-white' }}">
                            <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                            Mon Abonnement
                        </a>
                    @else
                        <a href="{{ route('subscription.index') }}"
                            class="flex items-center px-4 py-2 text-sm font-medium rounded-xl text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/20 hover:bg-emerald-100 dark:hover:bg-emerald-900/40">
                            <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Passer Premium
                        </a>
                    @endif
                @endif

                <a href="{{ route('teams.create') }}"
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('teams.create') ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/50 dark:text-emerald-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-emerald-dark-600 hover:text-gray-900 dark:hover:text-white' }}">
                    <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Créer une équipe
                </a>
            @endif

        </nav>

        {{-- LOGOUT (BOTTOM) --}}
        <div class="p-4 border-t border-gray-100 dark:border-emerald-dark-600">
            <form method="POST" action="{{ route('logout') }}" x-data>
                @csrf
                <a href="{{ route('logout') }}" @click.prevent="$root.submit();"
                    class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-red-600 bg-red-50 dark:bg-red-900/20 rounded-xl hover:bg-red-100 dark:hover:bg-red-900/40 transition-colors">
                    <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Se déconnecter
                </a>
            </form>
        </div>
    </div>
</aside>