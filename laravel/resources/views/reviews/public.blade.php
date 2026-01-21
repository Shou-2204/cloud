<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white dark:text-gray-100 leading-tight">
            {{ __('Mes avis publics') }}
        </h2>
    </x-slot>

    <div class="py-12 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                    Avis Google My Business
                </h1>
                <p class="mt-1 text-gray-500 dark:text-gray-400">
                    Les avis publics de votre établissement sur Google
                </p>
            </div>

            @if($team && $team->subscribed())
                @if($error === 'google_place_id_missing')
                    <div class="bg-white dark:bg-emerald-dark-500 rounded-2xl p-12 shadow-sm border border-gray-100 dark:border-emerald-dark-600 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Configurez Google Place ID</h3>
                        <p class="mt-2 text-gray-500 dark:text-gray-400 mb-6">
                            Pour afficher vos avis Google, renseignez votre Google Place ID dans les paramètres de votre organisation.
                        </p>
                        <a href="{{ route('teams.show', $team) }}"
                            class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors">
                            Configurer
                        </a>
                    </div>
                @elseif($error === 'google_api_key_missing')
                    <div class="bg-white dark:bg-emerald-dark-500 rounded-2xl p-12 shadow-sm border border-gray-100 dark:border-emerald-dark-600 text-center">
                        <svg class="mx-auto h-12 w-12 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Clé API Google requise</h3>
                        <p class="mt-2 text-gray-500 dark:text-gray-400 mb-6">
                            Pour récupérer vos avis Google, renseignez votre clé API Google Places dans les paramètres de votre organisation.
                        </p>
                        <a href="{{ route('teams.show', $team) }}"
                            class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors">
                            Configurer
                        </a>
                    </div>
                @elseif($error)
                    <div class="bg-red-50 dark:bg-red-900/20 rounded-2xl p-6 border border-red-200 dark:border-red-800">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-red-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <p class="text-red-700 dark:text-red-400">{{ $error }}</p>
                        </div>
                    </div>
                @elseif($googleData && count($googleData['reviews']) > 0)
                    {{-- Summary Card --}}
                    <div class="bg-white dark:bg-emerald-dark-500 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-emerald-dark-600 mb-6">
                        <div class="flex items-center justify-between flex-wrap gap-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ $googleData['name'] ?? 'Votre établissement' }}
                                </h3>
                                <div class="flex items-center gap-2 mt-1">
                                    <div class="flex items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-5 h-5 {{ $i <= round($googleData['rating'] ?? 0) ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                    <span class="text-gray-600 dark:text-gray-400">
                                        {{ number_format($googleData['rating'] ?? 0, 1) }} · {{ $googleData['total_reviews'] ?? 0 }} avis
                                    </span>
                                </div>
                            </div>
                            <img src="https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_92x30dp.png" alt="Google" class="h-6">
                        </div>
                    </div>

                    {{-- Reviews List --}}
                    <div class="space-y-4">
                        @foreach($googleData['reviews'] as $review)
                            <div class="bg-white dark:bg-emerald-dark-500 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-emerald-dark-600">
                                <div class="flex items-start gap-4">
                                    @if(!empty($review['profile_photo_url']))
                                        <img src="{{ $review['profile_photo_url'] }}" alt="{{ $review['author_name'] ?? 'Auteur' }}" class="w-10 h-10 rounded-full">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                            <span class="text-gray-600 dark:text-gray-300 font-medium">{{ substr($review['author_name'] ?? '?', 0, 1) }}</span>
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between flex-wrap gap-2">
                                            <h4 class="font-medium text-gray-900 dark:text-white">{{ $review['author_name'] ?? 'Anonyme' }}</h4>
                                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $review['relative_time_description'] ?? '' }}</span>
                                        </div>
                                        <div class="flex items-center gap-1 mt-1 mb-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= ($review['rating'] ?? 0) ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @endfor
                                        </div>
                                        @if(!empty($review['text']))
                                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $review['text'] }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white dark:bg-emerald-dark-500 rounded-2xl p-12 shadow-sm border border-gray-100 dark:border-emerald-dark-600 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Aucun avis Google trouvé</h3>
                        <p class="mt-2 text-gray-500 dark:text-gray-400">
                            Aucun avis n'a été trouvé pour cet établissement sur Google.
                        </p>
                    </div>
                @endif
            @else
                <div class="bg-white dark:bg-emerald-dark-500 rounded-2xl p-12 shadow-sm border border-gray-100 dark:border-emerald-dark-600 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Fonctionnalité Premium</h3>
                    <p class="mt-2 text-gray-500 dark:text-gray-400 mb-6">
                        Passez à un abonnement Premium pour voir vos avis Google.
                    </p>
                    <a href="{{ route('subscription.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors">
                        Passer Premium
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
