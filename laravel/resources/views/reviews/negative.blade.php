<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white dark:text-gray-100 leading-tight">
            {{ __('Feedbacks Négatifs') }}
        </h2>
    </x-slot>

    <div class="py-12 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                    Feedbacks Négatifs
                </h1>
                <p class="mt-1 text-gray-500 dark:text-gray-400">
                    Avis avec une note de 3 étoiles ou moins
                </p>
            </div>

            @if($team && $team->subscribed())
                @if($ratings->count() > 0)
                    <div class="space-y-4">
                        @foreach($ratings as $rating)
                            <div
                                class="bg-white dark:bg-emerald-dark-500 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-emerald-dark-600">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        {{-- Rating Stars --}}
                                        <div class="flex items-center gap-1 mb-3">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-5 h-5 {{ $i <= $rating->rating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @endfor
                                            <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">
                                                {{ $rating->rating }}/5
                                            </span>
                                        </div>

                                        {{-- Comment --}}
                                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                            "{{ $rating->comment }}"
                                        </p>

                                        {{-- Date --}}
                                        <p class="mt-3 text-sm text-gray-400 dark:text-gray-500">
                                            {{ $rating->created_at->format('d/m/Y à H:i') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-6">
                        {{ $ratings->links() }}
                    </div>
                @else
                    <div
                        class="bg-white dark:bg-emerald-dark-500 rounded-2xl p-12 shadow-sm border border-gray-100 dark:border-emerald-dark-600 text-center">
                        <svg class="mx-auto h-12 w-12 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Aucun feedback négatif</h3>
                        <p class="mt-2 text-gray-500 dark:text-gray-400">
                            Félicitations ! Vous n'avez aucun avis négatif avec commentaire.
                        </p>
                    </div>
                @endif
            @else
                <div
                    class="bg-white dark:bg-emerald-dark-500 rounded-2xl p-12 shadow-sm border border-gray-100 dark:border-emerald-dark-600 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Fonctionnalité Premium</h3>
                    <p class="mt-2 text-gray-500 dark:text-gray-400 mb-6">
                        Passez à un abonnement Premium pour accéder aux feedbacks clients.
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