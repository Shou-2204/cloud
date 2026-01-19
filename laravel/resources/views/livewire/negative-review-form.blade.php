<div>
    @if($submitted)
        <!-- Thank You Message -->
        <div class="text-center" x-transition>
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-emerald-100 mb-4">
                <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Message envoyé</h2>
            <p class="text-gray-600 dark:text-gray-300">
                Merci d'avoir pris le temps de nous écrire. Nous allons lire votre message avec attention.
            </p>
            <div class="mt-6">
                <a href="{{ route('profile.public', $team->public_uuid) }}" class="text-emerald-600 hover:underline">Retour
                    au profil</a>
            </div>
        </div>
    @else
        <!-- Feedback Form -->
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-orange-100 mb-4">
                <span class="text-3xl">🙏</span>
            </div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Désolé pour cette expérience</h2>
            <p class="text-gray-600 dark:text-gray-300 mb-6">
                {{ $team->review_negative_message ?? "Nous sommes navrés que tout ne se soit pas passé comme prévu. Dites-nous ce qui n'a pas été, nous ferons tout pour nous rattraper." }}
            </p>

            <form wire:submit="submit">
                <input type="hidden" wire:model="rating" />

                <div class="mb-4">
                    <textarea wire:model.live="feedback" rows="4"
                        class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                        placeholder="Dites-nous en plus... (minimum {{ $this::MIN_WORDS }} mots)"></textarea>

                    <!-- Word counter -->
                    <div class="mt-2 flex justify-between items-center text-sm">
                        <span class="{{ $this->hasEnoughWords ? 'text-emerald-600' : 'text-gray-500' }}">
                            {{ $this->wordCount }} / {{ $this::MIN_WORDS }} mots minimum
                        </span>
                        @if($this->hasEnoughWords)
                            <span class="text-emerald-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                Parfait !
                            </span>
                        @endif
                    </div>

                    @error('feedback')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" @if(!$this->hasEnoughWords) disabled @endif
                    class="block w-full py-3 px-4 bg-gray-900 dark:bg-gray-700 text-white rounded-xl font-semibold shadow-lg transition
                            {{ $this->hasEnoughWords ? 'hover:bg-black cursor-pointer' : 'opacity-50 cursor-not-allowed' }}" wire:loading.attr="disabled"
                    wire:loading.class="opacity-50">
                    <span wire:loading.remove>Envoyer mon message au gérant</span>
                    <span wire:loading>Envoi en cours...</span>
                </button>
            </form>
        </div>
    @endif
</div>