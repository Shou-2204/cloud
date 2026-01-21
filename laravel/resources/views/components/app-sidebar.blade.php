<aside
    class="fixed inset-y-0 left-0 z-50 flex flex-col bg-white dark:bg-emerald-dark-500 border-r border-gray-100 dark:border-emerald-dark-600 transform transition-all duration-300 ease-in-out md:static"
    :class="{
        'translate-x-0': sidebarOpen,
        '-translate-x-full': !sidebarOpen,
        'w-64': !sidebarCollapsed,
        'w-20': sidebarCollapsed,
        'md:translate-x-0': true
    }">

    {{-- HEADER / TOGGLE (Mobile only close / Desktop toggle) --}}
    <div class="h-16 flex items-center justify-between px-4 border-b border-gray-100 dark:border-emerald-dark-600">
        {{-- Mobile Close --}}
        <button @click="sidebarOpen = false"
            class="md:hidden text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline-none">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        {{-- Desktop Collapse Toggle (Using the logo area or separate button) --}}
        <div class="hidden md:flex w-full items-center" :class="sidebarCollapsed ? 'justify-center' : 'justify-end'">
            <button @click="sidebarCollapsed = !sidebarCollapsed"
                class="text-gray-400 hover:text-emerald-600 transition-colors focus:outline-none p-1 rounded-md hover:bg-gray-100 dark:hover:bg-emerald-900/50">
                <svg x-show="!sidebarCollapsed" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                </svg>
                <svg x-show="sidebarCollapsed" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    style="display: none;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </div>


    <div class="flex flex-col h-full overflow-hidden">
        {{-- PROFILE SECTION (TOP) --}}
        <div
            class="p-4 border-b border-gray-100 dark:border-emerald-dark-600 flex flex-col items-center text-center transition-all duration-300">
            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                <img x-show="!sidebarCollapsed"
                    class="h-20 w-20 rounded-full object-cover border-4 border-emerald-100 dark:border-emerald-900 transition-all duration-300"
                    src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
            @endif
            <div class="mt-4 overflow-hidden whitespace-nowrap" x-show="!sidebarCollapsed"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100">
                <h3 class="font-bold text-gray-900 dark:text-white text-sm">{{ Auth::user()->name }}</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 truncate max-w-[12rem] mx-auto">
                    {{ Auth::user()->email }}
                </p>
            </div>
        </div>

        {{-- NAVIGATION LINKS (MIDDLE) --}}
        <nav class="flex-1 overflow-y-auto overflow-x-hidden py-6 px-3 space-y-1">

            <a href="{{ route('dashboard') }}" wire:navigate
                class="flex items-center px-3 py-2 text-sm font-medium rounded-xl transition-colors group relative {{ request()->routeIs('dashboard') ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/50 dark:text-emerald-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-emerald-dark-600 hover:text-gray-900 dark:hover:text-white' }}"
                :class="sidebarCollapsed ? 'justify-center' : ''">
                <svg class="h-6 w-6 flex-shrink-0 transition-colors {{ request()->routeIs('dashboard') ? 'text-emerald-600 dark:text-emerald-400' : 'text-gray-400 group-hover:text-gray-500 dark:group-hover:text-gray-300' }}"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                <span class="ml-3 whitespace-nowrap transition-opacity duration-200"
                    x-show="!sidebarCollapsed">Dashboard</span>

                {{-- Tooltip for collapsed state --}}
                <div x-show="sidebarCollapsed"
                    class="absolute left-full top-1/2 -translate-y-1/2 ml-2 px-2 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity z-50 whitespace-nowrap">
                    Dashboard
                </div>
            </a>

            <a href="{{ route('profile.show') }}" wire:navigate
                class="flex items-center px-3 py-2 text-sm font-medium rounded-xl transition-colors group relative {{ request()->routeIs('profile.show') ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/50 dark:text-emerald-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-emerald-dark-600 hover:text-gray-900 dark:hover:text-white' }}"
                :class="sidebarCollapsed ? 'justify-center' : ''">
                <svg class="h-6 w-6 flex-shrink-0 transition-colors {{ request()->routeIs('profile.show') ? 'text-emerald-600 dark:text-emerald-400' : 'text-gray-400 group-hover:text-gray-500 dark:group-hover:text-gray-300' }}"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span class="ml-3 whitespace-nowrap transition-opacity duration-200" x-show="!sidebarCollapsed">Mon
                    Profil</span>
                <div x-show="sidebarCollapsed"
                    class="absolute left-full top-1/2 -translate-y-1/2 ml-2 px-2 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity z-50 whitespace-nowrap">
                    Mon Profil</div>
            </a>

            {{-- Team Section --}}
            @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                <div class="pt-4 pb-2" x-show="!sidebarCollapsed">
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        Organisation
                    </p>
                </div>
                <div class="pt-4 pb-2 flex justify-center" x-show="sidebarCollapsed">
                    <div class="h-px w-8 bg-gray-200 dark:bg-gray-700"></div>
                </div>

                @if(Auth::user()->currentTeam)
                    <!-- Organisation Tree -->
                    <div x-data="{ open: {{ request()->routeIs('teams.show') ? 'true' : 'false' }} }" class="space-y-1">

                        <!-- Header / Toggle -->
                        <a href="{{ route('teams.show', Auth::user()->currentTeam) }}" wire:navigate
                            @click="if (!sidebarCollapsed) { $event.preventDefault(); open = !open; }"
                            class="w-full flex items-center px-3 py-2 text-sm font-medium rounded-xl transition-colors group relative hover:bg-gray-50 dark:hover:bg-emerald-dark-600 focus:outline-none"
                            :class="sidebarCollapsed ? 'justify-center' : 'justify-between text-gray-600 dark:text-gray-400'">

                            <div class="flex items-center">
                                <svg class="h-6 w-6 flex-shrink-0 transition-colors {{ request()->routeIs('teams.show') ? 'text-emerald-600 dark:text-emerald-400' : 'text-gray-400 group-hover:text-gray-500 dark:group-hover:text-gray-300' }}"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                <span class="ml-3 whitespace-nowrap transition-opacity duration-200 font-semibold"
                                    x-show="!sidebarCollapsed">
                                    {{ Auth::user()->currentTeam->name }}
                                </span>
                            </div>

                            <!-- Rotate Chevron -->
                            <svg x-show="!sidebarCollapsed"
                                class="h-4 w-4 transform transition-transform duration-200 text-gray-400"
                                :class="{'rotate-90': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>

                            <!-- Tooltip Collapsed -->
                            <div x-show="sidebarCollapsed"
                                class="absolute left-full top-1/2 -translate-y-1/2 ml-2 px-2 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity z-50 whitespace-nowrap">
                                {{ Auth::user()->currentTeam->name }}
                            </div>
                        </a>

                        <!-- Sub-menu Items -->
                        <div x-show="open && !sidebarCollapsed" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100" class="space-y-1 pl-11 pr-3">

                            <!-- General Info -->
                            <a href="{{ route('teams.show', Auth::user()->currentTeam) }}" wire:navigate
                                class="block py-2 px-3 text-sm rounded-lg transition-colors {{ request()->routeIs('teams.show') && !request()->query('tab') ? 'text-emerald-600 bg-emerald-50 dark:bg-emerald-900/30 dark:text-emerald-400 font-medium' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:bg-emerald-dark-600' }}">
                                Informations générales
                            </a>

                            <!-- Members -->
                            <a href="{{ route('teams.show', ['team' => Auth::user()->currentTeam, 'tab' => 'members']) }}"
                                wire:navigate
                                class="block w-full text-left py-2 px-3 text-sm rounded-lg transition-colors {{ request()->routeIs('teams.show') && request()->query('tab') === 'members' ? 'text-emerald-600 bg-emerald-50 dark:bg-emerald-900/30 dark:text-emerald-400 font-medium' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:bg-emerald-dark-600' }}">
                                Gestion des membres
                            </a>

                            <!-- Public Profile Link (External) -->
                            <a href="{{ route('profile.public', Auth::user()->currentTeam->public_uuid) }}" target="_blank"
                                class="flex items-center py-2 px-3 text-sm rounded-lg transition-colors text-emerald-600 hover:text-emerald-700 hover:bg-emerald-50 dark:text-emerald-400 dark:hover:bg-emerald-900/30">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                                Voir le profil public
                            </a>
                        </div>
                    </div>

                    @if(Auth::user()->currentTeam->subscribed())

                        {{-- Avis Section (for subscribed teams) --}}
                        <div x-data="{ openAvis: {{ request()->routeIs('reviews.*') ? 'true' : 'false' }} }" class="mt-1">
                            <button @click="openAvis = !openAvis"
                                class="w-full flex items-center px-3 py-2 text-sm font-medium rounded-xl transition-colors group relative hover:bg-gray-50 dark:hover:bg-emerald-dark-600 focus:outline-none {{ request()->routeIs('reviews.*') ? 'bg-emerald-50 dark:bg-emerald-900/50' : '' }}"
                                :class="sidebarCollapsed ? 'justify-center' : 'justify-between text-gray-600 dark:text-gray-400'">
                                <div class="flex items-center">
                                    <svg class="h-6 w-6 flex-shrink-0 transition-colors {{ request()->routeIs('reviews.*') ? 'text-emerald-600 dark:text-emerald-400' : 'text-gray-400 group-hover:text-gray-500 dark:group-hover:text-gray-300' }}"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                    <span class="ml-3 whitespace-nowrap transition-opacity duration-200 font-medium"
                                        x-show="!sidebarCollapsed">Avis</span>
                                </div>
                                <svg x-show="!sidebarCollapsed"
                                    class="h-4 w-4 transform transition-transform duration-200 text-gray-400"
                                    :class="{'rotate-90': openAvis}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                                <div x-show="sidebarCollapsed"
                                    class="absolute left-full top-1/2 -translate-y-1/2 ml-2 px-2 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity z-50 whitespace-nowrap">
                                    Avis</div>
                            </button>

                            <div x-show="openAvis && !sidebarCollapsed" x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="opacity-0 transform scale-95"
                                x-transition:enter-end="opacity-100 transform scale-100" class="space-y-1 pl-11 pr-3 mt-1">
                                <a href="{{ route('reviews.stats') }}" wire:navigate
                                    class="block py-2 px-3 text-sm rounded-lg transition-colors {{ request()->routeIs('reviews.stats') ? 'text-emerald-600 bg-emerald-50 dark:bg-emerald-900/30 dark:text-emerald-400 font-medium' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:bg-emerald-dark-600' }}">
                                    Mes données
                                </a>
                                <a href="{{ route('reviews.public') }}" wire:navigate
                                    class="block py-2 px-3 text-sm rounded-lg transition-colors {{ request()->routeIs('reviews.public') ? 'text-emerald-600 bg-emerald-50 dark:bg-emerald-900/30 dark:text-emerald-400 font-medium' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:bg-emerald-dark-600' }}">
                                    Mes avis publics
                                </a>
                                <a href="{{ route('reviews.private') }}" wire:navigate
                                    class="block py-2 px-3 text-sm rounded-lg transition-colors {{ request()->routeIs('reviews.private') ? 'text-emerald-600 bg-emerald-50 dark:bg-emerald-900/30 dark:text-emerald-400 font-medium' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:bg-emerald-dark-600' }}">
                                    Mes retours clients
                                </a>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('subscription.index') }}" wire:navigate
                            class="flex items-center px-3 py-2 text-sm font-medium rounded-xl text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/20 hover:bg-emerald-100 dark:hover:bg-emerald-900/40 group relative"
                            :class="sidebarCollapsed ? 'justify-center' : ''">
                            <svg class="h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            <span class="ml-3 whitespace-nowrap transition-opacity duration-200" x-show="!sidebarCollapsed">Passer
                                Premium</span>
                            <div x-show="sidebarCollapsed"
                                class="absolute left-full top-1/2 -translate-y-1/2 ml-2 px-2 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity z-50 whitespace-nowrap">
                                Passer Premium</div>
                        </a>
                    @endif
                @endif

                {{-- Create Team Button Removed/Hidden based on request (now redirects to onboarding, so keeping button but
                it routes to onboarding via web.php is fine, OR user wants to restrict creation only to onboarding. The user
                said: "l'utilisateur ne peux créer une équipe que via onboarding". I redirected the route. I should probably
                HIDE this button to avoid confusion, or keep it as a shortcut to onboarding.) --}}
                {{-- User instruction: "l'utilisateur ne peux créer une équipe que via onboarding" -> implies they shouldn't
                see a 'Create Team' button in the sidebar if they can't create it there. But if it redirects to onboarding,
                it IS creating via onboarding. I will hide it to be safe, as 'onboarding' usually implies a specific flow.
                --}}

            @endif

        </nav>

        {{-- SUBSCRIPTION & LOGOUT (BOTTOM) --}}
        <div class="p-4 border-t border-gray-100 dark:border-emerald-dark-600 bg-gray-50 dark:bg-emerald-dark-600/30">

            {{-- MON OFFRE (Subscription) --}}
            @if(Auth::user()->currentTeam && Auth::user()->currentTeam->subscribed())
                <a href="{{ route('subscription.show', Auth::user()->currentTeam) }}" wire:navigate
                    class="flex items-center mb-3 px-3 py-2 text-sm font-medium rounded-xl transition-colors group relative {{ request()->routeIs('subscription.show') ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/50 dark:text-emerald-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-emerald-dark-600 hover:text-gray-900 dark:hover:text-white' }}"
                    :class="sidebarCollapsed ? 'justify-center' : ''">
                    <svg class="h-6 w-6 flex-shrink-0 transition-colors {{ request()->routeIs('subscription.show') ? 'text-emerald-600 dark:text-emerald-400' : 'text-gray-400 group-hover:text-gray-500 dark:group-hover:text-gray-300' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    <span class="ml-3 whitespace-nowrap transition-opacity duration-200" x-show="!sidebarCollapsed">Mon
                        offre</span>
                    <div x-show="sidebarCollapsed"
                        class="absolute left-full top-1/2 -translate-y-1/2 ml-2 px-2 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity z-50 whitespace-nowrap">
                        Mon offre</div>
                </a>
            @endif

            {{-- LOGOUT --}}
            <form method="POST" action="{{ route('logout') }}" x-data class="mb-4">
                @csrf
                <a href="{{ route('logout') }}" @click.prevent="$root.submit();"
                    class="flex items-center text-sm font-medium text-red-600 bg-white dark:bg-red-900/10 rounded-xl hover:bg-red-50 dark:hover:bg-red-900/30 border border-transparent hover:border-red-100 dark:hover:border-red-900/50 transition-colors group relative h-10"
                    :class="sidebarCollapsed ? 'justify-center px-0' : 'justify-center px-4 py-2'">
                    <svg class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span class="ml-2 whitespace-nowrap" x-show="!sidebarCollapsed">Déconnexion</span>
                    <div x-show="sidebarCollapsed"
                        class="absolute left-full top-1/2 -translate-y-1/2 ml-2 px-2 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity z-50 whitespace-nowrap">
                        Déconnexion</div>
                </a>
            </form>

            {{-- SHOUCLOUD BRANDING --}}
            <div class="flex items-center justify-center pt-2 border-t border-gray-200 dark:border-gray-700">
                <a href="/" class="flex items-center group relative">
                    {{-- Icon Only (Always visible) --}}
                    <div class="flex-shrink-0 flex items-center justify-center bg-gradient-to-br from-emerald-500 to-teal-600 text-white rounded-lg shadow-sm"
                        :class="sidebarCollapsed ? 'h-8 w-8' : 'h-8 w-8'">
                        <span class="font-bold text-lg select-none">S</span>
                    </div>

                    {{-- Full Text (Hidden on collapse) --}}
                    <span
                        class="ml-3 font-bold text-gray-700 dark:text-gray-200 text-lg tracking-tight whitespace-nowrap"
                        x-show="!sidebarCollapsed">
                        <span class="text-emerald-600 dark:text-emerald-400">Shou</span>Cloud
                    </span>

                    <div x-show="sidebarCollapsed"
                        class="absolute left-full top-1/2 -translate-y-1/2 ml-2 px-2 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity z-50 whitespace-nowrap">
                        ShouCloud</div>
                </a>
            </div>
        </div>
    </div>
</aside>