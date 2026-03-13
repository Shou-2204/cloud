<div class="animate-[fade-in-up_0.6s_ease-out]">
    @if ($successMessage === 'expired')
        <div class="text-center py-8 px-4 sm:px-6 relative overflow-hidden animate-[fade-in_0.5s_ease-out]">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-48 h-48 bg-gray-400/20 rounded-full blur-3xl animate-pulse"></div>
            <div class="relative z-10">
                <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full mb-6 shadow-inner ring-4 bg-gray-100 dark:bg-gray-800 ring-gray-50 dark:ring-gray-700">
                    <svg class="h-10 w-10 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h3 class="text-2xl leading-8 font-extrabold text-gray-900 dark:text-white tracking-tight">Lien expiré</h3>
                <p class="mt-3 text-base text-gray-600 dark:text-gray-300">
                    Ce lien de mise à jour a déjà été utilisé.
                    <br><span class="text-gray-500 dark:text-gray-400 font-medium">Demandez un nouveau lien à votre commerçant si nécessaire.</span>
                </p>
                <div class="mt-8">
                    <a href="{{ route('profile.public', $team->public_uuid) }}" class="inline-flex justify-center items-center w-full rounded-xl px-5 py-3.5 text-base font-bold text-white shadow-lg transition-all transform hover:-translate-y-1 bg-gradient-to-r from-gray-600 to-gray-500 hover:from-gray-500 hover:to-gray-400 hover:shadow-xl focus:ring-gray-500">
                        Retour au profil
                    </a>
                </div>
            </div>
        </div>
    @elseif ($successMessage)
        <div class="text-center py-8 px-4 sm:px-6 relative overflow-hidden animate-[fade-in_0.5s_ease-out]">
            {{-- Glow background --}}
            @if ($successMessage === 'new')
                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-48 h-48 bg-emerald-400/20 rounded-full blur-3xl animate-pulse"></div>
                <div class="absolute -top-10 -right-10 w-24 h-24 bg-teal-400/20 rounded-full blur-2xl"></div>
            @else
                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-48 h-48 bg-blue-400/20 rounded-full blur-3xl animate-pulse"></div>
                <div class="absolute -top-10 -right-10 w-24 h-24 bg-indigo-400/20 rounded-full blur-2xl"></div>
            @endif

            <div class="relative z-10">
                {{-- Icon --}}
                <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full mb-6 shadow-inner ring-4 transform hover:scale-110 transition-transform duration-300
                    {{ $successMessage === 'new'
                        ? 'bg-emerald-100 dark:bg-emerald-900/50 ring-emerald-50 dark:ring-emerald-900/20'
                        : 'bg-blue-100 dark:bg-blue-900/50 ring-blue-50 dark:ring-blue-900/20' }}">
                    @if ($successMessage === 'new')
                        <svg class="h-10 w-10 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    @else
                        {{-- Star icon for returning member --}}
                        <svg class="h-10 w-10 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    @endif
                </div>

                @if ($successMessage === 'new')
                    <h3 class="text-2xl leading-8 font-extrabold text-gray-900 dark:text-white tracking-tight">Félicitations !</h3>
                    <p class="mt-3 text-base text-gray-600 dark:text-gray-300">
                        Votre carte de fidélité <strong>{{ $team->name }}</strong> est prête.
                        <br><span class="text-emerald-600 dark:text-emerald-400 font-medium">Commencez dès maintenant à cumuler vos avantages !</span>
                    </p>
                @elseif ($successMessage === 'updated')
                    <h3 class="text-2xl leading-8 font-extrabold text-gray-900 dark:text-white tracking-tight">Informations mises à jour ✅</h3>
                    <p class="mt-3 text-base text-gray-600 dark:text-gray-300">
                        Vos coordonnées chez <strong>{{ $team->name }}</strong> ont bien été enregistrées.
                        <br><span class="text-blue-600 dark:text-blue-400 font-medium">Merci pour la mise à jour !</span>
                    </p>
                @endif

                {{-- Apple Wallet Download Badge (Official Apple SVG) --}}
                @if($createdContactId)
                    <div class="mt-6 flex flex-col items-center">
                        <a id="apple-wallet-button" 
                           href="{{ route('wallet.download-pass', $createdContactId) }}"
                           class="inline-block transition-transform transform hover:-translate-y-0.5 active:translate-y-0">
                            <img src="{{ asset('images/wallet/add-to-wallet-badge-fr.svg') }}"
                                 alt="Ajouter à l'app Cartes Apple"
                                 style="height: 44px; width: auto;">
                        </a>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-2 text-center">Ouvrez ce lien depuis votre iPhone pour ajouter la carte.</p>
                    </div>
                @endif

                <div class="mt-8">
                    <a href="{{ route('profile.public', $team->public_uuid) }}" class="inline-flex justify-center items-center w-full rounded-xl px-5 py-3.5 text-base font-bold text-white shadow-lg transition-all transform hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-offset-2
                        {{ $successMessage === 'new'
                            ? 'bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 hover:shadow-xl focus:ring-emerald-500'
                            : 'bg-gradient-to-r from-blue-600 to-indigo-500 hover:from-blue-500 hover:to-indigo-400 hover:shadow-xl focus:ring-blue-500' }}">
                        Découvrir nos offres
                        <svg class="w-5 h-5 ml-2 -mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    @else
        @if($isMagicLink)
            <div class="text-center mb-8 border-b border-gray-100 dark:border-gray-700/50 pb-6 relative">
                <h3 class="text-2xl leading-none font-bold text-gray-900 dark:text-white">Mise à jour de vos informations</h3>
                <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">
                    Vérifiez et mettez à jour vos coordonnées ci-dessous.
                </p>
            </div>
        @else
            <div class="text-center mb-8 border-b border-gray-100 dark:border-gray-700/50 pb-6 relative">
                <h3 class="text-2xl leading-none font-bold text-gray-900 dark:text-white">Inscription Privilège</h3>
                <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">
                    Créez votre compte en quelques secondes pour débloquer des cadeaux exclusifs !
                </p>
            </div>
        @endif

        <form wire:submit.prevent="submit" class="space-y-6 text-left relative z-10">
            
            @error('contact')
                <div class="p-4 bg-red-50 text-red-700 text-sm rounded-xl dark:bg-red-900/30 dark:text-red-400 border border-red-200 dark:border-red-800 shadow-sm flex items-start animate-[shake_0.5s_ease-in-out]">
                    <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>{{ $message }}</span>
                </div>
            @enderror

            <div class="group">
                <x-label for="name" value="{{ __('Nom complet') }} *" class="text-gray-700 dark:text-gray-300 font-semibold mb-1 group-focus-within:text-emerald-600 transition-colors" />
                <x-input id="name" type="text" class="mt-1 block w-full py-3 px-4 rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500/20 transition-all bg-white dark:bg-gray-900/50" wire:model="name" autocomplete="name" required placeholder="Ex: Jean Dupont" />
                <x-input-error for="name" class="mt-2" />
            </div>

            <div class="space-y-6">
                <div class="group">
                    <x-label for="phone" value="{{ __('Numéro de téléphone') }}" class="text-gray-700 dark:text-gray-300 font-semibold mb-1 group-focus-within:text-emerald-600 transition-colors" />
                    <x-phone-input id="phone" wireModel="phone" :initialValue="$phone" placeholder="06 12 34 56 78" />
                    <x-input-error for="phone" class="mt-2" />
                </div>

                <div class="group">
                    <x-label for="email" value="{{ __('Adresse Email') }}" class="text-gray-700 dark:text-gray-300 font-semibold mb-1 group-focus-within:text-emerald-600 transition-colors" />
                    <x-input id="email" type="email" class="mt-1 block w-full py-3 px-4 rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500/20 transition-all bg-white dark:bg-gray-900/50" wire:model="email" autocomplete="email" placeholder="jean@email.com" />
                    <x-input-error for="email" class="mt-2" />
                </div>
            </div>

            <div class="group">
                <x-label for="date_of_birth" value="{{ __('Date de naissance') }}" class="text-gray-700 dark:text-gray-300 font-semibold mb-1 group-focus-within:text-emerald-600 transition-colors" />
                <x-input id="date_of_birth" type="date" class="mt-1 block w-full py-3 px-4 rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500/20 transition-all bg-white dark:bg-gray-900/50" wire:model="date_of_birth" max="{{ now()->format('Y-m-d') }}" />
                <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">Facultatif — pour recevoir des offres d'anniversaire</p>
                <x-input-error for="date_of_birth" class="mt-2" />
            </div>
            
            <div class="bg-blue-50/50 dark:bg-blue-900/10 rounded-xl p-3 border border-blue-100 dark:border-blue-800/30">
                <p class="flex items-center text-xs text-blue-800 dark:text-blue-300">
                    <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Afin de vous retrouver en caisse, un numéro ou email est requis.
                </p>
            </div>

            <div class="mt-6 pt-5 border-t border-gray-100 dark:border-gray-700/50 space-y-4">
                <label for="opt_in_loyalty" class="flex items-start cursor-pointer group">
                    <div class="flex items-center h-4 mt-0.5">
                        <x-checkbox id="opt_in_loyalty" wire:model="opt_in_loyalty" required class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500 h-4 w-4" />
                    </div>
                    <div class="ml-2 text-xs">
                        <span class="font-medium text-gray-700 dark:text-gray-300 group-hover:text-emerald-700 dark:group-hover:text-emerald-400 transition-colors">J'accepte de rejoindre le programme de fidélité *</span>
                        <p class="mt-0.5 text-gray-500 dark:text-gray-400">Pour comptabiliser vos points de fidélité.</p>
                    </div>
                </label>
                <x-input-error for="opt_in_loyalty" class="mt-0 ml-6" />

                <label for="opt_in_marketing" class="flex items-start cursor-pointer group">
                    <div class="flex items-center h-4 mt-0.5">
                        <x-checkbox id="opt_in_marketing" wire:model="opt_in_marketing" class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500 h-4 w-4" />
                    </div>
                    <div class="ml-2 text-xs">
                        <span class="font-medium text-gray-700 dark:text-gray-300 group-hover:text-emerald-700 dark:group-hover:text-emerald-400 transition-colors">Recevoir les offres VIP et promotions</span>
                    </div>
                </label>
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full relative flex items-center justify-center py-4 px-8 border border-transparent text-lg font-extrabold rounded-xl text-white bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 shadow-[0_10px_20px_-10px_rgba(16,185,129,0.5)] hover:shadow-[0_15px_30px_-10px_rgba(16,185,129,0.6)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all transform hover:-translate-y-1 overflow-hidden group disabled:opacity-75 disabled:cursor-not-allowed" wire:loading.attr="disabled">
                    
                    <!-- Shine Effect -->
                    <div class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/20 to-transparent group-hover:animate-[shimmer_1.5s_infinite]"></div>
                    
                    <span wire:loading.remove wire:target="submit" class="relative z-10 flex items-center">
                        Créer ma carte VIP
                        <svg class="w-5 h-5 ml-2 -mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </span>
                    <span wire:loading wire:target="submit" class="relative z-10 flex items-center">
                        <!-- Loading spinner -->
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Préparation en cours...
                    </span>
                </button>
            </div>
        </form>

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
    @endif

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('passCreated', (event) => {
                const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) || 
                             (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1);
                
                if (isIOS && event[0].downloadUrl) {
                    // Slight delay to ensure the success UI is visible
                    setTimeout(() => {
                        window.location.href = event[0].downloadUrl;
                    }, 1500);
                }
            });
        });
    </script>
</div>
