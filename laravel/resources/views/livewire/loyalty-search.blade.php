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
            <div class="bg-white dark:bg-emerald-dark-500 rounded-2xl shadow-lg border border-gray-100 dark:border-emerald-dark-400 overflow-hidden animate-[fade-in_0.3s_ease-out]">
                <div class="bg-gradient-to-r from-emerald-500 to-teal-500 px-6 py-8 text-white text-center relative">
                    <button wire:click="clearSelection" class="absolute top-4 right-4 text-white/70 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <h2 class="text-2xl font-bold">{{ $selectedContact->name ?? 'Sans nom' }}</h2>
                    <p class="text-emerald-100 text-sm mt-1">Client depuis le {{ $selectedContact->created_at->format('d/m/Y') }}</p>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                        @if($selectedContact->email)
                            <div class="flex items-center gap-3 p-4 bg-gray-50 dark:bg-emerald-dark-600 rounded-xl">
                                <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Email</p>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $selectedContact->email }}</p>
                                </div>
                            </div>
                        @endif
                        @if($selectedContact->phone)
                            <div class="flex items-center gap-3 p-4 bg-gray-50 dark:bg-emerald-dark-600 rounded-xl">
                                <div class="w-10 h-10 rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Téléphone</p>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $selectedContact->phone }}</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Status badges --}}
                    <div class="flex flex-wrap gap-3">
                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium {{ $selectedContact->opt_in_loyalty ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400' }}">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                @if($selectedContact->opt_in_loyalty)
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                @else
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                @endif
                            </svg>
                            Programme fidélité
                        </span>
                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium {{ $selectedContact->opt_in_marketing ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : 'bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400' }}">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                @if($selectedContact->opt_in_marketing)
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                @else
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                @endif
                            </svg>
                            Communications marketing
                        </span>
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
