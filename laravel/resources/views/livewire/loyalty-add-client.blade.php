<div class="animate-[fade-in-up_0.6s_ease-out]">
    <div class="max-w-2xl mx-auto px-4 sm:px-6">
        {{-- Navigation Back --}}
        <div class="mb-6 pt-4">
            <a href="{{ route('loyalty.index') }}" wire:navigate class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-emerald-600 dark:text-gray-400 dark:hover:text-emerald-400 bg-white dark:bg-gray-800 px-4 py-2 rounded-full shadow-sm border border-gray-100 dark:border-gray-700 transition hover:shadow-md group">
                <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Retour à Fidélité
            </a>
        </div>

        {{-- Form Card --}}
        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg py-8 px-6 shadow-2xl sm:rounded-3xl sm:px-10 border border-white/50 dark:border-gray-700/50 relative overflow-hidden">
            {{-- Subtle glow --}}
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-blue-100 dark:bg-blue-900/30 rounded-full blur-3xl opacity-50 z-0"></div>
            <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-emerald-100 dark:bg-emerald-900/30 rounded-full blur-3xl opacity-40 z-0"></div>

            <div class="relative z-10">

                @if($addClientSuccess)
                    <div class="text-center py-8 relative overflow-hidden animate-[fade-in_0.5s_ease-out]">
                        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-48 h-48 bg-emerald-400/20 rounded-full blur-3xl animate-pulse"></div>
                        <div class="relative z-10">
                            <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full mb-6 shadow-inner ring-4 bg-emerald-100 dark:bg-emerald-900/50 ring-emerald-50 dark:ring-emerald-900/20 transform hover:scale-110 transition-transform duration-300">
                                <svg class="h-10 w-10 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl leading-8 font-extrabold text-gray-900 dark:text-white tracking-tight">Client ajouté !</h3>
                            <p class="mt-3 text-base text-gray-600 dark:text-gray-300">
                                <strong>{{ $addClientSuccess }}</strong> a été inscrit(e) au programme de fidélité.
                                <br><span class="text-emerald-600 dark:text-emerald-400 font-medium">Le client peut dès maintenant cumuler ses avantages !</span>
                            </p>
                            <div class="mt-8 flex gap-3 max-w-sm mx-auto">
                                <button wire:click="resetForm" class="flex-1 relative flex items-center justify-center py-3 px-6 border border-transparent text-sm font-bold rounded-xl text-white bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 group overflow-hidden">
                                    <div class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/20 to-transparent group-hover:animate-[shimmer_1.5s_infinite]"></div>
                                    <span class="relative z-10">Ajouter un autre</span>
                                </button>
                                <a href="{{ route('loyalty.search') }}" wire:navigate class="flex-1 flex items-center justify-center py-3 px-6 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-xl font-medium text-sm transition-colors">
                                    Rechercher
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    {{-- Header --}}
                    <div class="text-center mb-8 border-b border-gray-100 dark:border-gray-700/50 pb-6 relative">
                        <h3 class="text-2xl leading-none font-bold text-gray-900 dark:text-white">Nouveau client</h3>
                        <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">
                            Inscrivez un client et associez-lui une carte de fidélité vierge.
                        </p>
                    </div>

                    @if($addClientError)
                        <div class="mb-6 p-4 bg-red-50 text-red-700 text-sm rounded-xl dark:bg-red-900/30 dark:text-red-400 border border-red-200 dark:border-red-800 shadow-sm flex items-start animate-[shake_0.5s_ease-in-out]">
                            <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>{{ $addClientError }}</span>
                        </div>
                    @endif

                    <div class="space-y-6 text-left" x-data="{ scanning: false }">

                        {{-- Card Scanner Section --}}
                        <div class="bg-blue-50/60 dark:bg-blue-900/20 rounded-2xl p-5 border border-blue-200/70 dark:border-blue-800/50 relative overflow-hidden">
                            <div class="absolute -top-6 -right-6 w-20 h-20 bg-blue-200 dark:bg-blue-700/30 rounded-full blur-2xl opacity-30"></div>
                            <div class="relative z-10">
                                <div class="flex items-center justify-between mb-3">
                                    <h4 class="text-sm font-bold text-blue-800 dark:text-blue-300 flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                                        Carte de fidélité
                                    </h4>
                                    <button type="button" @click="scanning = !scanning; if (scanning) { $nextTick(() => startCardScanner()) } else { stopCardScanner() }"
                                        class="text-xs font-bold px-4 py-2 rounded-xl transition-all shadow-sm"
                                        :class="scanning ? 'bg-red-100 text-red-700 hover:bg-red-200 dark:bg-red-900/30 dark:text-red-400' : 'bg-blue-600 text-white hover:bg-blue-700 shadow-blue-200'">
                                        <span x-text="scanning ? '⏹ Arrêter' : '📷 Scanner'"></span>
                                    </button>
                                </div>

                                {{-- Scanner area --}}
                                <div x-show="scanning" x-transition class="mb-3 rounded-xl overflow-hidden border-2 border-blue-300 dark:border-blue-600 shadow-inner">
                                    <div id="card-qr-reader" class="w-full"></div>
                                    <p class="text-center text-xs text-blue-500 py-2 bg-blue-50 dark:bg-blue-900/30">Scannez le code-barres ou QR code de la carte vierge</p>
                                </div>

                                <div class="group">
                                    <x-input id="pass_token" type="text" class="mt-1 block w-full py-3 px-4 rounded-xl border-blue-200 dark:border-blue-700 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500/20 transition-all bg-white dark:bg-gray-900/50" wire:model="newClient.pass_token" placeholder="Code carte (scan ou saisie manuelle)" />
                                </div>
                                <x-input-error for="newClient.pass_token" class="mt-2" />
                                @if($newClient['pass_token'])
                                    <p class="mt-2 text-xs text-blue-600 dark:text-blue-400 font-semibold flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                        Carte associée : {{ $newClient['pass_token'] }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        {{-- Name --}}
                        <div class="group">
                            <x-label for="name" value="Nom complet *" class="text-gray-700 dark:text-gray-300 font-semibold mb-1 group-focus-within:text-blue-600 transition-colors" />
                            <x-input id="name" type="text" class="mt-1 block w-full py-3 px-4 rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500/20 transition-all bg-white dark:bg-gray-900/50" wire:model="newClient.name" placeholder="Ex: Jean Dupont" />
                            <x-input-error for="newClient.name" class="mt-2" />
                        </div>

                        {{-- Phone + Email --}}
                        <div class="space-y-6">
                            <div class="group">
                                <x-label for="phone" value="Numéro de téléphone" class="text-gray-700 dark:text-gray-300 font-semibold mb-1 group-focus-within:text-blue-600 transition-colors" />
                                <x-phone-input id="phone" wireModel="newClient.phone" :initialValue="$newClient['phone']" placeholder="06 12 34 56 78" />
                                <x-input-error for="newClient.phone" class="mt-2" />
                            </div>

                            <div class="group">
                                <x-label for="email" value="Adresse Email" class="text-gray-700 dark:text-gray-300 font-semibold mb-1 group-focus-within:text-blue-600 transition-colors" />
                                <x-input id="email" type="email" class="mt-1 block w-full py-3 px-4 rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500/20 transition-all bg-white dark:bg-gray-900/50" wire:model="newClient.email" placeholder="client@email.com" />
                                <x-input-error for="newClient.email" class="mt-2" />
                            </div>
                        </div>

                        {{-- Date of birth --}}
                        <div class="group">
                            <x-label for="date_of_birth" value="Date de naissance" class="text-gray-700 dark:text-gray-300 font-semibold mb-1 group-focus-within:text-blue-600 transition-colors" />
                            <x-input id="date_of_birth" type="date" class="mt-1 block w-full py-3 px-4 rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500/20 transition-all bg-white dark:bg-gray-900/50" wire:model="newClient.date_of_birth" max="{{ now()->format('Y-m-d') }}" />
                            <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">Facultatif — pour recevoir des offres d'anniversaire</p>
                            <x-input-error for="newClient.date_of_birth" class="mt-2" />
                        </div>

                        <div class="bg-blue-50/50 dark:bg-blue-900/10 rounded-xl p-3 border border-blue-100 dark:border-blue-800/30">
                            <p class="flex items-center text-xs text-blue-800 dark:text-blue-300">
                                <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Afin de retrouver le client en caisse, un numéro ou email est requis.
                            </p>
                        </div>

                        {{-- Opt-ins --}}
                        <div class="mt-6 pt-5 border-t border-gray-100 dark:border-gray-700/50 space-y-4">
                            <label for="opt_in_loyalty" class="flex items-start cursor-pointer group">
                                <div class="flex items-center h-4 mt-0.5">
                                    <x-checkbox id="opt_in_loyalty" wire:model="newClient.opt_in_loyalty" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 h-4 w-4" />
                                </div>
                                <div class="ml-2 text-xs">
                                    <span class="font-medium text-gray-700 dark:text-gray-300 group-hover:text-blue-700 dark:group-hover:text-blue-400 transition-colors">Programme de fidélité</span>
                                    <p class="mt-0.5 text-gray-500 dark:text-gray-400">Pour comptabiliser les points de fidélité.</p>
                                </div>
                            </label>

                            <label for="opt_in_marketing" class="flex items-start cursor-pointer group">
                                <div class="flex items-center h-4 mt-0.5">
                                    <x-checkbox id="opt_in_marketing" wire:model="newClient.opt_in_marketing" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 h-4 w-4" />
                                </div>
                                <div class="ml-2 text-xs">
                                    <span class="font-medium text-gray-700 dark:text-gray-300 group-hover:text-blue-700 dark:group-hover:text-blue-400 transition-colors">Offres et promotions</span>
                                </div>
                            </label>
                        </div>

                        {{-- Submit --}}
                        <div class="pt-6">
                            <button wire:click="addClient" class="w-full relative flex items-center justify-center py-4 px-8 border border-transparent text-lg font-extrabold rounded-xl text-white bg-gradient-to-r from-blue-600 to-indigo-500 hover:from-blue-500 hover:to-indigo-400 shadow-[0_10px_20px_-10px_rgba(59,130,246,0.5)] hover:shadow-[0_15px_30px_-10px_rgba(59,130,246,0.6)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all transform hover:-translate-y-1 overflow-hidden group disabled:opacity-75 disabled:cursor-not-allowed" wire:loading.attr="disabled" wire:target="addClient">
                                <div class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/20 to-transparent group-hover:animate-[shimmer_1.5s_infinite]"></div>
                                <span wire:loading.remove wire:target="addClient" class="relative z-10 flex items-center">
                                    Inscrire le client
                                    <svg class="w-5 h-5 ml-2 -mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                                </span>
                                <span wire:loading wire:target="addClient" class="relative z-10 flex items-center">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Inscription en cours...
                                </span>
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    <script>
        let cardScanner = null;

        function startCardScanner() {
            if (cardScanner) return;
            cardScanner = new Html5Qrcode("card-qr-reader");
            cardScanner.start(
                { facingMode: "environment" },
                {
                    fps: 30,
                    qrbox: { width: 250, height: 150 },
                    formatsToSupport: [
                        Html5QrcodeSupportedFormats.QR_CODE,
                        Html5QrcodeSupportedFormats.CODE_128
                    ]
                },
                (decodedText) => {
                    const cleanText = decodedText.trim();
                    @this.call('setPassToken', cleanText);
                    stopCardScanner();
                },
                (errorMessage) => {}
            ).catch((err) => {
                console.warn("Erreur scanner carte :", err);
                alert("Impossible d'accéder à la caméra. Vérifiez les permissions.");
                stopCardScanner();
            });
        }

        function stopCardScanner() {
            if (cardScanner) {
                cardScanner.stop().then(() => {
                    cardScanner.clear();
                    cardScanner = null;
                }).catch(err => {
                    console.error("Failed to stop card scanner", err);
                    cardScanner = null;
                });
            }
        }
    </script>

    <style>
        @keyframes fade-in-up {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        @keyframes fade-in {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
        @keyframes shimmer {
            100% { transform: translateX(100%); }
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            50% { transform: translateX(5px); }
            75% { transform: translateX(-5px); }
        }
    </style>
</div>
