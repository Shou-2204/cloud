<x-guest-layout :seo="$seo">
    <div class="pt-24 pb-12 bg-ivory dark:bg-emerald-dark min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-breadcrumb :crumbs="$seo['breadcrumbs']" />

            <div class="max-w-3xl mx-auto items-center mt-8">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700">
                    <div class="px-6 py-12 sm:px-12 sm:py-16">
                        <div class="text-center mb-10">
                            <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl mb-4">
                                Contactez-nous
                            </h2>
                            <p class="text-lg text-gray-600 dark:text-gray-300">
                                Une question sur nos solutions ? Nous sommes là pour vous aider.
                            </p>
                        </div>

                        <div class="space-y-8">
                            <div class="flex items-center justify-center space-x-4 bg-emerald-50 dark:bg-emerald-900/20 p-6 rounded-xl border border-emerald-100 dark:border-emerald-800">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-12 w-12 rounded-full bg-emerald-100 dark:bg-emerald-800 text-emerald-600 dark:text-emerald-300">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="text-lg font-medium text-emerald-900 dark:text-emerald-100">
                                    <a href="mailto:hello@inzeecard.com" class="hover:text-emerald-600 transition">hello@inzeecard.com</a>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-6 rounded-xl border border-gray-100 dark:border-gray-700">
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Horaires Support
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-300">
                                        Lundi - Vendredi<br>
                                        9h00 - 18h00 (CET)
                                    </p>
                                </div>

                                <div class="bg-gray-50 dark:bg-gray-700/50 p-6 rounded-xl border border-gray-100 dark:border-gray-700">
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        Siège Social
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-300">
                                        Paris, France<br>
                                        Disponible dans toute l'Europe
                                    </p>
                                </div>
                            </div>
                            
                            {{-- FAQ CTA --}}
                            <div class="text-center pt-8 border-t border-gray-100 dark:border-gray-700">
                                <p class="text-gray-600 dark:text-gray-400 mb-4">
                                    Vous cherchez une réponse rapide ?
                                </p>
                                <a href="{{ route('faq') }}" class="inline-flex items-center text-emerald-600 hover:text-emerald-700 font-semibold">
                                    Consultez notre FAQ
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>