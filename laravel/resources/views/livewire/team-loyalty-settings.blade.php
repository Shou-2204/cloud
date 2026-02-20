<x-form-section submit="updateLoyaltySettings">
    <x-slot name="title">
        {{ __('Programme de fidélité') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Activez le programme de fidélité pour permettre à vos visiteurs de s\'inscrire et laissez le CRM collecter leurs coordonnées.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Modern Toggle Switch -->
        <div class="col-span-6 ">
            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800/50 rounded-xl mb-4">
                <div>
                    <div class="font-medium text-gray-900 dark:text-white">Cartes de fidélité client</div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Si vous activez cette option, un bouton apparaîtra sur votre profil public pour proposer à vos clients d'obtenir une carte de fidélité.
                    </p>
                </div>
                <button type="button" wire:click="$set('state.loyalty_enabled', !$wire.state.loyalty_enabled)"
                    :class="$wire.state.loyalty_enabled ? 'bg-emerald-600' : 'bg-gray-200 dark:bg-gray-700'"
                    class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2 dark:focus:ring-offset-gray-900"
                    role="switch" :aria-checked="$wire.state.loyalty_enabled">
                    <span class="sr-only">Activer la fidélité</span>
                    <span :class="$wire.state.loyalty_enabled ? 'translate-x-5' : 'translate-x-0'"
                        class="pointer-events-none relative inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out">
                        <span
                            :class="$wire.state.loyalty_enabled ? 'opacity-0 duration-100 ease-out' : 'opacity-100 duration-200 ease-in'"
                            class="absolute inset-0 flex h-full w-full items-center justify-center transition-opacity"
                            aria-hidden="true">
                            <svg class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 12 12">
                                <path d="M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                        <span
                            :class="$wire.state.loyalty_enabled ? 'opacity-100 duration-200 ease-in' : 'opacity-0 duration-100 ease-out'"
                            class="absolute inset-0 flex h-full w-full items-center justify-center transition-opacity"
                            aria-hidden="true">
                            <svg class="h-3 w-3 text-emerald-600" fill="currentColor" viewBox="0 0 12 12">
                                <path
                                    d="M3.707 5.293a1 1 0 00-1.414 1.414l1.414-1.414zM5 8l-.707.707a1 1 0 001.414 0L5 8zm4.707-3.293a1 1 0 00-1.414-1.414l1.414 1.414zm-7.414 2l2 2 1.414-1.414-2-2-1.414 1.414zm3.414 2l4-4-1.414-1.414-4 4 1.414 1.414z" />
                            </svg>
                        </span>
                    </span>
                </button>
            </div>
            <x-input-error for="state.loyalty_enabled" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">
            {{ __('Paramètres sauvegardés.') }}
        </x-action-message>

        <x-button>
            {{ __('Enregistrer') }}
        </x-button>
    </x-slot>
</x-form-section>
