<div>
    @if($hasAlreadyVoted)
        <!-- Already voted message -->
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-emerald-100 mb-4">
                <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Merci pour votre avis !</h2>
            <p class="text-gray-600 dark:text-gray-300 mb-6">
                Votre note a déjà été prise en compte. Nous vous remercions pour votre retour !
            </p>

            @if($team->google_review_url)
                <a href="{{ $team->google_review_url }}" target="_blank"
                    class="block w-full py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-semibold shadow-lg transition transform hover:-translate-y-0.5">
                    Laisser un avis sur Google
                </a>
            @endif

            <div class="mt-6">
                <a href="{{ route('profile.public', $team->public_uuid) }}" class="text-emerald-600 hover:underline">
                    Retour au profil
                </a>
            </div>
        </div>
    @else
        <!-- Normal positive flow -->
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
                <span class="text-3xl">🎉</span>
            </div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Merci beaucoup !</h2>
            <p class="text-gray-600 dark:text-gray-300 mb-6">
                {{ $team->review_positive_message ?? "Nous sommes ravis que cela vous ait plu ! Pourriez-vous nous laisser un petit mot sur Google ? Cela nous aide énormément." }}
            </p>

            @if($team->google_review_url)
                <a href="{{ $team->google_review_url }}" target="_blank"
                    class="block w-full py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-semibold shadow-lg transition transform hover:-translate-y-0.5">
                    Laisser un avis sur Google
                </a>
            @else
                <button
                    class="block w-full py-3 px-4 bg-gray-200 dark:bg-gray-700 text-gray-500 rounded-xl font-semibold cursor-not-allowed">
                    Lien Google non configuré
                </button>
            @endif
        </div>
    @endif
</div>