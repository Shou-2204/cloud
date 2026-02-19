<footer class="bg-white dark:bg-gray-900 border-t border-gray-100 dark:border-gray-800 pt-16 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 md:gap-8 mb-12">
            <!-- Brand -->
            <div class="col-span-1 md:col-span-1">
                <a href="{{ route('welcome') }}" class="flex items-center space-x-2 mb-4">
                    <x-application-logo class="w-8 h-8 text-emerald-600" />
                    <span class="text-xl font-bold text-gray-900 dark:text-white">{{ config('app.name') }}</span>
                </a>
                <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed mb-6">
                    La plateforme complète pour fidéliser vos clients, automatiser vos avis Google et booster votre chiffre d'affaires.
                </p>
            </div>

            <!-- Solutions -->
            <div>
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider mb-4">Solutions</h3>
                <ul class="space-y-3">
                    @foreach(config('marketing.solutions', []) as $slug => $solution)
                    <li>
                        <a href="{{ route('solutions.show', $slug) }}" class="text-base text-gray-500 hover:text-emerald-600 dark:text-gray-400 dark:hover:text-emerald-400 transition-colors">
                            {{ $solution['title'] }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            <!-- Ressources -->
            <div>
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider mb-4">Ressources</h3>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('blog.index') }}" class="text-base text-gray-500 hover:text-emerald-600 dark:text-gray-400 dark:hover:text-emerald-400 transition-colors">
                            Blog & Conseils
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('faq') }}" class="text-base text-gray-500 hover:text-emerald-600 dark:text-gray-400 dark:hover:text-emerald-400 transition-colors">
                            Foire Aux Questions (FAQ)
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Société -->
            <div>
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider mb-4">Société</h3>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('pricing') }}" class="text-base text-gray-500 hover:text-emerald-600 dark:text-gray-400 dark:hover:text-emerald-400 transition-colors">
                            Tarifs
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-base text-gray-500 hover:text-emerald-600 dark:text-gray-400 dark:hover:text-emerald-400 transition-colors">
                            Contact
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-base text-gray-500 hover:text-emerald-600 dark:text-gray-400 dark:hover:text-emerald-400 transition-colors">
                            Mentions légales
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-100 dark:border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center">
            <p class="text-base text-gray-400 xl:text-center">
                &copy; {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.
            </p>
            <div class="flex space-x-6 mt-4 md:mt-0 text-gray-400">
                <!-- Social links (empty for now) -->
                <a href="#" class="hover:text-gray-500">
                    <span class="sr-only">Facebook</span>
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</footer>
