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
    @elseif($rateLimited)
        <!-- Rate Limited Message -->
        <div class="text-center" x-transition>
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-orange-100 mb-4">
                <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Message déjà envoyé</h2>
            <p class="text-gray-600 dark:text-gray-300">
                Vous avez déjà envoyé un message récemment. Veuillez patienter avant d'en envoyer un autre.
            </p>
            <div class="mt-6">
                <a href="{{ route('profile.public', $team->public_uuid) }}" class="text-emerald-600 hover:underline">Retour
                    au profil</a>
            </div>
        </div>
    @else
        <!-- Feedback Form -->
        <div class="text-center" x-data="{ feedback: '' }">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-orange-100 mb-4">
                <span class="text-3xl">🙏</span>
            </div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Désolé pour cette expérience</h2>
            <p class="text-gray-600 dark:text-gray-300 mb-6">
                {{ $team->settings->review_negative_message ?? "Dites-nous ce qui n'a pas été. Notre direction lit chaque message." }}
            </p>

            <form wire:submit="submit">
                <input type="hidden" wire:model="rating" />

                <div class="mb-4">
                    <textarea x-model="feedback" wire:model="feedback" rows="4" maxlength="1000"
                        class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                        placeholder="Dites-nous en plus..."></textarea>

                    @error('feedback')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="block w-full py-3 px-4 bg-gray-900 dark:bg-gray-700 text-white rounded-xl font-semibold shadow-lg transition hover:bg-black cursor-pointer"
                    wire:loading.attr="disabled" wire:loading.class="opacity-50">
                    <span wire:loading.remove>Envoyer mon message au gérant</span>
                    <span wire:loading>Envoi en cours...</span>
                </button>

                @if($team->settings->google_review_url)
                    <div class="mt-4">
                        <a href="{{ $team->settings->google_review_url }}" target="_blank" rel="noopener noreferrer"
                            class="text-xs text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:underline">
                            Je ne souhaite pas de réponse, je veux publier mon avis sur Google.
                        </a>
                    </div>
                @endif
            </form>
        </div>
    @endif
</div>