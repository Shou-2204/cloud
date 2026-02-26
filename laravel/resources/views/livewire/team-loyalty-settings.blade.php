<div class="max-w-4xl mx-auto">
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Programme de fidélité') }}</h2>
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
            {{ __('Activez le programme de fidélité pour permettre à vos visiteurs de s\'inscrire et laissez le CRM collecter leurs coordonnées.') }}
        </p>
    </div>

    <form wire:submit="updateLoyaltySettings" class="bg-white dark:bg-gray-800 shadow-xl border border-gray-100 dark:border-gray-700 sm:rounded-2xl overflow-hidden">
        <div class="p-6 sm:p-8">
            <!-- Modern Toggle Switch -->
            <div class="">
                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800/50 rounded-xl mb-6">
                    <div>
                        <div class="font-medium text-gray-900 dark:text-white">Cartes de fidélité client</div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
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

            @if($state['loyalty_enabled'])
                <div class="space-y-6">
                    <!-- STEP 1: Onboarding / Choose Program Type -->
                    @if(is_null($state['loyalty_program_type']))
                        <div class="p-6 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm mt-4">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Étape 1 : Choisissez votre programme</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Visits Option -->
                                <button type="button" wire:click="selectProgramType('visits')" class="text-left p-5 rounded-xl border-2 border-gray-200 dark:border-gray-700 hover:border-emerald-500 dark:hover:border-emerald-500 transition-colors group">
                                    <div class="flex items-center gap-3 mb-2">
                                        <div class="w-10 h-10 rounded-lg bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600">
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        </div>
                                        <h4 class="font-bold text-gray-900 dark:text-white">Programme par Visites</h4>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                        <strong>Idéal pour les commerces de proximité.</strong> (Ex: Boulangeries, coiffeurs)
                                    </p>
                                    <p class="text-xs text-emerald-600 font-medium bg-emerald-50 dark:bg-emerald-900/20 inline-block px-2 py-1 rounded">1 passage = 1 point</p>
                                </button>

                                <!-- Points Option -->
                                <button type="button" wire:click="selectProgramType('points')" class="text-left p-5 rounded-xl border-2 border-gray-200 dark:border-gray-700 hover:border-purple-500 dark:hover:border-purple-500 transition-colors group">
                                    <div class="flex items-center gap-3 mb-2">
                                        <div class="w-10 h-10 rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center text-purple-600">
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        </div>
                                        <h4 class="font-bold text-gray-900 dark:text-white">Programme sur Montant</h4>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                        <strong>Idéal pour récompenser selon le montant dépensé.</strong> (Ex: Restaurants, boutiques)
                                    </p>
                                    <p class="text-xs text-purple-600 font-medium bg-purple-50 dark:bg-purple-900/20 inline-block px-2 py-1 rounded">Vous définissez le nombre de points distribués</p>
                                </button>
                            </div>
                        </div>
                    <!-- STEP 2: Manage Rewards -->
                    @else
                        <div class="p-6 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm mt-4">
                            <div class="flex justify-between items-center mb-6">
                                <div>
                                    <div class="flex items-center gap-3">
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Paliers de récompenses</h3>
                                        <span class="px-2 py-0.5 text-xs font-bold rounded-full {{ count($this->rewards) >= 10 ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300' }}">
                                            {{ count($this->rewards) }}/10
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                        Programme actuel: 
                                        <strong class="{{ $state['loyalty_program_type'] === 'visits' ? 'text-emerald-600' : 'text-purple-600' }}">
                                            {{ $state['loyalty_program_type'] === 'visits' ? 'Visites (1 passage = 1 pt)' : 'Points (Selon le montant)' }}
                                        </strong>
                                    </p>
                                </div>
                                <button type="button" wire:click="$set('state.loyalty_program_type', null)" class="text-sm text-blue-600 hover:text-blue-700 hover:underline">Changer de programme</button>
                            </div>

                            <!-- Add Reward Form -->
                            <div class="flex flex-col md:flex-row items-start md:items-start gap-3 mb-6 bg-gray-50 dark:bg-gray-900/50 p-4 rounded-xl shadow-inner border border-gray-100 dark:border-gray-800">
                                <div class="w-full md:w-20 flex-shrink-0 relative">
                                    <x-label for="reward_icon" value="Icône" class="text-xs font-semibold" />
                                    <select wire:model="newReward.icon" id="reward_icon" class="mt-1 block w-full h-[42px] pl-3 pr-8 py-0 border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 focus:border-emerald-500 rounded-lg shadow-sm text-xl cursor-pointer">
                                        <option value="gift">🎁</option>
                                        <option value="star">⭐</option>
                                        <option value="coffee">☕</option>
                                        <option value="ticket">🎫</option>
                                        <option value="percent">🏷️</option>
                                        <option value="cake">🎂</option>
                                        <option value="burger">🍔</option>
                                        <option value="pizza">🍕</option>
                                        <option value="drink">🥤</option>
                                        <option value="icecream">🍦</option>
                                        <option value="scissors">✂️</option>
                                        <option value="massage">💆</option>
                                        <option value="car">🚗</option>
                                        <option value="bag">👜</option>
                                        <option value="money">💸</option>
                                    </select>
                                    <x-input-error for="newReward.icon" class="mt-1 text-xs absolute" />
                                </div>
                                <div class="flex-1 w-full relative">
                                    <x-label for="reward_name" value="Nom de la récompense" class="text-xs font-semibold" />
                                    <x-input id="reward_name" type="text" class="mt-1 block w-full h-[42px] rounded-lg text-sm" wire:model="newReward.name" placeholder="Ex: Café offert" />
                                    <x-input-error for="newReward.name" class="mt-1 text-xs absolute" />
                                </div>
                                <div class="w-full md:w-32 flex-shrink-0 relative">
                                    <x-label for="reward_points" value="{{ $state['loyalty_program_type'] === 'visits' ? 'Visites' : 'Points' }}" class="text-xs font-semibold" />
                                    <x-input id="reward_points" type="number" min="1" class="mt-1 block w-full h-[42px] rounded-lg text-sm" wire:model="newReward.points_required" placeholder="10" />
                                    <x-input-error for="newReward.points_required" class="mt-1 text-xs absolute" />
                                </div>
                                <div class="w-full md:w-auto flex-shrink-0 mt-0 md:mt-5">
                                    <button type="button" wire:click="addReward" class="w-full md:w-auto px-5 h-[42px] bg-gray-900 hover:bg-gray-800 text-white dark:bg-white dark:text-gray-900 dark:hover:bg-gray-100 rounded-lg font-bold text-sm transition-colors flex items-center justify-center shadow-sm">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                                        Ajouter
                                    </button>
                                </div>
                            </div>

                            <!-- Rewards List -->
                            <div class="space-y-3">
                                @forelse($this->rewards as $reward)
                                    <div class="flex items-center justify-between p-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 rounded-full bg-{{ $state['loyalty_program_type'] === 'visits' ? 'emerald' : 'purple' }}-100 flex items-center justify-center text-2xl">
                                                {{ ['gift'=>'🎁','star'=>'⭐','coffee'=>'☕','ticket'=>'🎫','percent'=>'🏷️','cake'=>'🎂','burger'=>'🍔','pizza'=>'🍕','drink'=>'🥤','icecream'=>'🍦','scissors'=>'✂️','massage'=>'💆','car'=>'🚗','bag'=>'👜','money'=>'💸'][$reward->icon ?? 'gift'] ?? '🎁' }}
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-900 dark:text-white">{{ $reward->name }}</p>
                                                <p class="text-xs font-bold text-{{ $state['loyalty_program_type'] === 'visits' ? 'emerald' : 'purple' }}-600">{{ $reward->points_required }} {{ $state['loyalty_program_type'] === 'visits' ? 'visites' : 'points' }}</p>
                                            </div>
                                        </div>
                                        <button type="button" wire:click="confirmDeleteReward({{ $reward->id }})" class="text-red-500 hover:text-red-700 p-2 transition-colors">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </div>
                                @empty
                                    <div class="text-center py-6 text-gray-500 dark:text-gray-400 border border-dashed border-gray-300 dark:border-gray-700 rounded-xl bg-gray-50 dark:bg-gray-800/50">
                                        Aucune récompense configurée. Ajoutez un premier palier ci-dessus !
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Points Expiration Settings -->
                        <div class="p-6 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm mt-4">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Expiration des {{ $state['loyalty_program_type'] === 'visits' ? 'visites' : 'points' }}</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                        Définissez si les {{ $state['loyalty_program_type'] === 'visits' ? 'visites' : 'points' }} accumulés par vos clients expirent chaque année.
                                    </p>
                                </div>
                                <div class="ml-4 flex-shrink-0">
                                    <button type="button" wire:click="$set('state.loyalty_points_expire', !$wire.state.loyalty_points_expire)"
                                        :class="$wire.state.loyalty_points_expire ? 'bg-emerald-600' : 'bg-gray-200 dark:bg-gray-700'"
                                        class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2 dark:focus:ring-offset-gray-900"
                                        role="switch" :aria-checked="$wire.state.loyalty_points_expire">
                                        <span :class="$wire.state.loyalty_points_expire ? 'translate-x-5' : 'translate-x-0'"
                                            class="pointer-events-none relative inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out">
                                            <span :class="$wire.state.loyalty_points_expire ? 'opacity-0 duration-100 ease-out' : 'opacity-100 duration-200 ease-in'" class="absolute inset-0 flex h-full w-full items-center justify-center transition-opacity" aria-hidden="true">
                                                <svg class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 12 12"><path d="M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                                            </span>
                                            <span :class="$wire.state.loyalty_points_expire ? 'opacity-100 duration-200 ease-in' : 'opacity-0 duration-100 ease-out'" class="absolute inset-0 flex h-full w-full items-center justify-center transition-opacity" aria-hidden="true">
                                                <svg class="h-3 w-3 text-emerald-600" fill="currentColor" viewBox="0 0 12 12"><path d="M3.707 5.293a1 1 0 00-1.414 1.414l1.414-1.414zM5 8l-.707.707a1 1 0 001.414 0L5 8zm4.707-3.293a1 1 0 00-1.414-1.414l1.414 1.414zm-7.414 2l2 2 1.414-1.414-2-2-1.414 1.414zm3.414 2l4-4-1.414-1.414-4 4 1.414 1.414z" /></svg>
                                            </span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                            
                            @if($state['loyalty_points_expire'])
                                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                                    <x-label value="Date de réinitialisation annuelle" />
                                    
                                    <div class="mt-2">
                                        <x-input type="date" wire:model="state.loyalty_points_expiration_date" class="mt-1 block max-w-sm" />
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">L'année sélectionnée sera ignorée, seul le mois et le jour seront pris en compte. Les {{ $state['loyalty_program_type'] === 'visits' ? 'visites' : 'points' }} de tous les clients de l'année en cours seront réinitialisés à zéro le lendemain de cette date.</p>
                                    <x-input-error for="state.loyalty_points_expiration_date" class="mt-2" />
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center justify-end px-6 py-4 bg-gray-50 dark:bg-gray-800/50 text-right sm:px-8 border-t border-gray-100 dark:border-gray-700">
            <x-action-message class="me-3" on="saved">
                {{ __('Paramètres sauvegardés.') }}
            </x-action-message>

            <x-button>
                {{ __('Enregistrer') }}
            </x-button>
        </div>
    </form>

    <!-- Confirm Program Change Modal -->
    <x-confirmation-modal wire:model.live="confirmingProgramChange">
        <x-slot name="title">
            {{ __('Changer de programme de fidélité') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Attention ! Si vous changez de programme de fidélité :') }}
            <ul class="list-disc list-inside mt-3 mb-4 text-sm text-gray-600 dark:text-gray-400">
                <li>{{ __('Tous les points et visites accumulés par vos clients seront remis à zéro.') }}</li>
                <li>{{ __('Toutes les récompenses configurées actuellement seront supprimées.') }}</li>
            </ul>
            {{ __('Êtes-vous sûr de vouloir continuer ?') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmingProgramChange')" wire:loading.attr="disabled">
                {{ __('Annuler') }}
            </x-secondary-button>

            <x-danger-button class="ms-3" wire:click="changeProgramAndResetPoints" wire:loading.attr="disabled">
                {{ __('Oui, changer de programme et réinitialiser') }}
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>

    <!-- Confirm Reward Deletion Modal -->
    <x-confirmation-modal wire:model.live="confirmingRewardDeletion">
        <x-slot name="title">
            {{ __('Supprimer cette récompense') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Êtes-vous sûr de vouloir supprimer cette récompense ? Cette action est irréversible.') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmingRewardDeletion')" wire:loading.attr="disabled">
                {{ __('Annuler') }}
            </x-secondary-button>

            <x-danger-button class="ms-3" wire:click="deleteReward" wire:loading.attr="disabled">
                {{ __('Oui, supprimer') }}
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>
</div>
