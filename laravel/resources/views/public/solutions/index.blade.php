<x-guest-layout :seo="$seo">
    <div class="pt-24 pb-12 bg-ivory dark:bg-emerald-dark min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-breadcrumb :crumbs="$seo['breadcrumbs']" />

            <div class="text-center mb-16">
                <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white sm:text-5xl">
                    Solutions par <span class="text-emerald-600 dark:text-emerald-400">Secteur</span>
                </h1>
                <p class="mt-4 text-xl text-gray-600 dark:text-gray-300">
                    Des outils sur mesure pour aider votre activité spécifique à se développer.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Restaurants -->
                <a href="{{ route('solutions.show', 'restaurants') }}"
                    class="reveal-on-scroll delay-100 block p-8 bg-white dark:bg-gray-800 rounded-2xl shadow-sm hover:shadow-md transition-shadow border border-gray-100 dark:border-gray-700 hover-lift">
                    <div
                        class="h-12 w-12 bg-orange-100 text-orange-600 rounded-xl flex items-center justify-center mb-6 animate-float">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Restaurants</h2>
                    <p class="text-gray-600 dark:text-gray-400">Automate reviews and keep tables full with smart loyalty
                        programs.</p>
                </a>

                <!-- Retail -->
                <a href="{{ route('solutions.show', 'retail') }}"
                    class="reveal-on-scroll delay-200 block p-8 bg-white dark:bg-gray-800 rounded-2xl shadow-sm hover:shadow-md transition-shadow border border-gray-100 dark:border-gray-700 hover-lift">
                    <div class="h-12 w-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mb-6 animate-float" style="animation-delay: 1s;">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Retail</h2>
                    <p class="text-gray-600 dark:text-gray-400">Increase foot traffic and average basket size with
                        targeted campaigns.</p>
                </a>

                <!-- Services -->
                <a href="{{ route('solutions.show', 'services') }}"
                    class="reveal-on-scroll delay-300 block p-8 bg-white dark:bg-gray-800 rounded-2xl shadow-sm hover:shadow-md transition-shadow border border-gray-100 dark:border-gray-700 hover-lift">
                    <div class="h-12 w-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center mb-6 animate-float" style="animation-delay: 2s;">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Services</h2>
                    <p class="text-gray-600 dark:text-gray-400">Streamline bookings and client communication for service
                        providers.</p>
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>