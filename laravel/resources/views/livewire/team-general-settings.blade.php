<x-form-section submit="updateGeneralInformation">
    <x-slot name="title">
        {{ __('Identité Visuelle') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Configurez les éléments visuels de votre organisation (Logo, Couverture, Bio) qui apparaitront sur votre profil public.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Branding -->
        <div class="col-span-6">
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
                        @if ($team->profile->logo_path)
                            <img src="{{ Storage::disk('minio_public')->url($team->profile->logo_path) }}" alt="{{ $team->name }}"
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

                    @if ($team->profile->logo_path)
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
                        @if ($team->profile->cover_image_path)
                            <img src="{{ Storage::disk('minio_public')->url($team->profile->cover_image_path) }}" alt="Cover"
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

                    @if ($team->profile->cover_image_path)
                        <x-secondary-button type="button" class="mt-2" wire:click="deleteCover">
                            {{ __('Supprimer') }}
                        </x-secondary-button>
                    @endif

                    <x-input-error for="cover" class="mt-2" />
                </div>
            </div>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="name">{{ __('Nom de l\'organisation') }}</x-label>
            <x-input id="name" type="text" class="mt-1 block w-full" wire:model="state.name" :disabled="! Gate::check('update', $team)" />
            <x-input-error for="state.name" class="mt-2" />
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
