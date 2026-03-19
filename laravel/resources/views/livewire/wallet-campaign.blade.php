<div>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Progress Header --}}
        <div class="mb-10 text-center">
            <a href="{{ route('campaigns.index') }}"
                class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-emerald-600 transition-colors mb-4 group">
                <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Retour aux Campagnes
            </a>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight">Campagne Wallet
                Mobile</h1>
            <p class="mt-3 text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto italic">
                Communiquez directement sur l'écran verrouillé de vos clients ayant votre carte dans leur Apple Wallet
                ou Google Wallet.
            </p>
        </div>

        @if (session()->has('success'))
            <div
                class="mb-8 p-5 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-400 rounded-2xl flex items-center gap-3 animate-[slide-in_0.5s_ease-out]">
                <svg class="w-6 h-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-bold">{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">

            {{-- Left column: Composer --}}
            <div class="lg:col-span-7 space-y-8">
                <div
                    class="bg-white dark:bg-emerald-dark-500 rounded-3xl shadow-xl border border-gray-100 dark:border-emerald-dark-400 overflow-hidden">
                    <div class="p-8">
                        <div class="flex items-center gap-3 mb-8">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Rédiger votre message</h2>
                        </div>

                        <form wire:submit.prevent="confirmSend" class="space-y-6">
                            <div>
                                <label for="message"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Message de
                                    l'offre ou actualité</label>
                                <div class="relative group">
                                    <textarea id="message" wire:model.live="message" rows="5" maxlength="255"
                                        placeholder="Ex: -20% sur tout le magasin ce samedi ! Venez vite avec votre carte VIP."
                                        class="w-full px-5 py-4 rounded-2xl border-gray-200 dark:border-emerald-dark-400 bg-gray-50 dark:bg-emerald-dark-600 text-gray-900 dark:text-white focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all resize-none text-lg leading-relaxed shadow-inner"
                                        required></textarea>
                                    <div
                                        class="absolute bottom-4 right-4 text-xs font-bold px-3 py-1 rounded-lg bg-white/50 dark:bg-black/20 backdrop-blur-sm 
                                        {{ strlen($message) > 240 ? 'text-red-500' : (strlen($message) > 180 ? 'text-amber-500' : 'text-gray-400') }}">
                                        {{ strlen($message) }} / 255
                                    </div>
                                </div>
                                <div class="mt-2 flex justify-between items-center px-1">
                                    <x-input-error for="message" />
                                    @if (strlen($message) > 180 && strlen($message) <= 255)
                                        <span
                                            class="text-[10px] font-bold text-amber-600 dark:text-amber-400 uppercase tracking-tighter animate-pulse">
                                            ⚠️ Attention: Le message pourra être tronqué sur certains écrans verrouillés.
                                        </span>
                                    @elseif(strlen($message) > 255)
                                        <span class="text-[10px] font-bold text-red-600 dark:text-red-400 uppercase tracking-tighter">
                                            ❌ Limite de 255 caractères dépassée.
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div
                                class="p-5 bg-blue-50/50 dark:bg-blue-900/10 rounded-2xl border border-blue-100 dark:border-blue-800/30">
                                <div class="flex gap-4">
                                    <svg class="w-6 h-6 text-blue-500 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div>
                                        <h4 class="text-sm font-bold text-blue-900 dark:text-blue-300">Diffusion
                                            instantanée</h4>
                                        <p class="mt-1 text-sm text-blue-800/70 dark:text-blue-400/70 leading-relaxed">
                                            Le message apparaîtra en notification ET sera sauvegardé au dos de la carte
                                            de vos clients.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-2">
                                <button type="submit" wire:loading.attr="disabled" {{ strlen($message) > 255 ? 'disabled' : '' }}
                                    class="w-full relative py-4 px-8 bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white font-extrabold text-lg rounded-2xl shadow-[0_15px_30px_-10px_rgba(16,185,129,0.5)] transition-all transform hover:-translate-y-1 active:translate-y-0 disabled:opacity-50 disabled:cursor-not-allowed group overflow-hidden">
                                    <div
                                        class="absolute inset-0 bg-white/10 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700 ease-in-out">
                                    </div>
                                    <span wire:loading.remove wire:target="confirmSend"
                                        class="relative z-10 flex items-center justify-center gap-3">
                                        Envoyer la notification
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                    </span>
                                    <span wire:loading wire:target="confirmSend"
                                        class="relative z-10 flex items-center justify-center gap-3">
                                        <svg class="animate-spin h-6 w-6" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                        Enregistrement et diffusion...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Right column: Preview --}}
            <div class="lg:col-span-5 pt-0 lg:pt-8">
                <div class="sticky top-8">
                    <div
                        class="relative mx-auto w-[300px] h-[600px] bg-black rounded-[50px] border-[8px] border-gray-800 shadow-2xl overflow-hidden p-3 ring-4 ring-gray-900/10">
                        {{-- iPhone UI Elements --}}
                        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-32 h-6 bg-black rounded-b-2xl z-20">
                        </div> {{-- Dynamic Island --}}

                        {{-- Wallpaper --}}
                        <div class="absolute inset-0 bg-gradient-to-b from-gray-900 via-indigo-950 to-emerald-950">
                        </div>
                        <div class="absolute top-[15%] left-1/2 -translate-x-1/2 text-center text-white/90 z-10 w-full">
                            <p class="text-xs font-bold uppercase tracking-widest opacity-60">
                                {{ now()->translatedFormat('l j F') }}</p>
                            <h4 class="text-6xl font-light tracking-tight mt-1">{{ now()->format('H:i') }}</h4>
                        </div>

                        {{-- Notification Box --}}
                        <div class="absolute top-[35%] left-2 right-2 z-10 animate-[notification-slide_1s_ease-out]">
                            <div
                                class="bg-white/10 dark:bg-white/5 backdrop-blur-2xl rounded-3xl border border-white/20 p-4 shadow-2xl">
                                <div class="flex items-start gap-3">
                                    <div
                                        class="w-11 h-11 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center flex-shrink-0 shadow-lg ring-1 ring-white/20">
                                        <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center justify-between">
                                            <span
                                                class="text-[10px] font-extrabold text-emerald-400 uppercase tracking-widest">CARTES</span>
                                            <div class="flex items-center gap-1 opacity-50">
                                                <span class="text-[10px] text-white">maintenant</span>
                                                <div class="w-1 h-1 bg-white rounded-full"></div>
                                            </div>
                                        </div>
                                        <p class="text-[14px] font-black text-white leading-tight mt-0.5">
                                            {{ auth()->user()->currentTeam->name }}</p>
                                        <div class="mt-1.5 min-h-[44px]">
                                            <p class="text-[13px] text-white/90 leading-snug font-medium line-clamp-3">
                                                {{ $message ?: "Tapez votre message sur la gauche pour voir l'aperçu ici..." }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 flex flex-col gap-2 items-center opacity-40">
                                <div class="h-1.5 w-32 bg-white/20 rounded-full"></div>
                                <p class="text-[10px] text-white font-medium uppercase tracking-widest">Balayer pour
                                    déverrouiller</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Confirmation Modal --}}
    <x-confirmation-modal wire:model.live="showConfirmation">
        <x-slot name="title">
            <span class="text-gray-900 dark:text-white font-bold text-xl flex items-center gap-3">
                <div class="w-10 h-10 bg-amber-100 dark:bg-amber-900/30 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                Confirmer l'envoi de la campagne
            </span>
        </x-slot>

        <x-slot name="content">
            <div class="space-y-6">
                <div class="p-6 bg-gray-50 dark:bg-emerald-dark-600 rounded-2xl border border-gray-100 dark:border-emerald-dark-400 shadow-inner">
                    <p class="text-sm font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">Votre message :</p>
                    <p class="text-gray-900 dark:text-white text-lg leading-relaxed italic">
                        "{{ $message }}"
                    </p>
                </div>

                <div class="flex items-center gap-4 p-5 bg-emerald-50 dark:bg-emerald-900/20 rounded-2xl border border-emerald-100 dark:border-emerald-800/30">
                    <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-emerald-500/20">
                        <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-emerald-800/70 dark:text-emerald-400/70">Portée de la campagne :</p>
                        <p class="text-xl font-black text-emerald-900 dark:text-emerald-300">
                            {{ $recipientCount }} {{ $recipientCount > 1 ? 'destinataires' : 'destinataire' }}
                        </p>
                    </div>
                </div>

                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed italic">
                    Une notification push sera envoyée immédiatement sur l'écran de verrouillage des téléphones de vos clients (Apple Wallet et Google Wallet).
                </p>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('showConfirmation', false)" wire:loading.attr="disabled" class="rounded-xl px-6 py-3 border-gray-200 dark:border-emerald-dark-400 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-emerald-dark-400 transition-all font-bold">
                Annuler
            </x-secondary-button>

            <button wire:click="sendCampaign" wire:loading.attr="disabled" class="ml-3 inline-flex items-center justify-center px-8 py-3 bg-emerald-600 border border-transparent rounded-xl font-black text-sm text-white uppercase tracking-widest hover:bg-emerald-500 active:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all shadow-lg shadow-emerald-500/20">
                Confirmer et Envoyer
            </button>
        </x-slot>
    </x-confirmation-modal>

    <style>
        @keyframes slide-in {
            0% {
                opacity: 0;
                transform: translateY(-10px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes notification-slide {
            0% {
                opacity: 0;
                transform: translateY(50px) scale(0.9);
            }

            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
    </style>
</div>