<div class="max-w-5xl mx-auto">
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Apple Wallet') }}</h2>
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
            {{ __('Personnalisez la carte de fidélité Apple Wallet de vos clients.') }}
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- LEFT COLUMN: Settings Form --}}
        <div class="space-y-6">
            {{-- Colors & Labels --}}
            <form wire:submit="save" class="bg-white dark:bg-gray-800 shadow-xl border border-gray-100 dark:border-gray-700 sm:rounded-2xl overflow-hidden">
                <div class="p-6 sm:p-8 space-y-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" /></svg>
                        Couleurs & Textes
                    </h3>

                    {{-- Logo Text --}}
                    <div>
                        <x-label for="logo_text" value="Nom affiché sur le pass" />
                        <x-input id="logo_text" type="text" class="mt-1 block w-full" wire:model.live="state.logo_text" placeholder="{{ $team->name }}" />
                        <x-input-error for="state.logo_text" class="mt-2" />
                    </div>

                    {{-- Primary Label --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-label for="label_primary" value="Label principal" />
                            <x-input id="label_primary" type="text" class="mt-1 block w-full" wire:model.live="state.label_primary" />
                            <x-input-error for="state.label_primary" class="mt-2" />
                        </div>
                        <div>
                            <x-label for="label_secondary" value="Label secondaire" />
                            <x-input id="label_secondary" type="text" class="mt-1 block w-full" wire:model.live="state.label_secondary" />
                            <x-input-error for="state.label_secondary" class="mt-2" />
                        </div>
                    </div>

                    {{-- Colors --}}
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <x-label value="Fond" />
                            <div class="mt-1 flex items-center gap-2">
                                <input type="color" wire:model.live="state.background_color" class="h-10 w-14 rounded-lg border border-gray-300 dark:border-gray-600 cursor-pointer">
                                <span class="text-xs font-mono text-gray-500 dark:text-gray-400">{{ $state['background_color'] }}</span>
                            </div>
                            <x-input-error for="state.background_color" class="mt-2" />
                        </div>
                        <div>
                            <x-label value="Texte" />
                            <div class="mt-1 flex items-center gap-2">
                                <input type="color" wire:model.live="state.foreground_color" class="h-10 w-14 rounded-lg border border-gray-300 dark:border-gray-600 cursor-pointer">
                                <span class="text-xs font-mono text-gray-500 dark:text-gray-400">{{ $state['foreground_color'] }}</span>
                            </div>
                            <x-input-error for="state.foreground_color" class="mt-2" />
                        </div>
                        <div>
                            <x-label value="Labels" />
                            <div class="mt-1 flex items-center gap-2">
                                <input type="color" wire:model.live="state.label_color" class="h-10 w-14 rounded-lg border border-gray-300 dark:border-gray-600 cursor-pointer">
                                <span class="text-xs font-mono text-gray-500 dark:text-gray-400">{{ $state['label_color'] }}</span>
                            </div>
                            <x-input-error for="state.label_color" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-100 dark:border-gray-700">
                    <button type="button" wire:click="resetToDefaults" class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">
                        Réinitialiser
                    </button>
                    <div class="flex items-center gap-3">
                        <x-action-message class="me-3" on="saved">
                            {{ __('Sauvegardé !') }}
                        </x-action-message>
                        <x-button>
                            {{ __('Enregistrer') }}
                        </x-button>
                    </div>
                </div>
            </form>

            {{-- Images Upload --}}
            <div class="bg-white dark:bg-gray-800 shadow-xl border border-gray-100 dark:border-gray-700 sm:rounded-2xl overflow-hidden">
                <div class="p-6 sm:p-8 space-y-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        Images
                    </h3>

                    <p class="text-xs text-gray-500 dark:text-gray-400">Format PNG obligatoire. Les images @2x sont recommandées pour les écrans Retina.</p>

                    {{-- Icon --}}
                    @php $settings = $this->settings; @endphp

                    <div class="space-y-4">
                        {{-- Icon Upload --}}
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-900/50 rounded-xl">
                            <div>
                                <p class="font-medium text-sm text-gray-900 dark:text-white">Icône <span class="text-xs text-red-500">*</span></p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">87×87px (ou 174×174 @2x)</p>
                            </div>
                            <div class="flex items-center gap-3">
                                @if($settings?->icon_path)
                                    <span class="text-xs text-emerald-600 font-bold">✓ Uploadé</span>
                                    <button type="button" wire:click="removeImage('icon')" class="text-xs text-red-500 hover:text-red-700">Supprimer</button>
                                @endif
                                <label class="cursor-pointer px-3 py-1.5 text-xs font-bold bg-gray-900 dark:bg-white text-white dark:text-gray-900 rounded-lg hover:opacity-80 transition-opacity">
                                    {{ $settings?->icon_path ? 'Remplacer' : 'Uploader' }}
                                    <input type="file" wire:model="iconFile" accept=".png" class="hidden">
                                </label>
                            </div>
                        </div>
                        @if($iconFile)
                            <div class="flex justify-end">
                                <button type="button" wire:click="uploadImage('icon')" class="px-4 py-2 text-xs font-bold bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">
                                    Confirmer l'upload de l'icône
                                </button>
                            </div>
                        @endif
                        <x-input-error for="iconFile" class="mt-1" />

                        {{-- Logo Upload --}}
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-900/50 rounded-xl">
                            <div>
                                <p class="font-medium text-sm text-gray-900 dark:text-white">Logo</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">160×50px (ou 320×100 @2x)</p>
                            </div>
                            <div class="flex items-center gap-3">
                                @if($settings?->logo_image_path)
                                    <span class="text-xs text-emerald-600 font-bold">✓ Uploadé</span>
                                    <button type="button" wire:click="removeImage('logo')" class="text-xs text-red-500 hover:text-red-700">Supprimer</button>
                                @endif
                                <label class="cursor-pointer px-3 py-1.5 text-xs font-bold bg-gray-900 dark:bg-white text-white dark:text-gray-900 rounded-lg hover:opacity-80 transition-opacity">
                                    {{ $settings?->logo_image_path ? 'Remplacer' : 'Uploader' }}
                                    <input type="file" wire:model="logoFile" accept=".png" class="hidden">
                                </label>
                            </div>
                        </div>
                        @if($logoFile)
                            <div class="flex justify-end">
                                <button type="button" wire:click="uploadImage('logo')" class="px-4 py-2 text-xs font-bold bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">
                                    Confirmer l'upload du logo
                                </button>
                            </div>
                        @endif
                        <x-input-error for="logoFile" class="mt-1" />

                        {{-- Strip Upload --}}
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-900/50 rounded-xl">
                            <div>
                                <p class="font-medium text-sm text-gray-900 dark:text-white">Bandeau (Strip)</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">375×123px (ou 750×246 @2x) — Image de fond</p>
                            </div>
                            <div class="flex items-center gap-3">
                                @if($settings?->strip_path)
                                    <span class="text-xs text-emerald-600 font-bold">✓ Uploadé</span>
                                    <button type="button" wire:click="removeImage('strip')" class="text-xs text-red-500 hover:text-red-700">Supprimer</button>
                                @endif
                                <label class="cursor-pointer px-3 py-1.5 text-xs font-bold bg-gray-900 dark:bg-white text-white dark:text-gray-900 rounded-lg hover:opacity-80 transition-opacity">
                                    {{ $settings?->strip_path ? 'Remplacer' : 'Uploader' }}
                                    <input type="file" wire:model="stripFile" accept=".png" class="hidden">
                                </label>
                            </div>
                        </div>
                        @if($stripFile)
                            <div class="flex justify-end">
                                <button type="button" wire:click="uploadImage('strip')" class="px-4 py-2 text-xs font-bold bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">
                                    Confirmer l'upload du bandeau
                                </button>
                            </div>
                        @endif
                        <x-input-error for="stripFile" class="mt-1" />
                    </div>

                    <x-action-message on="image-uploaded">
                        {{ __('Image uploadée !') }}
                    </x-action-message>
                    <x-action-message on="image-removed">
                        {{ __('Image supprimée.') }}
                    </x-action-message>
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN: Live Preview --}}
        <div class="lg:sticky lg:top-8 self-start">
            <h3 class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4 text-center">Aperçu en temps réel</h3>

            {{-- Pass Preview Card --}}
            <div class="mx-auto" style="max-width: 340px;">
                <div class="rounded-2xl overflow-hidden shadow-2xl" style="background-color: {{ $state['background_color'] }};">
                    {{-- Header: Logo area --}}
                    <div class="px-5 pt-5 pb-3 flex items-center gap-3">
                        {{-- Icon preview --}}
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center text-lg font-bold overflow-hidden"
                             style="background-color: rgba(255,255,255,0.15); color: {{ $state['foreground_color'] }};">
                            @if($settings?->icon_path)
                                <img src="{{ Storage::disk('cloud_public')->url($settings->icon_path) }}" class="w-full h-full object-cover" alt="icon">
                            @else
                                {{ strtoupper(substr($state['logo_text'] ?: $team->name, 0, 1)) }}
                            @endif
                        </div>
                        <span class="text-base font-bold" style="color: {{ $state['foreground_color'] }};">
                            {{ $state['logo_text'] ?: $team->name }}
                        </span>
                    </div>

                    {{-- Strip / Banner area --}}
                    @if($settings?->strip_path)
                        <div class="w-full h-24 overflow-hidden">
                            <img src="{{ Storage::disk('cloud_public')->url($settings->strip_path) }}" class="w-full h-full object-cover" alt="strip">
                        </div>
                    @endif

                    {{-- Primary Field --}}
                    <div class="px-5 py-4">
                        <p class="text-[10px] uppercase tracking-wider font-bold opacity-70" style="color: {{ $state['label_color'] ?? $state['foreground_color'] }};">
                            {{ $state['label_primary'] }}
                        </p>
                        <p class="text-4xl font-black mt-0.5" style="color: {{ $state['foreground_color'] }};">
                            150
                        </p>
                    </div>

                    {{-- Secondary Field --}}
                    <div class="px-5 pb-3">
                        <p class="text-[10px] uppercase tracking-wider font-bold opacity-70" style="color: {{ $state['label_color'] ?? $state['foreground_color'] }};">
                            {{ $state['label_secondary'] }}
                        </p>
                        <p class="text-sm font-semibold mt-0.5" style="color: {{ $state['foreground_color'] }};">
                            John Doe
                        </p>
                    </div>

                    {{-- Barcode Area --}}
                    <div class="px-5 pb-5 pt-2">
                        <div class="bg-white rounded-xl p-4 flex items-center justify-center">
                            <div class="w-24 h-24 bg-gray-200 rounded-lg flex items-center justify-center">
                                <svg class="w-16 h-16 text-gray-700" viewBox="0 0 24 24" fill="currentColor">
                                    <rect x="3" y="3" width="3" height="3"/><rect x="9" y="3" width="3" height="3"/>
                                    <rect x="15" y="3" width="3" height="3"/><rect x="3" y="9" width="3" height="3"/>
                                    <rect x="9" y="9" width="3" height="3"/><rect x="18" y="9" width="3" height="3"/>
                                    <rect x="3" y="15" width="3" height="3"/><rect x="12" y="15" width="3" height="3"/>
                                    <rect x="18" y="15" width="3" height="3"/><rect x="6" y="6" width="3" height="3"/>
                                    <rect x="12" y="6" width="3" height="3"/><rect x="15" y="12" width="3" height="3"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Helper text --}}
                <p class="text-center text-xs text-gray-400 dark:text-gray-500 mt-4">
                    Cet aperçu est indicatif. Le rendu final peut varier légèrement sur iPhone.
                </p>
            </div>
        </div>
    </div>
</div>
