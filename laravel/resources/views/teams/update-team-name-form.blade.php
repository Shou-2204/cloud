<x-form-section submit="updateTeamName">
    <x-slot name="title">
        {{ __("Nom de l'organisation") }}
    </x-slot>

    <x-slot name="description">
        {{ __("Les informations concernant l'organisation et son propriétaire.") }}
    </x-slot>

    <x-slot name="form">
        <!-- Team Owner Information -->
        <div class="col-span-6">
            <x-label :value="__('Propriétaire de l\'organisation')" />

            <div class="flex items-center mt-2">
                <img class="size-12 rounded-full object-cover" src="{{ $team->owner->profile_photo_url }}" alt="{{ $team->owner->name }}">

                <div class="ms-4 leading-tight">
                    <div class="text-gray-900 dark:text-white">{{ $team->owner->name }}</div>
                    <div class="text-gray-700 dark:text-gray-300 text-sm">{{ $team->owner->email }}</div>
                </div>
            </div>
        </div>

        <!-- Team Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" :value="__('Nom de l\'organisation')" />

            <x-input id="name"
                        type="text"
                        class="mt-1 block w-full"
                        wire:model="state.name"
                        :disabled="! Gate::check('update', $team)" />

            <x-input-error for="name" class="mt-2" />
        </div>

        <!-- Google Integration -->
        <div class="col-span-6 border-t border-gray-100 dark:border-gray-700 pt-6 mt-4">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">{{ __('Intégration Google') }}</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                Ces informations permettent de récupérer et afficher vos avis Google My Business.
            </p>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="col-span-1">
                    <x-label for="google_place_id" value="{{ __('Google Place ID') }}" />
                    <x-input id="google_place_id" type="text" class="mt-1 block w-full" wire:model="state.google_place_id"
                        placeholder="ChIJ..." :disabled="! Gate::check('update', $team)" />
                    <p class="text-xs text-gray-500 mt-1">
                        <a href="https://developers.google.com/maps/documentation/places/web-service/place-id" target="_blank" class="text-emerald-600 hover:underline">
                            Comment trouver votre Place ID ?
                        </a>
                    </p>
                    <x-input-error for="google_place_id" class="mt-2" />
                </div>
                <div class="col-span-1">
                    <x-label for="google_api_key" value="{{ __('Clé API Google Places') }}" />
                    <x-input id="google_api_key" type="password" class="mt-1 block w-full" wire:model="state.google_api_key"
                        placeholder="AIza..." :disabled="! Gate::check('update', $team)" />
                    <p class="text-xs text-gray-500 mt-1">
                        Créez une clé dans la <a href="https://console.cloud.google.com/apis/credentials" target="_blank" class="text-emerald-600 hover:underline">Google Cloud Console</a>.
                    </p>
                    <x-input-error for="google_api_key" class="mt-2" />
                </div>
            </div>
        </div>
    </x-slot>

    @if (Gate::check('update', $team))
        <x-slot name="actions">
            <x-action-message class="me-3" on="saved">
                {{ __('Saved.') }}
            </x-action-message>

            <x-button>
                {{ __('Save') }}
            </x-button>
        </x-slot>
    @endif
</x-form-section>
