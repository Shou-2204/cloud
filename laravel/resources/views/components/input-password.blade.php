@props(['disabled' => false])

<div x-data="{ show: false }" class="relative mt-1">
    {{-- L'input utilise ::type pour être piloté par Alpine.js --}}
    <x-input {{ $attributes->merge([
    'type' => 'password',
    'class' => 'block w-full pr-10'
]) }}
        ::type="show ? 'text' : 'password'" :disabled="$disabled" />

    {{-- Bouton pour basculer la visibilité --}}
    <button type="button"
        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 focus:outline-none"
        @click="show = !show" tabindex="-1">

        {{-- Icône Œil Ouvert (visible si show est vrai) --}}
        <svg x-show="show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-cloak>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        </svg>

        {{-- Icône Œil Barré (visible si show est faux) --}}
        <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.025 10.025 0 014.132-5.411m0 0L21 21m-2.102-2.102L12 12m-2.898-2.898L3 3" />
        </svg>
    </button>
</div>