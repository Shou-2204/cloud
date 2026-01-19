<x-action-section>
    <x-slot name="title">
        {{ __('Supprimer l\'organisation') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Supprimer définitivement cette organisation.') }}
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
            {{ __('Une fois l\'organisation supprimée, toutes ses ressources et données seront définitivement effacées. Avant de supprimer cette organisation, veuillez télécharger toute donnée que vous souhaitez conserver.') }}
        </div>

        <div class="mt-5">
            <x-danger-button wire:click="$toggle('confirmingTeamDeletion')" wire:loading.attr="disabled">
                {{ __('Supprimer l\'organisation') }}
            </x-danger-button>
        </div>

        <!-- Delete Team Confirmation Modal -->
        <x-confirmation-modal wire:model.live="confirmingTeamDeletion">
            <x-slot name="title">
                {{ __('Supprimer l\'organisation') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Êtes-vous sûr de vouloir supprimer cette organisation ? Toutes ses ressources et données seront définitivement effacées.') }}
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('confirmingTeamDeletion')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3" wire:click="deleteTeam" wire:loading.attr="disabled">
                    {{ __('Supprimer l\'organisation') }}
                </x-danger-button>
            </x-slot>
        </x-confirmation-modal>
    </x-slot>
</x-action-section>