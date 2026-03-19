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

                @livewire('google-reviews-stats')
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