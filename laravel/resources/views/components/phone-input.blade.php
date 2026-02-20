@props([
    'id' => 'phone',
    'wireModel' => null,
    'placeholder' => '',
    'required' => false,
    'initialValue' => '',
    'size' => 'sm', // 'sm' for internal forms, 'lg' for marketing page
])

@php
    $inputClass = $size === 'lg'
        ? 'w-full px-6 py-4 text-base rounded-xl border-2 border-gray-200 dark:border-emerald-dark-400 bg-white dark:bg-emerald-dark-500 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-emerald-500 dark:focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 transition-all outline-none'
        : 'mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-emerald-500 dark:focus:border-emerald-500 focus:ring-emerald-500 dark:focus:ring-emerald-500 rounded-md shadow-sm';
@endphp

<div 
    x-data="{
        iti: null,
        init() {
            const input = this.$refs.input;
            
            this.iti = window.intlTelInput(input, {
                initialCountry: 'fr',
                onlyCountries: ['fr'],
                formatOnDisplay: true,
                nationalMode: true,
                autoPlaceholder: 'aggressive',
            });

            // Set initial value (E.164 or national format)
            const initial = '{{ $initialValue }}';
            if (initial) {
                this.iti.setNumber(initial);
            }

            // Sync to Livewire on input
            input.addEventListener('input', () => this.sync());
            input.addEventListener('countrychange', () => this.sync());
            input.addEventListener('blur', () => {
                // On blur, reformat neatly if valid
                if (this.iti.isValidNumber()) {
                    this.iti.setNumber(this.iti.getNumber());
                }
                this.sync();
            });
        },
        sync() {
            const e164 = this.iti.getNumber();
            @if($wireModel)
                @this.set('{{ $wireModel }}', e164 || '');
            @endif
        }
    }"
    wire:ignore
    {{ $attributes->only('class') }}
>
    <input 
        type="tel" 
        id="{{ $id }}" 
        x-ref="input"
        @if($required) required @endif
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        class="{{ $inputClass }}"
    >
</div>

@once
@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@26.5.1/build/css/intlTelInput.css">
<style>
    .iti { width: 100%; }
    .dark .iti__dropdown-content {
        background-color: rgb(17, 24, 39);
        border-color: rgb(55, 65, 81);
    }
    .dark .iti__search-input {
        background-color: rgb(17, 24, 39);
        color: rgb(209, 213, 219);
        border-color: rgb(55, 65, 81);
    }
    .dark .iti__country.iti__highlight {
        background-color: rgb(31, 41, 55);
    }
    .dark .iti__country-name,
    .dark .iti__dial-code {
        color: rgb(209, 213, 219);
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@26.5.1/build/js/intlTelInputWithUtils.min.js"></script>
@endpush
@endonce
