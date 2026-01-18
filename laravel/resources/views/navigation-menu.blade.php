<nav
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
                    <a href="/" class="flex items-center gap-2 mr-6">
                        <div
                            class="h-8 w-8 bg-white/10 rounded-lg flex items-center justify-center text-white font-bold backdrop-blur-sm">
                            S
                        </div>
                        <span class="text-xl font-bold tracking-tight text-white">
                            ShouCloud
                        </span>
                    </a>
                @endguest

                {{-- Public Navigation (Desktop) --}}
                <div class="hidden md:flex items-center space-x-8 ml-10">
                    <a href="{{ route('features') }}"
                        class="text-sm font-medium text-emerald-100 hover:text-white transition">Fonctionnalités</a>
                    <a href="{{ route('solutions.index') }}"
                        class="text-sm font-medium text-emerald-100 hover:text-white transition">Solutions</a>
                    <a href="{{ route('subscription.index') }}"
                        class="text-sm font-medium text-emerald-100 hover:text-white transition">Tarifs</a>
                    <a href="{{ route('blog.index') }}"
                        class="text-sm font-medium text-emerald-100 hover:text-white transition">Ressources</a>
                    <a href="{{ route('about') }}"
                        class="text-sm font-medium text-emerald-100 hover:text-white transition">À propos</a>
                </div>

                {{-- Page Title (Divider + Title) --}}
                <div class="hidden md:flex ml-6 pl-6 border-l border-emerald-500/30 items-center h-8">
                    @if (isset($header))
                        <div class="text-white font-medium text-lg">
                            {{ $header }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex items-center space-x-4">
                {{-- Theme Switcher --}}
                <div class="flex items-center text-white">
                    <x-theme-switch />
                </div>

                {{-- Guest Auth Links --}}
                @guest
                    <a href="{{ route('login') }}"
                        class="text-sm font-medium text-emerald-100 hover:text-white transition">Connexion</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="px-4 py-2 text-sm font-bold text-emerald-600 bg-white hover:bg-emerald-50 rounded-lg transition shadow-md">
                            Inscription
                        </a>
                    @endif
                @endguest
            </div>
        </div>
    </div>
</nav>