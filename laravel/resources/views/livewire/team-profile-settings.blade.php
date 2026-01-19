<x-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Profil Public & Carte de Visite') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Configurez les informations visibles par vos clients sur votre page publique.') }}
        <div class="mt-4">
            <a href="{{ route('profile.public', $team->public_uuid) }}" target="_blank"
                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
                {{ __('Voir mon profil public') }}
            </a>
        </div>
        <div class="mt-2 text-xs text-gray-500">
            UUID: {{ $team->public_uuid }}
        </div>
    </x-slot>

    <x-slot name="form">
        <!-- Branding -->
        <div class="col-span-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">{{ __('Identité Visuelle') }}</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Logo -->
                <div x-data="{photoName: null, photoPreview: null}">
                    <input type="file" id="logo" class="hidden" wire:model.live="logo" x-ref="logo" x-on:change="
                                        photoName = $refs.logo.files[0].name;
                                        const reader = new FileReader();
                                        reader.onload = (e) => {
                                            photoPreview = e.target.result;
                                        };
                                        reader.readAsDataURL($refs.logo.files[0]);
                                " />

                    <x-label for="logo" value="{{ __('Logo') }}" />

                    <!-- Current Logo -->
                    <div class="mt-2" x-show="! photoPreview">
                        @if ($team->logo_path)
                            <img src="{{ Storage::disk('minio_public')->url($team->logo_path) }}" alt="{{ $team->name }}"
                                class="rounded-xl h-20 w-20 object-cover">
                        @else
                            <div
                                class="rounded-xl h-20 w-20 bg-emerald-100 flex items-center justify-center text-emerald-600 font-bold text-xl">
                                {{ substr($team->name, 0, 1) }}
                            </div>
                        @endif
                    </div>

                    <!-- New Logo Preview -->
                    <div class="mt-2" x-show="photoPreview" style="display: none;">
                        <span class="block rounded-xl h-20 w-20 bg-cover bg-no-repeat bg-center"
                            x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                        </span>
                    </div>

                    <x-secondary-button class="mt-2 me-2" type="button" x-on:click.prevent="$refs.logo.click()">
                        {{ __('Choisir un logo') }}
                    </x-secondary-button>

                    @if ($team->logo_path)
                        <x-secondary-button type="button" class="mt-2" wire:click="deleteLogo">
                            {{ __('Supprimer') }}
                        </x-secondary-button>
                    @endif

                    <x-input-error for="logo" class="mt-2" />
                </div>

                <!-- Cover Image -->
                <div x-data="{coverName: null, coverPreview: null}">
                    <input type="file" id="cover" class="hidden" wire:model.live="cover" x-ref="cover" x-on:change="
                                        coverName = $refs.cover.files[0].name;
                                        const reader = new FileReader();
                                        reader.onload = (e) => {
                                            coverPreview = e.target.result;
                                        };
                                        reader.readAsDataURL($refs.cover.files[0]);
                                " />

                    <x-label for="cover" value="{{ __('Image de couverture') }}" />

                    <!-- Current Cover -->
                    <div class="mt-2" x-show="! coverPreview">
                        @if ($team->cover_image_path)
                            <img src="{{ Storage::disk('minio_public')->url($team->cover_image_path) }}" alt="Cover"
                                class="rounded-xl h-32 w-full object-cover">
                        @else
                            <div class="rounded-xl h-32 w-full bg-gradient-to-r from-emerald-500 to-teal-500"></div>
                        @endif
                    </div>

                    <!-- New Cover Preview -->
                    <div class="mt-2" x-show="coverPreview" style="display: none;">
                        <span class="block rounded-xl h-32 w-full bg-cover bg-no-repeat bg-center"
                            x-bind:style="'background-image: url(\'' + coverPreview + '\');'">
                        </span>
                    </div>

                    <x-secondary-button class="mt-2 me-2" type="button" x-on:click.prevent="$refs.cover.click()">
                        {{ __('Choisir une couverture') }}
                    </x-secondary-button>

                    @if ($team->cover_image_path)
                        <x-secondary-button type="button" class="mt-2" wire:click="deleteCover">
                            {{ __('Supprimer') }}
                        </x-secondary-button>
                    @endif

                    <x-input-error for="cover" class="mt-2" />
                </div>
            </div>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="tagline" value="{{ __('Slogan / Accroche') }}" />
            <x-input id="tagline" type="text" class="mt-1 block w-full" wire:model="state.tagline"
                placeholder="Ex: Les meilleurs burgers de Paris" />
            <x-input-error for="state.tagline" class="mt-2" />
        </div>

        <div class="col-span-6">
            <x-label for="bio" value="{{ __('Présentation (Bio)') }}" />
            <textarea id="bio" wire:model="state.bio" rows="4"
                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm"
                placeholder="Racontez votre histoire..."></textarea>
            <x-input-error for="state.bio" class="mt-2" />
        </div>

        <!-- Contact -->
        <div class="col-span-6 border-t border-gray-100 dark:border-gray-700 pt-6 mt-2">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">{{ __('Coordonnées') }}</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="col-span-1">
                    <x-label for="address" value="{{ __('Adresse publique') }}" />
                    <x-input id="address" type="text" class="mt-1 block w-full" wire:model="state.address" />
                    <x-input-error for="state.address" class="mt-2" />
                </div>
                <div class="col-span-1">
                    <x-label for="city" value="{{ __('Site Web') }}" />
                    <x-input id="website" type="url" class="mt-1 block w-full" wire:model="state.website"
                        placeholder="https://..." />
                    <x-input-error for="state.website" class="mt-2" />
                </div>
                <div class="col-span-1">
                    <x-label for="email_public" value="{{ __('Email public') }}" />
                    <x-input id="email_public" type="email" class="mt-1 block w-full" wire:model="state.email_public" />
                    <x-input-error for="state.email_public" class="mt-2" />
                </div>
                <div class="col-span-1">
                    <x-label for="phone" value="{{ __('Téléphone') }}" />
                    <x-input id="phone" type="text" class="mt-1 block w-full" wire:model="state.phone" />
                    <x-input-error for="state.phone" class="mt-2" />
                </div>
            </div>
        </div>

        <!-- Social Media -->
        <div class="col-span-6 border-t border-gray-100 dark:border-gray-700 pt-6 mt-2">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">{{ __('Réseaux Sociaux') }}</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="col-span-1">
                    <x-label for="social_instagram" value="Instagram" />
                    <x-input id="social_instagram" type="url" class="mt-1 block w-full"
                        wire:model="state.social_instagram" placeholder="https://instagram.com/..." />
                </div>
                <div class="col-span-1">
                    <x-label for="social_facebook" value="Facebook" />
                    <x-input id="social_facebook" type="url" class="mt-1 block w-full"
                        wire:model="state.social_facebook" placeholder="https://facebook.com/..." />
                </div>
                <div class="col-span-1">
                    <x-label for="social_tiktok" value="TikTok" />
                    <x-input id="social_tiktok" type="url" class="mt-1 block w-full" wire:model="state.social_tiktok"
                        placeholder="https://tiktok.com/@..." />
                </div>
                <div class="col-span-1">
                    <x-label for="social_linkedin" value="LinkedIn" />
                    <x-input id="social_linkedin" type="url" class="mt-1 block w-full"
                        wire:model="state.social_linkedin" placeholder="https://linkedin.com/in/..." />
                </div>
            </div>
        </div>

        <!-- Reviews & Gating -->
        <div class="col-span-6 border-t border-gray-100 dark:border-gray-700 pt-6 mt-2">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                {{ __('Gestion des Avis (Review Gating)') }}
            </h3>

            <div class="flex items-center mb-4">
                <x-checkbox id="reviews_enabled" wire:model="state.reviews_enabled" />
                <div class="ml-2">
                    <x-label for="reviews_enabled" value="{{ __('Activer le système de collecte d\'avis') }}" />
                    <div class="text-xs text-gray-500">
                        {{ __('Permet de filtrer les avis négatifs en privé et d\'encourager les avis positifs sur Google.') }}
                    </div>
                </div>
            </div>

            <div x-show="$wire.state.reviews_enabled">
                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-label for="google_review_url" value="{{ __('Lien Google Review (Essentiel)') }}" />
                    <x-input id="google_review_url" type="url" class="mt-1 block w-full"
                        wire:model="state.google_review_url" placeholder="https://g.page/r/..." />
                    <p class="text-xs text-gray-500 mt-1">
                        {{ __('Le lien direct pour laisser un avis sur votre fiche Google Business.') }}
                    </p>
                    <x-input-error for="state.google_review_url" class="mt-2" />
                </div>

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

    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">
            {{ __('Sauvegardé.') }}
        </x-action-message>

        <x-button wire:loading.attr="disabled" wire:target="photo, cover">
            {{ __('Enregistrer') }}
        </x-button>
    </x-slot>
</x-form-section>