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
                        <a href="{{ route('subscription.index') }}" class="text-base text-gray-500 hover:text-emerald-600 dark:text-gray-400 dark:hover:text-emerald-400 transition-colors">
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

        <div class="border-t border-gray-100 dark:border-gray-800 pt-8 pb-2 flex flex-col md:flex-row justify-between items-center">
            <p class="text-base text-gray-400 xl:text-center">
                &copy; {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.
            </p>
            <div class="flex space-x-6 mt-4 md:mt-0 text-gray-400">
                <a href="#" class="hover:text-gray-500" title="LinkedIn">
                    <span class="sr-only">LinkedIn</span>
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                    </svg>
                </a>
                <a href="#" class="hover:text-gray-500" title="YouTube">
                    <span class="sr-only">YouTube</span>
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/>
                    </svg>
                </a>
                <a href="#" class="hover:text-gray-500" title="WhatsApp Pro">
                    <span class="sr-only">WhatsApp Pro</span>
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</footer>
