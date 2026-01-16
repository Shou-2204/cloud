@props(['submit'])

<div {{ $attributes->merge(['class' => 'md:grid md:grid-cols-3 md:gap-6']) }}>
    <x-section-title>
        <x-slot name="title">{{ $title }}</x-slot>
        <x-slot name="description">{{ $description }}</x-slot>
    </x-section-title>

    <div class="mt-5 md:mt-0 md:col-span-2">
        <form wire:submit="{{ $submit }}">
            <div
                class="px-4 py-5 bg-white dark:bg-emerald-dark-600 sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-t-2xl' : 'sm:rounded-2xl' }}">
                <div class="grid grid-cols-6 gap-6">
                    {{ $form }}
                </div>
            </div>

            @if (isset($actions))
                <div
                    class="flex items-center justify-end px-4 py-3 bg-gray-50 dark:bg-emerald-dark-800 shadow sm:rounded-b-2xl border-t border-gray-100 dark:border-emerald-dark-500">
                    {{ $actions }}
                </div>
            @endif
        </form>
    </div>
</div>