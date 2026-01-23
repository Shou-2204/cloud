<div>
    @if($showFeedbackForm)
        <!-- Feedback Form for Positive Ratings -->
        <div class="text-center transition-all duration-300">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
                <span class="text-3xl">🎉</span>
            </div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Merci beaucoup !</h2>
            <p class="text-gray-600 dark:text-gray-300 mb-6">
                Nous sommes ravis que cela vous ait plu !
            </p>

            <!-- 1. Google Review (Primary Action) -->
            @if($team->settings->google_review_url)
                <a href="{{ $team->settings->google_review_url }}" target="_blank"
                    class="block w-full py-4 px-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-lg shadow-lg transition transform hover:-translate-y-0.5 mb-8 flex items-center justify-center gap-2">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12.48 10.92v3.28h7.84c-.24 1.84-.853 3.187-1.787 4.133-1.147 1.147-2.933 2.4-6.053 2.4-4.827 0-8.6-3.893-8.6-8.72s3.773-8.72 8.6-8.72c2.6 0 4.507 1.027 5.907 2.347l2.307-2.307C18.747 1.44 16.133 0 12.48 0 5.867 0 .307 5.387.307 12s5.56 12 12.173 12c3.573 0 6.267-1.173 8.373-3.36 2.16-2.16 2.84-5.213 2.84-7.667 0-.76-.053-1.467-.173-2.053H12.48z"></path></svg>
                    Laisser un avis sur Google
                </a>
            @else
                <button class="block w-full py-3 px-4 bg-gray-200 text-gray-500 rounded-xl cursor-not-allowed mb-8">
                    Lien Google non configuré
                </button>
            @endif

            <!-- 2. Message Form (Secondary Action) -->
            <div class="border-t border-gray-100 dark:border-gray-700 pt-6">
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-2">
                    Vous souhaitez nous laisser un message privé ?
                </h3>
                
                <div class="mb-3 text-left">
                    <textarea wire:model="feedback" id="feedback" rows="2"
                        class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm"
                        placeholder="Votre message pour l'équipe..."></textarea>
                </div>

                <button wire:click="submitFeedback"
                    class="w-full py-2 px-4 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 rounded-lg font-medium shadow-sm transition text-sm">
                    Envoyer le message à l'établissement
                </button>
            </div>
        </div>
    @elseif($hasAlreadyVoted || $recorded)
        <!-- Thank you message (Final State after Message or just voted) -->
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-emerald-100 mb-4">
                <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Message envoyé !</h2>
            <p class="text-gray-600 dark:text-gray-300 mb-6">
                Merci d'avoir pris le temps de nous écrire.
            </p>

            @if($team->settings->google_review_url)
                <a href="{{ $team->settings->google_review_url }}" target="_blank"
                    class="block w-full py-4 px-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-lg shadow-lg transition transform hover:-translate-y-0.5 mb-4 flex items-center justify-center gap-2">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12.48 10.92v3.28h7.84c-.24 1.84-.853 3.187-1.787 4.133-1.147 1.147-2.933 2.4-6.053 2.4-4.827 0-8.6-3.893-8.6-8.72s3.773-8.72 8.6-8.72c2.6 0 4.507 1.027 5.907 2.347l2.307-2.307C18.747 1.44 16.133 0 12.48 0 5.867 0 .307 5.387.307 12s5.56 12 12.173 12c3.573 0 6.267-1.173 8.373-3.36 2.16-2.16 2.84-5.213 2.84-7.667 0-.76-.053-1.467-.173-2.053H12.48z"></path></svg>
                    Laisser un avis sur Google
                </a>
                <p class="text-xs text-gray-500 mb-4">Si vous ne l'avez pas déjà fait 😉</p>
            @endif

            <div>
                <a href="{{ route('profile.public', $team->public_uuid) }}" class="text-emerald-600 hover:underline">
                    Retour au profil
                </a>
            </div>
        </div>
    @endif
</div>