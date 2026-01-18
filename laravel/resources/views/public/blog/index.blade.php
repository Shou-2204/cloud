<x-guest-layout :seo="$seo">
    <div class="pt-24 pb-12 bg-ivory dark:bg-emerald-dark min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-breadcrumb :crumbs="$seo['breadcrumbs']" />

            <div class="text-center mb-16">
                <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white sm:text-5xl">
                    Ressources & <span class="text-emerald-600 dark:text-emerald-400">Idées</span>
                </h1>
                <p class="mt-4 text-xl text-gray-600 dark:text-gray-300">
                    Conseils et stratégies pour développer votre entreprise.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($posts as $index => $post)
                    <div class="reveal-on-scroll flex flex-col rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden hover:shadow-md transition-shadow hover-lift"
                        style="transition-delay: {{ $index * 100 }}ms;">
                        <div class="h-48 bg-gray-200 dark:bg-gray-700 w-full object-cover">
                            <!-- Placeholder for blog image -->
                            <div class="flex items-center justify-center h-full text-gray-400">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 p-6 flex flex-col justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-emerald-600 dark:text-emerald-400">
                                    Stratégie de Croissance
                                </p>
                                <a href="{{ route('blog.show', $post->slug) }}" class="block mt-2">
                                    <p class="text-xl font-semibold text-gray-900 dark:text-white">
                                        {{ $post->title }}
                                    </p>
                                    <p class="mt-3 text-base text-gray-500 dark:text-gray-400">
                                        {{ $post->excerpt }}
                                    </p>
                                </a>
                            </div>
                            <div class="mt-6 flex items-center">
                                <div class="flex-shrink-0">
                                    <span class="sr-only">Author</span>
                                    <div class="h-10 w-10 rounded-full bg-gray-300 dark:bg-gray-600"></div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                        ShouCloud Team
                                    </p>
                                    <div class="flex space-x-1 text-sm text-gray-500 dark:text-gray-400">
                                        <time datetime="2026-01-18">Jan 18, 2026</time>
                                        <span aria-hidden="true">&middot;</span>
                                        <span>3 min read</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-guest-layout>