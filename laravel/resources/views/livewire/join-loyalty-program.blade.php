<div class="animate-[fade-in-up_0.6s_ease-out]">
    @if ($successMessage)
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
                @else
                    <h3 class="text-2xl leading-8 font-extrabold text-gray-900 dark:text-white tracking-tight">Bienvenue de retour ! 👋</h3>
                    <p class="mt-3 text-base text-gray-600 dark:text-gray-300">
                        Votre carte de fidélité <strong>{{ $team->name }}</strong> est toujours active.
                        <br><span class="text-blue-600 dark:text-blue-400 font-medium">Vos points et avantages sont intacts !</span>
                    </p>
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
        @if($isMagicLink)
            <div class="text-center mb-8 border-b border-gray-100 dark:border-gray-700/50 pb-6 relative">
                <h3 class="text-2xl leading-none font-bold text-gray-900 dark:text-white">Votre espace Fidélité</h3>
                
                <div class="mt-4 inline-flex items-center justify-center p-4 bg-orange-50 dark:bg-orange-900/20 rounded-2xl border-2 border-orange-200 dark:border-orange-800 animate-[fade-in-up_0.6s_ease-out]">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-orange-100 dark:bg-orange-800 text-orange-600 dark:text-orange-300 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div class="text-left">
                            <p class="text-xs text-orange-800 dark:text-orange-400 font-medium uppercase tracking-wider">Solde actuel</p>
                            <p class="text-2xl font-black text-orange-600 dark:text-orange-300">{{ $loyalty_points }} {{ ($team->settings->loyalty_program_type ?? 'points') === 'visits' ? 'visite(s)' : 'point(s)' }}</p>
                        </div>
                    </div>
                </div>
                
                @php
                    $rewards = $team->loyaltyRewards()->orderBy('points_required')->get();
                @endphp
                @if($rewards->count() > 0)
                    <div class="mt-6 text-left space-y-2">
                        <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2 px-1">Récompenses :</p>
                        @foreach($rewards as $reward)
                            @php
                                $canClaim = $loyalty_points >= $reward->points_required;
                            @endphp
                            <div class="flex items-center justify-between p-3 rounded-xl {{ $canClaim ? 'bg-orange-100 dark:bg-orange-900/40 border border-orange-200 dark:border-orange-700' : 'bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700' }}">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full {{ $canClaim ? 'bg-orange-200 text-orange-700' : 'bg-gray-200 text-gray-500' }} flex items-center justify-center font-bold text-xs">
                                        {{ $reward->points_required }}
                                    </div>
                                    <span class="text-sm font-medium {{ $canClaim ? 'text-orange-900 dark:text-orange-300' : 'text-gray-600 dark:text-gray-400' }}">{{ $reward->name }}</span>
                                </div>
                                @if($canClaim)
                                    <span class="text-xs bg-orange-500 text-white px-2 py-1 rounded-full uppercase tracking-wide font-bold">Débloqué</span>
                                @else
                                    <span class="text-xs text-gray-500">Encore {{ $reward->points_required - $loyalty_points }}</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
                
                <p class="mt-6 text-xs text-gray-500 dark:text-gray-400 italic">Mettez à jour vos coordonnées ci-dessous si nécessaire.</p>
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
</div>
