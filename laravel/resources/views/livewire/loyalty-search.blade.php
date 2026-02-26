<div>
    <div class="max-w-4xl mx-auto">
        {{-- Page Header --}}
        <div class="mb-8">
            <a href="{{ route('loyalty.index') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 dark:text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors mb-4">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                Retour à Fidélité
            </a>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Retrouver un client</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Recherchez par nom, email, téléphone ou scannez un code</p>
        </div>

        {{-- Search Bar --}}
        <div class="bg-white dark:bg-emerald-dark-500 rounded-2xl shadow-lg border border-gray-100 dark:border-emerald-dark-400 p-6 mb-6">
            <div x-data="{ scanning: false }" class="space-y-3">
                <div class="flex gap-2">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input
                            wire:model.live.debounce.300ms="search"
                            type="text"
                            placeholder="Nom, email, téléphone ou code..."
                            autofocus
                            class="w-full pl-12 pr-10 py-4 text-base border border-gray-200 dark:border-emerald-dark-400 rounded-xl bg-gray-50 dark:bg-emerald-dark-600 text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
                            id="loyalty-search-input"
                        >
                        @if($search)
                            <button wire:click="clearSelection" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        @endif
                    </div>
                    {{-- Camera Scan Button --}}
                    <button
                        @click="scanning = !scanning; if (scanning) { $nextTick(() => startScanner()) } else { stopScanner() }"
                        class="flex items-center justify-center px-5 py-4 rounded-xl border border-gray-200 dark:border-emerald-dark-400 bg-gray-50 dark:bg-emerald-dark-600 text-gray-500 dark:text-gray-400 hover:bg-emerald-50 hover:text-emerald-600 hover:border-emerald-300 dark:hover:bg-emerald-900/30 dark:hover:text-emerald-400 transition-all flex-shrink-0"
                        :class="scanning ? 'bg-emerald-50 text-emerald-600 border-emerald-300 dark:bg-emerald-900/30 dark:text-emerald-400' : ''"
                        title="Scanner un code-barres ou QR code">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                        </svg>
                    </button>
                </div>

                {{-- Scanner Area --}}
                <div x-show="scanning" x-transition class="relative rounded-xl overflow-hidden border-2 border-emerald-400 dark:border-emerald-600">
                    <div id="qr-reader" class="w-full"></div>
                    <p class="text-center text-xs text-gray-500 dark:text-gray-400 py-2 bg-gray-50 dark:bg-emerald-dark-600">
                        📷 Placez le code-barres ou QR code devant la caméra
                    </p>
                </div>
            </div>
        </div>

        {{-- Selected Contact Detail (Full card) --}}
        @if($selectedContact)
            <div class="bg-white dark:bg-emerald-dark-500 rounded-2xl shadow-lg border border-gray-100 dark:border-emerald-dark-400 p-6 animate-[fade-in_0.3s_ease-out]">
                {{-- Header Section --}}
                <div class="flex items-start justify-between mb-6 pb-6 border-b border-gray-100 dark:border-emerald-dark-400">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white text-2xl font-bold shadow-inner">
                            {{ strtoupper(substr($selectedContact->name ?? '?', 0, 1)) }}
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $selectedContact->name ?? 'Client Sans Nom' }}</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-2 mt-1">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                Client depuis le {{ $selectedContact->created_at->format('d/m/Y') }}
                            </p>
                        </div>
                    </div>
                    <button wire:click="clearSelection" class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-emerald-dark-600 rounded-full transition-colors" title="Fermer">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    {{-- Contact Info Column --}}
                    <div class="md:col-span-2 space-y-4">
                        @if($selectedContact->email)
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-gray-50 dark:bg-emerald-dark-600 border border-gray-100 dark:border-emerald-dark-400 flex items-center justify-center flex-shrink-0 text-gray-500 dark:text-gray-400">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $selectedContact->email }}</p>
                                </div>
                            </div>
                        @endif
                        
                        @if($selectedContact->phone)
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-gray-50 dark:bg-emerald-dark-600 border border-gray-100 dark:border-emerald-dark-400 flex items-center justify-center flex-shrink-0 text-gray-500 dark:text-gray-400">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $selectedContact->phone }}</p>
                                </div>
                            </div>
                        @endif
                        
                        @if($selectedContact->last_scanned_at)
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-gray-50 dark:bg-emerald-dark-600 border border-gray-100 dark:border-emerald-dark-400 flex items-center justify-center flex-shrink-0 text-gray-500 dark:text-gray-400">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">Dernière visite le {{ $selectedContact->last_scanned_at->format('d/m/Y') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Loyalty Stats Column --}}
                    <div class="md:col-span-1">
                        <div class="bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900/20 dark:to-orange-900/10 border border-orange-200 dark:border-orange-800/50 rounded-xl p-4 h-full flex flex-col justify-center relative overflow-hidden">
                            <div class="absolute -right-4 -bottom-4 opacity-10">
                                <svg class="w-24 h-24 text-orange-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            </div>
                            <p class="text-xs text-orange-600/80 dark:text-orange-400/80 font-bold uppercase tracking-wider mb-1">Solde actuel</p>
                            <div class="flex items-baseline gap-1">
                                <span class="text-3xl font-extrabold text-orange-600 dark:text-orange-400">{{ $selectedContact->loyalty_points }}</span>
                                <span class="text-sm font-medium text-orange-700 dark:text-orange-300">{{ $teamLoyaltyProgram === 'visits' ? 'visites' : 'points' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                    {{-- Loyalty specific actions based on selected program --}}
                    @if($teamLoyaltyProgram)
                        <div class="mb-6 p-5 sm:p-6 rounded-2xl border border-gray-100 dark:border-gray-700 bg-white dark:bg-emerald-dark-600 shadow-sm relative overflow-hidden">
                            
                            <!-- Action success messages -->
                            <div x-data="{ showVisitMsg: false, showPointsMsg: false, showConsumedMsg: false, showUndoMsg: false }"
                                 x-on:visit-recorded.window="showVisitMsg = true; setTimeout(() => showVisitMsg = false, 3000)"
                                 x-on:points-added.window="showPointsMsg = true; setTimeout(() => showPointsMsg = false, 3000)"
                                 x-on:reward-consumed.window="showConsumedMsg = true; setTimeout(() => showConsumedMsg = false, 3000)"
                                 x-on:action-undone.window="showUndoMsg = true; setTimeout(() => showUndoMsg = false, 3000)">
                                
                                <div x-show="showVisitMsg" style="display: none;" class="mb-4 p-3 bg-emerald-100 text-emerald-800 rounded-xl text-sm text-center font-medium">
                                    Visite enregistrée avec succès !
                                </div>
                                <div x-show="showPointsMsg" style="display: none;" class="mb-4 p-3 bg-emerald-100 text-emerald-800 rounded-xl text-sm text-center font-medium">
                                    Points ajoutés avec succès !
                                </div>
                                <div x-show="showConsumedMsg" style="display: none;" class="mb-4 p-3 bg-orange-100 text-orange-800 rounded-xl text-sm text-center font-medium">
                                    Récompense consommée avec succès !
                                </div>
                                <div x-show="showUndoMsg" style="display: none;" class="mb-4 p-3 bg-gray-100 text-gray-800 rounded-xl text-sm text-center font-medium">
                                    Action annulée.
                                </div>
                            </div>

                            <!-- Undo Action Bar -->
                            @if($lastAction)
                                <div class="mb-6 p-3 bg-gray-50 border border-gray-200 dark:bg-gray-800 dark:border-gray-700 rounded-xl flex items-center justify-between animate-[fade-in_0.3s_ease-out]">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                        {{ $lastAction['type'] === 'consume' ? 'Récompense consommée.' : 'Ajout effectué.' }}
                                    </span>
                                    <button wire:click="undoLastAction" class="text-sm font-bold text-red-600 hover:text-red-700 dark:text-red-400 bg-red-50 hover:bg-red-100 dark:bg-red-900/30 dark:hover:bg-red-900/50 px-3 py-1 rounded-lg transition-colors">
                                        Annuler l'action
                                    </button>
                                </div>
                            @endif

                            @if($teamLoyaltyProgram === 'visits')
                                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                                    <div>
                                        <h3 class="font-bold text-gray-900 dark:text-white">Nouvelle visite</h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Ajouter 1 point de visite à ce client</p>
                                    </div>
                                    <div class="w-full sm:w-auto mt-2 sm:mt-0">
                                        <button wire:click="recordVisit" class="w-full sm:w-auto px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl shadow-sm font-medium transition-colors disabled:opacity-50" wire:loading.attr="disabled" wire:target="recordVisit">
                                            Enregistrer une visite
                                        </button>
                                    </div>
                                </div>
                            @elseif($teamLoyaltyProgram === 'points')
                                <div class="flex flex-col sm:flex-row gap-3">
                                    <div class="flex-1">
                                        <x-label for="add_points" value="Points à ajouter (selon le montant de l'achat)" class="sr-only" />
                                        <x-input id="add_points" type="number" min="1" wire:model="pointsToAdd" placeholder="Montant/Points..." class="w-full py-2.5 rounded-xl border-gray-200" />
                                    </div>
                                    <button wire:click="addPoints" class="w-full sm:w-auto px-6 py-2.5 bg-purple-600 hover:bg-purple-700 text-white rounded-xl shadow-sm font-medium transition-colors whitespace-nowrap disabled:opacity-50" wire:loading.attr="disabled" wire:target="addPoints">
                                        Ajouter des points
                                    </button>
                                </div>
                                <x-input-error for="pointsToAdd" class="mt-2" />
                            @endif

                            {{-- Progress / Available Rewards section --}}
                            @if(count($rewards) > 0)
                                <div class="mt-6 pt-4 border-t border-gray-100 dark:border-gray-700">
                                    <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Récompenses disponibles</h4>
                                    <div class="space-y-2">
                                        @foreach($rewards as $reward)
                                            @php
                                                $canClaim = $selectedContact->loyalty_points >= $reward->points_required;
                                            @endphp
                                            <div class="flex items-center justify-between p-2 rounded {{ $canClaim ? 'bg-orange-50 dark:bg-orange-900/20 border border-orange-200 dark:border-orange-800' : 'opacity-50 grayscale' }}">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 rounded-full {{ $canClaim ? 'bg-orange-200 text-orange-700 outline outline-2 outline-offset-1 outline-orange-300' : 'bg-gray-200 text-gray-500' }} flex items-center justify-center text-xl shadow-sm">
                                                        {{ ['gift'=>'🎁','star'=>'⭐','coffee'=>'☕','ticket'=>'🎫','percent'=>'🏷️','cake'=>'🎂','burger'=>'🍔','pizza'=>'🍕','drink'=>'🥤','icecream'=>'🍦','scissors'=>'✂️','massage'=>'💆','car'=>'🚗','bag'=>'👜','money'=>'💸'][$reward->icon ?? 'gift'] ?? '🎁' }}
                                                    </div>
                                                    <div>
                                                        <span class="text-sm font-bold {{ $canClaim ? 'text-orange-900 dark:text-orange-300' : 'text-gray-500' }} block">{{ $reward->name }}</span>
                                                        <span class="text-xs {{ $canClaim ? 'text-orange-700 dark:text-orange-400' : 'text-gray-400' }} font-medium">{{ $reward->points_required }} pt(s)</span>
                                                    </div>
                                                </div>
                                                @if($canClaim)
                                                    <button wire:click="consumeReward({{ $reward->id }})" class="text-xs bg-orange-500 hover:bg-orange-600 text-white px-3 py-1.5 rounded-full uppercase tracking-wide font-bold transition-colors shadow-sm disabled:opacity-50" wire:loading.attr="disabled">
                                                        Consommer
                                                    </button>
                                                @else
                                                    <span class="text-xs font-semibold text-gray-500 bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded">Encore {{ $reward->points_required - $selectedContact->loyalty_points }}</span>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- Status badges --}}
                    <div class="flex flex-wrap gap-2 mb-6">
                        @if($selectedContact->opt_in_loyalty)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md text-xs font-semibold bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-800/50">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                Membre Fidélité
                            </span>
                        @endif
                        @if($selectedContact->opt_in_marketing)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md text-xs font-semibold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-100 dark:border-blue-800/50">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" /><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" /></svg>
                                Emails Marketing
                            </span>
                        @endif
                    </div>
                    
                    {{-- Magic Link Action --}}
                    <div class="pt-6 border-t border-gray-100 dark:border-emerald-dark-400">
                        <div x-data="{ copied: false, loading: false }" 
                             x-on:magic-link-generated.window="if ($event.detail.url) { 
                                 navigator.clipboard.writeText($event.detail.url).then(() => { 
                                     loading = false;
                                     copied = true; 
                                     setTimeout(() => copied = false, 2000); 
                                 });
                             }"
                             class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                            <p class="text-xs text-gray-500 dark:text-gray-400">Partagez ce lien sécurisé pour que le client mette à jour ses infos.</p>
                            <button 
                                wire:click="copyMagicLink"
                                @click="loading = true"
                                class="w-full sm:w-auto inline-flex justify-center items-center gap-1.5 px-4 py-2 bg-gray-50 hover:bg-gray-100 dark:bg-emerald-dark-600 dark:hover:bg-emerald-dark-400 text-gray-700 dark:text-gray-200 text-xs font-semibold rounded-xl transition-colors border border-gray-200 dark:border-emerald-dark-400 disabled:opacity-50 disabled:cursor-not-allowed"
                                x-bind:disabled="loading"
                            >
                                <svg class="w-3.5 h-3.5 animate-spin" x-show="loading" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <svg class="w-3.5 h-3.5" x-show="!copied && !loading" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                                <svg class="w-3.5 h-3.5 text-emerald-600" x-show="copied && !loading" style="display: none;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                <span x-text="loading ? 'Génération...' : (copied ? 'Lien copié !' : 'Copier le lien')">Copier le lien</span>
                            </button>
                        </div>
                    </div>
            </div>

        {{-- Search Results --}}
        @elseif(strlen($search) >= 2)
            @if($this->contacts->count() === 0)
                {{-- No results --}}
                <div class="bg-white dark:bg-emerald-dark-500 rounded-2xl shadow-lg border border-gray-100 dark:border-emerald-dark-400 p-12 text-center">
                    <div class="w-20 h-20 rounded-full bg-gray-100 dark:bg-emerald-dark-600 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-gray-300 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Aucun client trouvé</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Aucun résultat pour "<strong>{{ $search }}</strong>"</p>
                </div>

            @elseif($this->contacts->count() > 0)
                <div class="mb-3 flex items-center justify-between">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        <strong class="text-gray-900 dark:text-white">{{ $this->contacts->count() }}</strong> résultat{{ $this->contacts->count() > 1 ? 's' : '' }} trouvé{{ $this->contacts->count() > 1 ? 's' : '' }}
                    </p>
                </div>
                <div class="space-y-3">
                    @foreach($this->contacts as $contact)
                        <button
                            wire:click="selectContact('{{ $contact->id }}')"
                            class="w-full text-left bg-white dark:bg-emerald-dark-500 rounded-xl shadow-sm border border-gray-100 dark:border-emerald-dark-400 p-4 hover:shadow-md hover:border-emerald-200 dark:hover:border-emerald-600 transition-all group"
                        >
                            <div class="flex items-center gap-4">
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ $contact->name ?? 'Sans nom' }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                        {{ collect([$contact->email, $contact->phone])->filter()->implode(' · ') }}
                                    </p>
                                </div>
                                <div class="hidden sm:flex items-center gap-2 flex-shrink-0">
                                    @if($contact->opt_in_loyalty)
                                        <span class="w-2 h-2 rounded-full bg-emerald-500" title="Fidélité active"></span>
                                    @endif
                                    @if($contact->opt_in_marketing)
                                        <span class="w-2 h-2 rounded-full bg-blue-500" title="Marketing actif"></span>
                                    @endif
                                </div>
                                <svg class="w-5 h-5 text-gray-300 group-hover:text-emerald-500 transition-colors flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </button>
                    @endforeach
                </div>
            @endif

        @else
            {{-- Empty state --}}
            <div class="bg-white dark:bg-emerald-dark-500 rounded-2xl shadow-lg border border-gray-100 dark:border-emerald-dark-400 p-12 text-center">
                <div class="w-20 h-20 rounded-full bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Rechercher un client</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Saisissez au moins 2 caractères ou scannez un code</p>
                <div class="flex items-center justify-center gap-4 mt-6 text-xs text-gray-400 dark:text-gray-500">
                    <span class="flex items-center gap-1">🔤 Nom</span>
                    <span class="flex items-center gap-1">📧 Email</span>
                    <span class="flex items-center gap-1">📱 Téléphone</span>
                    <span class="flex items-center gap-1">📷 Code-barres</span>
                </div>
            </div>
        @endif
    </div>

    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    <script>
        let html5Qrcode = null;
        
        function startScanner() {
            if (html5Qrcode) return;
            
            html5Qrcode = new Html5Qrcode("qr-reader");
            
            html5Qrcode.start(
                { facingMode: "environment" },
                {
                    fps: 30, // 30 images/sec au lieu de 10 pour une grande réactivité
                    qrbox: { width: 250, height: 150 },
                    // On limite aux formats les plus communs pour accélérer la détection
                    formatsToSupport: [
                        Html5QrcodeSupportedFormats.QR_CODE,
                        Html5QrcodeSupportedFormats.CODE_128
                    ]
                },
                (decodedText) => {
                    // Nettoyer les espaces parasites éventuels du code scanné
                    const cleanText = decodedText.trim();
                    
                    // Succès du scan : on met à jour le backend
                    @this.set('search', cleanText);
                    stopScanner();
                    
                    // Fermer le conteneur alpine
                    const el = document.querySelector('[x-data]');
                    if (el && el.__x) el.__x.$data.scanning = false;
                },
                (errorMessage) => {
                    // Erreur en continu pendant le scan (ignorée)
                }
            ).catch((err) => {
                console.warn("Erreur scanner :", err);
                alert("Impossible d'accéder à la caméra. Vérifiez les permissions du navigateur.");
                
                stopScanner();
                const el = document.querySelector('[x-data]');
                if (el && el.__x) el.__x.$data.scanning = false;
            });
        }
        
        function stopScanner() {
            if (html5Qrcode) {
                html5Qrcode.stop().then(() => {
                    html5Qrcode.clear();
                    html5Qrcode = null;
                }).catch(err => {
                    console.error("Failed to stop scanner", err);
                    html5Qrcode = null;
                });
            }
        }
    </script>
</div>
