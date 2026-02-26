<div class="max-w-4xl mx-auto">
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Gestion des Avis (Review Gating)') }}</h2>
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
            {{ __('Configurez le système de collecte d\'avis. Filtrez les avis négatifs et boostez vos avis Google.') }}
        </p>
    </div>

    <form wire:submit="updateReviewSettings" class="bg-white dark:bg-gray-800 shadow-xl border border-gray-100 dark:border-gray-700 sm:rounded-2xl overflow-hidden">
        <div class="p-6 sm:p-8">
            <!-- Modern Toggle Switch -->
            <div class="">
                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800/50 rounded-xl mb-6">
                    <div>
                        <div class="font-medium text-gray-900 dark:text-white">Activer le système de collecte d'avis</div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Filtre les avis négatifs en privé et encourage les avis positifs sur Google.
                        </p>
                    </div>
                    <button type="button" wire:click="$set('state.reviews_enabled', !$wire.state.reviews_enabled)"
                        :class="$wire.state.reviews_enabled ? 'bg-emerald-600' : 'bg-gray-200 dark:bg-gray-700'"
                        class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2 dark:focus:ring-offset-gray-900"
                        role="switch" :aria-checked="$wire.state.reviews_enabled">
                        <span class="sr-only">Activer les avis</span>
                        <span :class="$wire.state.reviews_enabled ? 'translate-x-5' : 'translate-x-0'"
                            class="pointer-events-none relative inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out">
                            <span
                                :class="$wire.state.reviews_enabled ? 'opacity-0 duration-100 ease-out' : 'opacity-100 duration-200 ease-in'"
                                class="absolute inset-0 flex h-full w-full items-center justify-center transition-opacity"
                                aria-hidden="true">
                                <svg class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 12 12">
                                    <path d="M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                            <span
                                :class="$wire.state.reviews_enabled ? 'opacity-100 duration-200 ease-in' : 'opacity-0 duration-100 ease-out'"
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
            </div>

            <div x-show="$wire.state.reviews_enabled" x-transition class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Google Place ID (NEW) -->
                    <div class="col-span-1 md:col-span-2">
                        <x-label for="google_place_id" value="{{ __('Google Place ID') }}" />
                        <x-input id="google_place_id" type="text" class="mt-1 block w-full"
                            wire:model="state.google_place_id" placeholder="ChI..." />
                        <p class="text-xs text-gray-500 mt-1">
                            {{ __('L\'identifiant unique de votre lieu sur Google Maps. ') }}
                            <a href="https://developers.google.com/maps/documentation/javascript/examples/places-placeid-finder" target="_blank" class="text-emerald-600 hover:text-emerald-500 underline">
                                {{ __('Trouver mon Place ID') }}
                            </a>
                        </p>
                        <x-input-error for="state.google_place_id" class="mt-2" />
                    </div>

                    <!-- Google Review URL -->
                    <div class="col-span-1">
                        <x-label for="google_review_url" value="{{ __('Lien Google Review (Essentiel)') }}" />
                        <x-input id="google_review_url" type="url" class="mt-1 block w-full"
                            wire:model="state.google_review_url" placeholder="https://g.page/r/..." />
                        <p class="text-xs text-gray-500 mt-1">
                            {{ __('Le lien direct pour laisser un avis sur votre fiche Google Business.') }}
                        </p>
                        <x-input-error for="state.google_review_url" class="mt-2" />
                    </div>

                    <!-- Feedback Email -->
                    <div class="col-span-1">
                        <x-label for="feedback_email" value="{{ __('Email de réception des avis négatifs') }}" />
                        <x-input id="feedback_email" type="email" class="mt-1 block w-full"
                            wire:model="state.feedback_email" placeholder="contact@votreentreprise.com" />
                        <p class="text-xs text-gray-500 mt-1">
                            {{ __('Les avis négatifs seront envoyés à cette adresse.') }}
                        </p>
                        <x-input-error for="state.feedback_email" class="mt-2" />
                    </div>

                    <!-- Digest Frequency -->
                    <div class="col-span-1 md:col-span-2">
                        <x-label for="digest_frequency" value="{{ __('Fréquence des emails récapitulatifs') }}" />
                        <select id="digest_frequency" wire:model="state.digest_frequency"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm">
                            <option value="daily">Quotidien (8h)</option>
                            <option value="weekly">Hebdomadaire (Lundi 8h)</option>
                            <option value="monthly">Mensuel (1er du mois)</option>
                            <option value="none">Désactivé</option>
                        </select>
                        <p class="text-xs text-gray-500 mt-1">
                            {{ __('Recevez un récapitulatif des nouveaux avis par email selon cette fréquence.') }}
                        </p>
                        <x-input-error for="state.digest_frequency" class="mt-2" />
                    </div>
                </div>

                <hr class="border-gray-200 dark:border-gray-700">

                <!-- Messages -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Messages personnalisés</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-label for="review_positive_message" value="{{ __('Message Avis Positif') }}" />
                            <textarea id="review_positive_message" wire:model="state.review_positive_message" rows="3"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-md shadow-sm"
                                placeholder="Merci ! Laissez-nous un avis sur Google..."></textarea>
                        </div>
                        <div>
                            <x-label for="review_negative_message" value="{{ __('Message Avis Négatif') }}" />
                            <textarea id="review_negative_message" wire:model="state.review_negative_message" rows="3"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-md shadow-sm"
                                placeholder="Désolé.. Dites-nous comment nous améliorer..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end px-6 py-4 bg-gray-50 dark:bg-gray-800/50 text-right sm:px-8 border-t border-gray-100 dark:border-gray-700">
            <x-action-message class="me-3" on="saved">
                {{ __('Sauvegardé.') }}
            </x-action-message>

            <x-button>
                {{ __('Enregistrer') }}
            </x-button>
        </div>
    </form>
</div>
