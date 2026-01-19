<x-guest-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
        <!-- Cover Image -->
        <div class="h-48 md:h-64 bg-emerald-600 w-full object-cover relative">
            @if($team->cover_image_path)
                <img src="{{ Storage::disk('s3')->url($team->cover_image_path) }}" alt="Cover"
                    class="w-full h-full object-cover opacity-80">
            @else
                <div class="w-full h-full bg-gradient-to-r from-emerald-500 to-teal-600"></div>
            @endif
        </div>

        <!-- Profile Header -->
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-20 relative">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 sm:p-8">
                <div class="sm:flex sm:items-end sm:space-x-6">
                    <!-- Logo -->
                    <div class="flex-shrink-0 relative">
                        @if($team->logo_path)
                            <img class="h-32 w-32 rounded-xl ring-4 ring-white dark:ring-gray-800 object-cover bg-white"
                                src="{{ Storage::disk('s3')->url($team->logo_path) }}" alt="{{ $team->name }}">
                        @else
                            <div
                                class="h-32 w-32 rounded-xl ring-4 ring-white dark:ring-gray-800 bg-emerald-100 flex items-center justify-center text-4xl font-bold text-emerald-600">
                                {{ substr($team->name, 0, 1) }}
                            </div>
                        @endif
                    </div>

                    <!-- Identity -->
                    <div class="mt-6 sm:mt-0 sm:flex-1">
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $team->name }}</h1>
                        @if($team->tagline)
                            <p class="text-lg text-emerald-600 dark:text-emerald-400 font-medium">{{ $team->tagline }}</p>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="mt-6 sm:mt-0 flex flex-col space-y-3 sm:space-y-0 sm:flex-row sm:space-x-3">
                        @if($team->reviews_enabled)
                            <a href="{{ route('profile.review', $team->public_uuid) }}"
                                class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 w-full sm:w-auto">
                                <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                                    </path>
                                </svg>
                                Laissez un avis
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Bio -->
                @if($team->bio)
                    <div class="mt-8 border-t border-gray-100 dark:border-gray-700 pt-8">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">À propos</h3>
                        <div class="prose prose-emerald dark:prose-invert max-w-none text-gray-600 dark:text-gray-300">
                            {{ $team->bio }}
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Details Grid -->
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Contact Info -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-emerald-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Coordonnées
                    </h3>
                    <dl class="space-y-4">
                        @if($team->address)
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Adresse</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $team->address }}</dd>
                            </div>
                        @endif
                        @if($team->email_public)
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                    <a href="mailto:{{ $team->email_public }}"
                                        class="hover:text-emerald-500 transition">{{ $team->email_public }}</a>
                                </dd>
                            </div>
                        @endif
                        @if($team->phone)
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Téléphone</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                    <a href="tel:{{ $team->phone }}"
                                        class="hover:text-emerald-500 transition">{{ $team->phone }}</a>
                                </dd>
                            </div>
                        @endif
                        @if($team->website)
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Site Web</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                    <a href="{{ $team->website }}" target="_blank" rel="noopener"
                                        class="text-emerald-600 hover:text-emerald-500 transition">{{ $team->website }}</a>
                                </dd>
                            </div>
                        @endif
                    </dl>
                </div>

                <!-- Social Media -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-emerald-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                            </path>
                        </svg>
                        Réseaux Sociaux
                    </h3>
                    <div class="grid grid-cols-2 gap-4">
                        @if($team->social_instagram)
                            <a href="{{ $team->social_instagram }}" target="_blank"
                                class="flex items-center p-3 rounded-lg bg-pink-50 dark:bg-pink-900/10 text-pink-600 dark:text-pink-400 hover:bg-pink-100 transition">
                                <span class="font-medium">Instagram</span>
                            </a>
                        @endif
                        @if($team->social_facebook)
                            <a href="{{ $team->social_facebook }}" target="_blank"
                                class="flex items-center p-3 rounded-lg bg-blue-50 dark:bg-blue-900/10 text-blue-600 dark:text-blue-400 hover:bg-blue-100 transition">
                                <span class="font-medium">Facebook</span>
                            </a>
                        @endif
                        @if($team->social_tiktok)
                            <a href="{{ $team->social_tiktok }}" target="_blank"
                                class="flex items-center p-3 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white hover:bg-gray-100 transition">
                                <span class="font-medium">TikTok</span>
                            </a>
                        @endif
                        @if($team->social_linkedin)
                            <a href="{{ $team->social_linkedin }}" target="_blank"
                                class="flex items-center p-3 rounded-lg bg-blue-50 dark:bg-blue-900/10 text-blue-800 dark:text-blue-300 hover:bg-blue-100 transition">
                                <span class="font-medium">LinkedIn</span>
                            </a>
                        @endif
                        @if($team->social_twitter)
                            <a href="{{ $team->social_twitter }}" target="_blank"
                                class="flex items-center p-3 rounded-lg bg-sky-50 dark:bg-sky-900/10 text-sky-500 dark:text-sky-400 hover:bg-sky-100 transition">
                                <span class="font-medium">X (Twitter)</span>
                            </a>
                        @endif
                    </div>
                </div>

            </div>
        </div>

    </div>
</x-guest-layout>