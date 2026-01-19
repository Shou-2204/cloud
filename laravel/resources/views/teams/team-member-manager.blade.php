<div>
    @if (Gate::check('addTeamMember', $team))
        <x-section-border />

        <div class="mt-10 sm:mt-0">
            <x-form-section submit="addTeamMember">
                <x-slot name="title">
                    {{ __('Ajouter un membre') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('Ajoutez un membre à votre organisation pour collaborer ensemble.') }}
                </x-slot>

                <x-slot name="form">
                    <div class="col-span-6">
                        <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Veuillez indiquer l\'adresse e-mail de la personne que vous souhaitez ajouter.') }}
                        </div>
                    </div>

                    <div class="col-span-6">
                        <label class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-2">Code d'accès unique</label>
                        <div class="flex items-center space-x-3" x-data="{ copied: false }">
                            <div class="bg-gray-100 dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-md py-2 px-4 font-mono text-lg font-bold tracking-widest text-emerald-600 dark:text-emerald-400 select-all">
                                {{ $team->join_code }}
                            </div>
                            
                            <button type="button" 
                                    @click="navigator.clipboard.writeText('{{ $team->join_code }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                    class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none transition">
                                <span x-show="!copied" class="flex items-center">Copier</span>
                                <span x-show="copied" class="flex items-center text-green-600 dark:text-green-400" style="display: none;">Copié !</span>
                            </button>
                        </div>
                    </div>
                    <div class="col-span-6 border-t border-gray-200 dark:border-gray-700 my-2"></div>

                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="email" value="{{ __('Email') }}" />
                        <x-input id="email" type="email" class="mt-1 block w-full" wire:model="addTeamMemberForm.email" />
                        <x-input-error for="email" class="mt-2" />
                    </div>

                    @if (count($this->roles) > 0)
                        <div class="col-span-6 lg:col-span-4">
                            <x-label for="role" value="{{ __('Role') }}" />
                            <x-input-error for="role" class="mt-2" />

                            <div class="relative z-0 mt-1 border border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer">
                                @foreach ($this->roles as $index => $role)
                                    <button type="button" class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-emerald-500 dark:focus:border-emerald-600 focus:ring-2 focus:ring-emerald-500 dark:focus:ring-emerald-600 {{ $index > 0 ? 'border-t border-gray-200 dark:border-gray-700 focus:border-none rounded-t-none' : '' }} {{ ! $loop->last ? 'rounded-b-none' : '' }}"
                                                    wire:click="$set('addTeamMemberForm.role', '{{ $role->key }}')">
                                        <div class="{{ isset($addTeamMemberForm['role']) && $addTeamMemberForm['role'] !== $role->key ? 'opacity-50' : '' }}">
                                            <div class="flex items-center">
                                                <div class="text-sm text-gray-600 dark:text-gray-400 {{ $addTeamMemberForm['role'] == $role->key ? 'font-semibold' : '' }}">
                                                    {{ $role->name }}
                                                </div>
                                                @if ($addTeamMemberForm['role'] == $role->key)
                                                    <svg class="ms-2 size-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                @endif
                                            </div>
                                            <div class="mt-2 text-xs text-gray-600 dark:text-gray-400 text-start">{{ $role->description }}</div>
                                        </div>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </x-slot>

                <x-slot name="actions">
                    <x-action-message class="me-3" on="saved">{{ __('Ajouté.') }}</x-action-message>
                    <x-button>{{ __('Ajouter') }}</x-button>
                </x-slot>
            </x-form-section>
        </div>
    @endif

    @if ($team->teamInvitations->isNotEmpty() && Gate::check('addTeamMember', $team))
        <x-section-border />
        <div class="mt-10 sm:mt-0">
            <x-action-section>
                <x-slot name="title">{{ __('Invitations en attente') }}</x-slot>
                <x-slot name="description">{{ __('Invitations envoyées par e-mail.') }}</x-slot>
                <x-slot name="content">
                    <div class="space-y-6">
                        @foreach ($team->teamInvitations as $invitation)
                            <div class="flex items-center justify-between">
                                <div class="text-gray-600 dark:text-gray-400">{{ $invitation->email }}</div>
                                <div class="flex items-center">
                                    @if (Gate::check('removeTeamMember', $team))
                                        <button class="cursor-pointer ms-6 text-sm text-red-500 focus:outline-none" wire:click="cancelTeamInvitation({{ $invitation->id }})">{{ __('Annuler') }}</button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-slot>
            </x-action-section>
        </div>
    @endif

    <x-section-border />

    <div class="mt-10 sm:mt-0">
        <x-action-section>
            <x-slot name="title">
                {{ __('Membres de l\'organisation') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Toutes les personnes qui font partie de cette organisation.') }}
            </x-slot>

            <x-slot name="content">
                <div class="space-y-6">
                    @php
                        // On prépare la liste propre : On enlève soi-même et ceux non approuvés
                        $approvedMembers = $team->users->filter(function($user) {
                            return $user->id !== Auth::id() && 
                                   isset($user->membership) && 
                                   $user->membership->is_approved == 1;
                        })->sortBy('name');
                    @endphp

                    @if($approvedMembers->isEmpty())
                        <div class="text-sm text-gray-500 dark:text-gray-400 italic">
                            {{ __('Aucun membre valid\u00e9 dans cette organisation pour le moment.') }}
                        </div>
                    @else
                        @foreach ($approvedMembers as $user)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <img class="size-8 rounded-full object-cover" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">
                                    <div class="ms-4 dark:text-white">{{ $user->name }}</div>
                                </div>

                                <div class="flex items-center">
                                    @if (Gate::check('updateTeamMember', $team) && Laravel\Jetstream\Jetstream::hasRoles())
                                        <button class="ms-2 text-sm text-gray-400 underline" wire:click="manageRole('{{ $user->id }}')">
                                            {{ Laravel\Jetstream\Jetstream::findRole($user->membership->role)->name ?? 'Editor' }}
                                        </button>
                                    @elseif (Laravel\Jetstream\Jetstream::hasRoles())
                                        <div class="ms-2 text-sm text-gray-400">
                                            {{ Laravel\Jetstream\Jetstream::findRole($user->membership->role)->name ?? 'Editor' }}
                                        </div>
                                    @endif

                                    @if ($this->user->id === $user->id)
                                        <button class="cursor-pointer ms-6 text-sm text-red-500" wire:click="$toggle('confirmingLeavingTeam')">
                                            {{ __('Quitter') }}
                                        </button>
                                    @elseif (Gate::check('removeTeamMember', $team))
                                        <button class="cursor-pointer ms-6 text-sm text-red-500" wire:click="confirmTeamMemberRemoval('{{ $user->id }}')">
                                            {{ __('Retirer') }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </x-slot>
        </x-action-section>
    </div>

    <x-dialog-modal wire:model.live="currentlyManagingRole">
        <x-slot name="title">{{ __('Manage Role') }}</x-slot>
        <x-slot name="content">
            <div class="relative z-0 mt-1 border border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer">
                @foreach ($this->roles as $index => $role)
                    <button type="button" class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none {{ $index > 0 ? 'border-t border-gray-200 dark:border-gray-700' : '' }}" wire:click="$set('currentRole', '{{ $role->key }}')">
                        <div class="{{ $currentRole !== $role->key ? 'opacity-50' : '' }}">
                            <div class="text-sm font-semibold">{{ $role->name }}</div>
                            <div class="mt-2 text-xs text-gray-600 dark:text-gray-400 text-start">{{ $role->description }}</div>
                        </div>
                    </button>
                @endforeach
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="stopManagingRole">{{ __('Annuler') }}</x-secondary-button>
            <x-button class="ms-3" wire:click="updateRole">{{ __('Enregistrer') }}</x-button>
        </x-slot>
    </x-dialog-modal>

    <x-confirmation-modal wire:model.live="confirmingLeavingTeam">
        <x-slot name="title">{{ __('Quitter l\'organisation') }}</x-slot>
        <x-slot name="content">{{ __('Êtes-vous sûr ?') }}</x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmingLeavingTeam')">{{ __('Annuler') }}</x-secondary-button>
            <x-danger-button class="ms-3" wire:click="leaveTeam">{{ __('Quitter') }}</x-danger-button>
        </x-slot>
    </x-confirmation-modal>

    <x-confirmation-modal wire:model.live="confirmingTeamMemberRemoval">
        <x-slot name="title">{{ __('Retirer un membre') }}</x-slot>
        <x-slot name="content">{{ __('Êtes-vous sûr ?') }}</x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmingTeamMemberRemoval')">{{ __('Annuler') }}</x-secondary-button>
            <x-danger-button class="ms-3" wire:click="removeTeamMember">{{ __('Retirer') }}</x-danger-button>
        </x-slot>
    </x-confirmation-modal>
</div>