<nav x-data="{ mobileSearchOpen: false, mobileMenuOpen: false }"
    class="bg-emerald-light-600 dark:bg-emerald-dark border-b border-emerald-light-500 dark:border-emerald-dark-600 sticky top-0 z-30 transition-colors duration-300">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                {{-- Mobile Menu Toggle (Auth only) --}}
                @auth
                    <div class="-ml-2 mr-2 flex items-center md:hidden">
                        <button @click="sidebarOpen = !sidebarOpen"
                            class="inline-flex items-center justify-center p-2 rounded-md text-emerald-100 hover:text-white hover:bg-emerald-600 focus:outline-none focus:bg-emerald-600 focus:text-white transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': sidebarOpen, 'inline-flex': ! sidebarOpen }" class="inline-flex"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': ! sidebarOpen, 'inline-flex': sidebarOpen }" class="hidden"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @endauth

                {{-- Branding (Guest Only) --}}
                @guest
                    <a href="/" class="flex items-center gap-2 mr-4 flex-shrink-0">
                        <div
                            class="h-8 w-8 bg-white/10 rounded-lg flex items-center justify-center text-white font-bold backdrop-blur-sm">
                            S
                        </div>
                        <span class="text-xl font-bold tracking-tight text-white hidden sm:inline">
                            ShouCloud
                        </span>
                    </a>

                    {{-- Mobile Menu Toggle (Guest) --}}
                    <div class="flex items-center md:hidden">
                        <button @click="mobileMenuOpen = !mobileMenuOpen"
                            class="inline-flex items-center justify-center p-2 rounded-md text-emerald-100 hover:text-white hover:bg-emerald-600 focus:outline-none focus:bg-emerald-600 focus:text-white transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M6 18L18 6M6 6l12 12" style="display: none;" />
                            </svg>
                        </button>
                    </div>
                @endguest

                {{-- Public Navigation (Desktop) --}}
                @guest
                    <div class="hidden md:flex items-center space-x-4 lg:space-x-8 ml-4 lg:ml-10">
                        <a href="{{ route('features') }}"
                            class="text-sm font-medium text-emerald-100 hover:text-white transition whitespace-nowrap">Fonctionnalités</a>
                        <a href="{{ route('solutions.index') }}"
                            class="text-sm font-medium text-emerald-100 hover:text-white transition">Solutions</a>
                        <a href="{{ route('subscription.index') }}"
                            class="text-sm font-medium text-emerald-100 hover:text-white transition">Tarifs</a>
                        <a href="{{ route('blog.index') }}"
                            class="text-sm font-medium text-emerald-100 hover:text-white transition">Ressources</a>
                        <a href="{{ route('about') }}"
                            class="text-sm font-medium text-emerald-100 hover:text-white transition whitespace-nowrap">À
                            propos</a>
                    </div>
                @endguest

                {{-- Page Title (Divider + Title) --}}
                <div class="hidden md:flex ml-6 pl-6 border-l border-emerald-500/30 items-center h-8">
                    @if (isset($header))
                        <div class="text-white font-medium text-lg whitespace-nowrap">
                            {{ $header }}
                        </div>
                    @endif
                </div>

                {{-- Search Toggle + Inline Search (Left side, after title) --}}
                @auth
                    <div class="flex items-center ml-4">
                        {{-- Search Toggle Button --}}
                        <button @click="mobileSearchOpen = !mobileSearchOpen"
                            class="text-emerald-100 hover:text-white focus:outline-none p-2 rounded-lg hover:bg-emerald-500/50 transition-colors">
                            <svg x-show="!mobileSearchOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <svg x-show="mobileSearchOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>

                        {{-- Inline Search Input --}}
                        <div x-show="mobileSearchOpen" x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="ml-2 w-56 sm:w-72 md:w-80 lg:w-[28rem] xl:w-[36rem]" style="display: none;">
                            <livewire:global-search />
                        </div>
                    </div>
                @endauth

            </div>

            <div class="flex items-center space-x-2 sm:space-x-4">

                {{-- Notifications --}}
                @auth
                    <livewire:notification-bell />
                @endauth

                {{-- Bug Report Button (Auth only) --}}
                @auth
                    <button @click="$dispatch('open-bug-modal')"
                        class="flex items-center justify-center p-2 rounded-lg text-emerald-100 hover:text-white hover:bg-emerald-500/50 focus:outline-none transition-colors"
                        title="Signaler un bug">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 12.75c1.148 0 2.278.08 3.383.237 1.037.146 1.866.966 1.866 2.013 0 3.728-2.35 6.75-5.25 6.75S6.75 18.728 6.75 15c0-1.046.83-1.867 1.866-2.013A24.204 24.204 0 0112 12.75zm0 0c2.883 0 5.647.508 8.207 1.44a23.91 23.91 0 01-1.152 6.06M12 12.75c-2.883 0-5.647.508-8.207 1.44a23.91 23.91 0 001.152 6.06M12 12.75V6.75m0 0a2.25 2.25 0 10-4.5 0m4.5 0a2.25 2.25 0 114.5 0m-4.5 0V4.5" />
                        </svg>
                    </button>
                @endauth

                {{-- Theme Switcher (Guest only) --}}
                @guest
                    <div class="flex items-center text-white">
                        <x-theme-switch />
                    </div>
                @endguest

                {{-- Guest Auth Links --}}
                @guest
                    <a href="{{ route('login') }}"
                        class="text-sm font-medium text-emerald-100 hover:text-white transition hidden sm:inline">Connexion</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="px-3 py-2 text-xs sm:text-sm font-bold text-emerald-600 bg-white hover:bg-emerald-50 rounded-lg transition shadow-md whitespace-nowrap">
                            Inscription
                        </a>
                    @endif
                @endguest
            </div>
        </div>
    </div>

    {{-- Mobile Menu (Guest) --}}
    @guest
        <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-1"
            class="md:hidden bg-emerald-700 dark:bg-emerald-dark-600 border-t border-emerald-600 dark:border-emerald-dark-500"
            style="display: none;">
            <div class="px-4 py-3 space-y-2">
                <a href="{{ route('features') }}"
                    class="block px-3 py-2 text-base font-medium text-emerald-100 hover:text-white hover:bg-emerald-600 rounded-lg transition">Fonctionnalités</a>
                <a href="{{ route('solutions.index') }}"
                    class="block px-3 py-2 text-base font-medium text-emerald-100 hover:text-white hover:bg-emerald-600 rounded-lg transition">Solutions</a>
                <a href="{{ route('subscription.index') }}"
                    class="block px-3 py-2 text-base font-medium text-emerald-100 hover:text-white hover:bg-emerald-600 rounded-lg transition">Tarifs</a>
                <a href="{{ route('blog.index') }}"
                    class="block px-3 py-2 text-base font-medium text-emerald-100 hover:text-white hover:bg-emerald-600 rounded-lg transition">Ressources</a>
                <a href="{{ route('about') }}"
                    class="block px-3 py-2 text-base font-medium text-emerald-100 hover:text-white hover:bg-emerald-600 rounded-lg transition">À
                    propos</a>
                <div class="border-t border-emerald-600 pt-2 mt-2">
                    <a href="{{ route('login') }}"
                        class="block px-3 py-2 text-base font-medium text-emerald-100 hover:text-white hover:bg-emerald-600 rounded-lg transition">Connexion</a>
                </div>
            </div>
        </div>
    @endguest
</nav>