<x-form-section submit="updatePassword">
    <x-slot name="title">
        {{ Auth::user()->has_set_password ? __('Update Password') : __('Set Password') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Ensure your account is using a long, random password to stay secure.') }}
    </x-slot>

    <x-slot name="form">
        @if(Auth::user()->has_set_password)
            <div class="col-span-6 sm:col-span-4">
                <x-label for="current_password" value="{{ __('Current Password') }}" />
                {{-- On utilise notre composant avec wire:model.defer pour Livewire --}}
                <x-input-password id="current_password" type="password" class="mt-1 block w-full"
                    wire:model.defer="state.current_password" autocomplete="current-password" />
                <x-input-error for="current_password" class="mt-2" />
            </div>
        @endif

        <div class="col-span-6 sm:col-span-4">
            <x-label for="password" value="{{ __('New Password') }}" />
            <x-input-password id="password" type="password" class="mt-1 block w-full" wire:model.defer="state.password"
                autocomplete="new-password" />
            <x-input-error for="password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
            <x-input-password id="password_confirmation" type="password" class="mt-1 block w-full"
                wire:model.defer="state.password_confirmation" autocomplete="new-password" />
            <x-input-error for="password_confirmation" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">
            {{ __('Saved.') }}
        </x-action-message>

        <x-button>
            {{ __('Save') }}
        </x-button>
    </x-slot>
</x-form-section>