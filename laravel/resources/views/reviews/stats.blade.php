<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white dark:text-gray-100 leading-tight">
            {{ __('Mes données') }}
        </h2>
    </x-slot>

    <div class="py-12 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Ma notation publique (Google) --}}
            <section>
                <div class="md:flex md:items-center md:justify-between mb-4">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">
                        {{ __('Ma notation publique') }}
                    </h3>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                    @if(isset($googleData) && !$googleData['error'])
                        <div class="flex items-center">
                            <div class="flex items-center">
                                <span
                                    class="text-4xl font-bold text-gray-900 dark:text-white mr-3">{{ number_format($googleData['rating'] ?? 0, 1) }}</span>
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-6 h-6 {{ $i <= round($googleData['rating'] ?? 0) ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                            <div class="ml-4 pl-4 border-l border-gray-200 dark:border-gray-700">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Basé sur</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ $googleData['total_reviews'] ?? 0 }} avis Google
                                </p>
                            </div>
                        </div>
                    @elseif(isset($googleData['error']) && $googleData['error'] === 'service_not_configured')
                        <div class="text-center py-6 text-gray-500 dark:text-gray-400">
                            Service non configuré.
                        </div>
                    @else
                        <div class="text-center py-6 text-gray-500 dark:text-gray-400">
                            {{ $googleData['error'] ?? 'Aucune donnée disponible.' }}
                        </div>
                    @endif
                </div>
            </section>

            {{-- Ma notation interne --}}
            <section>
                <div class="md:flex md:items-center md:justify-between mb-4">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">
                        {{ __('Ma notation interne') }}
                    </h3>
                </div>
                @livewire('team-ratings-stats')
            </section>
        </div>
    </div>
</x-app-layout>