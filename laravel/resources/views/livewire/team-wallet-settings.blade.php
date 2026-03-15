<div class="max-w-5xl mx-auto" wire:key="wallet-settings-{{ $team->id }}">
    @php $settings = $this->settings; @endphp
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Apple Wallet') }}</h2>
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
            {{ __('Personnalisez la carte de fidélité Apple Wallet de vos clients.') }}
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- LEFT COLUMN: Settings Form --}}
        <div class="space-y-6">
            {{-- Design Section (Logos & Colors) --}}
            <form wire:submit="save"
                class="bg-white dark:bg-gray-800 shadow-xl border border-gray-100 dark:border-gray-700 sm:rounded-2xl overflow-hidden">
                <div class="p-6 sm:p-8 space-y-8">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                        </svg>
                        Logo & Couleurs
                    </h3>

                    {{-- Logo Text & Colors --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <x-label for="logo_text" value="Nom affiché (Logo)" />
                                <x-input id="logo_text" type="text" class="mt-1 block w-full"
                                    wire:model.live="state.logo_text" placeholder="{{ $team->name }}" />
                                <x-input-error for="state.logo_text" class="mt-2" />
                            </div>

                            <div class="grid grid-cols-3 gap-3">
                                <div>
                                    <x-label value="Fond" class="text-[10px] uppercase opacity-60 mb-1" />
                                    <div class="relative w-10 h-10 rounded-full shadow-inner border border-gray-200"
                                        style="background-color: {{ $state['background_color'] }};">
                                        <input type="color" wire:model.live="state.background_color"
                                            class="absolute inset-0 opacity-0 w-full h-full cursor-pointer">
                                    </div>
                                </div>
                                <div>
                                    <x-label value="Texte" class="text-[10px] uppercase opacity-60 mb-1" />
                                    <div class="relative w-10 h-10 rounded-full shadow-inner border border-gray-200"
                                        style="background-color: {{ $state['foreground_color'] }};">
                                        <input type="color" wire:model.live="state.foreground_color"
                                            class="absolute inset-0 opacity-0 w-full h-full cursor-pointer">
                                    </div>
                                </div>
                                <div>
                                    <x-label value="Labels" class="text-[10px] uppercase opacity-60 mb-1" />
                                    <div class="relative w-10 h-10 rounded-full shadow-inner border border-gray-200"
                                        style="background-color: {{ $state['label_color'] }};">
                                        <input type="color" wire:model.live="state.label_color"
                                            class="absolute inset-0 opacity-0 w-full h-full cursor-pointer">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Image Uploads --}}
                        <div class="space-y-3">
                            {{-- Icon --}}
                            <div
                                class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-900/50 rounded-xl border border-gray-100 dark:border-gray-700">
                                <div>
                                    <p class="text-xs font-bold text-gray-900 dark:text-white">Icône (PNG)</p>
                                    <p class="text-[10px] text-gray-500">87×87px</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    @if($settings?->icon_path) <span class="text-emerald-500 text-xs">✓</span> @endif
                                    <label for="icon-upload"
                                        class="cursor-pointer bg-gray-900 dark:bg-white text-white dark:text-gray-900 px-2 py-1 rounded text-[10px] font-bold">
                                        {{ $settings?->icon_path ? 'Changer' : 'Uploader' }}
                                    </label>
                                    <input id="icon-upload" type="file" wire:model="iconFile" accept=".png" class="hidden">
                                </div>
                            </div>
                            <x-input-error for="iconFile" class="text-[10px] mt-1" />
                            @if($iconFile) <button type="button" wire:click="uploadImage('icon')"
                                class="w-full py-1 text-[10px] font-bold bg-emerald-600 text-white rounded">Confirmer
                                Icône</button> @endif

                            {{-- Strip --}}
                            <div
                                class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-900/50 rounded-xl border border-gray-100 dark:border-gray-700">
                                <div>
                                    <p class="text-xs font-bold text-gray-900 dark:text-white">Bandeau (PNG)</p>
                                    <p class="text-[10px] text-gray-500">375×123px</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    @if($settings?->strip_path) <span class="text-emerald-500 text-xs">✓</span> @endif
                                    <label for="strip-upload"
                                        class="cursor-pointer bg-gray-900 dark:bg-white text-white dark:text-gray-900 px-2 py-1 rounded text-[10px] font-bold">
                                        {{ $settings?->strip_path ? 'Changer' : 'Uploader' }}
                                    </label>
                                    <input id="strip-upload" type="file" wire:model="stripFile" accept=".png" class="hidden">
                                </div>
                            </div>
                            <x-input-error for="stripFile" class="mt-1" />
                            @if($stripFile) <button type="button" wire:click="uploadImage('strip')"
                                class="w-full py-1 text-[10px] font-bold bg-emerald-600 text-white rounded">Confirmer
                                Bandeau</button> @endif
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-700">
                        <button type="button" wire:click="resetToDefaults"
                            class="text-xs text-gray-400 hover:text-gray-600 underline">Réinitialiser par
                            défaut</button>
                        <div class="flex items-center gap-4">
                            <x-action-message on="saved" class="text-xs text-emerald-600">Sauvegardé
                                !</x-action-message>
                            <x-button>Mettre à jour le design</x-button>
                        </div>
                    </div>
                </div>
            </form>

            {{-- Geofencing Settings --}}
            <form wire:submit="save"
                class="bg-white dark:bg-gray-800 shadow-xl border border-gray-100 dark:border-gray-700 sm:rounded-2xl overflow-hidden">
                <div class="p-6 sm:p-8 space-y-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Géofencing (Détection de proximité)
                        </h3>
                    </div>

                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                        Le pass s'affichera automatiquement sur l'écran verrouillé de vos clients lorsqu'ils seront à
                        proximité de votre établissement.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-label for="latitude" value="Latitude" />
                            <x-input id="latitude" type="text" class="mt-1 block w-full font-mono text-sm"
                                wire:model.live="state.latitude" placeholder="Ex: 48.8566" />
                            <x-input-error for="state.latitude" class="mt-1" />
                        </div>
                        <div>
                            <x-label for="longitude" value="Longitude" />
                            <x-input id="longitude" type="text" class="mt-1 block w-full font-mono text-sm"
                                wire:model.live="state.longitude" placeholder="Ex: 2.3522" />
                            <x-input-error for="state.longitude" class="mt-1" />
                        </div>
                    </div>

                    <div>
                        <x-label for="relevant_text" value="Message de proximité" />
                        <x-input id="relevant_text" type="text" class="mt-1 block w-full"
                            wire:model.live="state.relevant_text"
                            placeholder="Ex: Vous êtes proche de {{ $team->name }} !" />
                        <p class="mt-2 text-[10px] text-gray-400 italic">Ce message apparaît sous la carte sur l'écran
                            de verrouillage.</p>
                        <x-input-error for="state.relevant_text" class="mt-2" />
                    </div>

                    <div
                        class="p-4 bg-blue-50 dark:bg-blue-900/10 rounded-xl border border-blue-100 dark:border-blue-800/30 flex items-start gap-3">
                        <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="text-xs text-blue-800/80 dark:text-blue-400/80 space-y-2">
                            <p class="font-bold">Comment trouver vos coordonnées ?</p>
                            <p>Rendez-vous sur <a href="https://www.google.com/maps" target="_blank"
                                    class="underline font-bold text-blue-600 dark:text-blue-400">Google Maps</a>, faites
                                un clic droit sur votre établissement et copiez les coordonnées affichées.</p>
                        </div>
                    </div>
                </div>

                <div
                    class="flex items-center justify-end px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-100 dark:border-gray-700 gap-3">
                    <x-action-message class="me-3" on="saved">
                        {{ __('Sauvegardé !') }}
                    </x-action-message>
                    <x-button>
                        {{ __('Activer le Géofencing') }}
                    </x-button>
                </div>
            </form>

        </div>

        {{-- RIGHT COLUMN: Live Preview --}}
        <div class="lg:sticky lg:top-8 self-start">
            <h3 class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4 text-center">
                Aperçu en temps réel</h3>

            {{-- Pass Preview Card --}}
            <div class="mx-auto" style="max-width: 340px;">
                <div class="rounded-2xl overflow-hidden shadow-2xl"
                    style="background-color: {{ $state['background_color'] }};">
                    {{-- Header: Logo area --}}
                    <div class="px-5 pt-5 pb-3 flex items-center gap-3">
                        {{-- Icon preview --}}
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center text-lg font-bold overflow-hidden"
                            style="background-color: rgba(255,255,255,0.15); color: {{ $state['foreground_color'] }};">
                            @if($iconFile)
                            <img src="{{ $iconFile->temporaryUrl() }}" class="w-full h-full object-cover">
                            @elseif($settings?->icon_path)
                            <img src="{{ Storage::disk('cloud_public')->url($settings->icon_path) }}?v={{ $settings->updated_at?->timestamp ?? time() }}"
                                class="w-full h-full object-cover" alt="icon">
                            @else
                            {{ strtoupper(substr($state['logo_text'] ?: $team->name, 0, 1)) }}
                            @endif
                        </div>
                        <div class="flex-1">
                            <span class="text-base font-bold" style="color: {{ $state['foreground_color'] }};">
                                {{ $state['logo_text'] ?: $team->name }}
                            </span>
                        </div>

                        {{-- Secondary Field (Holder) moved to top-right Header area --}}
                        <div class="text-right">
                            <p class="text-[8px] uppercase tracking-wider font-bold opacity-60"
                                style="color: {{ $state['label_color'] ?? $state['foreground_color'] }};">
                                {{ $state['label_secondary'] }}
                            </p>
                            <p class="text-base font-bold" style="color: {{ $state['foreground_color'] }};">
                                John Doe
                            </p>
                        </div>
                    </div>

                    {{-- Strip / Banner area --}}
                    @if($stripFile)
                    <div class="w-full h-32 overflow-hidden bg-gray-100 dark:bg-gray-800">
                        <img src="{{ $stripFile->temporaryUrl() }}" class="w-full h-full object-cover" alt="preview">
                    </div>
                    @elseif($settings?->strip_path)
                    <div class="w-full h-32 overflow-hidden">
                        <img src="{{ Storage::disk('cloud_public')->url($settings->strip_path) }}?v={{ $settings->updated_at?->timestamp ?? time() }}"
                            class="w-full h-full object-cover" alt="strip">
                    </div>
                    @else
                    <div class="w-full h-32 bg-gray-100 dark:bg-gray-800/50"></div>
                    @endif

                    {{-- Points + Reward fields --}}
                    <div class="px-5 py-6 flex flex-col gap-2 border-t border-white/5">
                        {{-- Labels Row --}}
                        <div class="flex items-center justify-between">
                            <p class="text-[8px] uppercase tracking-wider font-bold opacity-50"
                                style="color: {{ $state['label_color'] ?? $state['foreground_color'] }};">
                                {{ $state['label_primary'] }}
                            </p>
                            <p class="text-[8px] uppercase tracking-wider font-bold opacity-50"
                                style="color: {{ $state['label_color'] ?? $state['foreground_color'] }};">
                                🎁 Récompense
                            </p>
                        </div>
                        {{-- Values Row --}}
                        <div class="flex items-center justify-between">
                            <p class="text-base font-bold" style="color: {{ $state['foreground_color'] }};">
                                150
                            </p>
                            <p class="text-base font-bold" style="color: {{ $state['foreground_color'] }};">
                                Café offert
                            </p>
                        </div>
                    </div>


                    {{-- Barcode Area --}}
                    <div class="px-5 pb-8 pt-2 flex justify-center">
                        <div class="w-28 h-28 bg-white rounded-xl flex items-center justify-center shadow-sm">
                            <svg class="w-20 h-20 text-black" viewBox="0 0 29 29" fill="currentColor"
                                shape-rendering="crispEdges">
                                <path
                                    d="M0 0h7v7H0zM22 0h7v7h-7zM0 22h7v7H0zM2 2h3v3H2zM24 2h3v3h-3zM2 24h3v3H2zM11 0h2v2h-2zM15 0h2v4h-2V0zm4 0h2v2h-2zM8 1h2v2H8zM12 2h2v2h-2zM18 2h2v4h-2zM8 4h2v2H8zM11 4h2v2h-2zm4 4h2v2h-2zM19 4h2v2h-2zM11 7h2v2h-2zM14 7h1v1h-1zM22 8h3v1h-3zm4 0h3v1h-3zM8 9h2v2H8zm3 0h2v2h-2zm4 0h4v2h-4zM24 9h2v2h-2zm3 0h2v2h-2zM0 8h2v1H0zm3 0h4v1H3zm0 2h3v1H3zm4 0h1v1H7zm11 11h2v2h-2zm4 0h2v2h-2zm3 0h2v4h-2zM8 12h2v2H8zm3 0h2v2h-2zm4 0h2v2h-2zm11 1h3v1h-3zM0 14h2v2H0zm3 1h3v1H3zm4 0h1v1H7zm11 1h2v2h-2zm4 0h2v2h-2zm3 1h2v2h-2zM8 16h2v2H8zm3 1h2v2h-2zm4 0h2v2h-2zm11 1h3v1h-3zM0 18h7v1H0zm3 1h3v1H3zM0 20h2v1H0zm3 0h4v1H3zm8 11h2v2h-2zm4 0h2v2h-2zm4 0h2v2h-2zm3 0h2v2h-2zM8 22h2v2H8zm4 0h2v4h-2zm6 0h2v2h-2zm4 0h2v2h-2zm3 0h2v2h-2zM8 24h2v2H8zm11 0h2v2h-2zm3 1h3v1h-3zM0 26h2v1H0zm3 0h4v1H3zm8 0h2v2h-2zm4 0h2v2h-2zm4 1h5v1h-5z" />
                            </svg>
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