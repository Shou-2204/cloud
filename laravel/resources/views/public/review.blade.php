<x-public-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 flex flex-col items-center justify-center p-4">

        <!-- Header -->
        <div class="text-center mb-8">
            @if($team->logo_path)
                <img src="{{ Storage::disk('minio_public')->url($team->logo_path) }}" alt="{{ $team->name }}"
                    class="h-20 w-20 rounded-full mx-auto mb-4 object-cover shadow-lg">
            @endif
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Votre avis compte pour nous</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-2">{{ $team->name }}</p>
        </div>

        <!-- Rating Card -->
        <div x-data="{ 
            rating: 0, 
            hoverRating: 0, 
            step: 1, 
            feedback: '',
            submitInternal() {
                // Here we would submit via Livewire or API
                this.step = 3; 
            }
        }" class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 max-w-md w-full transition-all duration-300">

            <!-- Step 1: Stars -->
            <div x-show="step === 1" x-transition>
                <h2 class="text-xl font-semibold text-center text-gray-900 dark:text-white mb-6">Comment s'est passée
                    votre expérience ?</h2>

                <div class="flex justify-center space-x-2 mb-8">
                    <template x-for="star in 5">
                        <button @click="rating = star; step = 2" @mouseenter="hoverRating = star"
                            @mouseleave="hoverRating = 0"
                            class="focus:outline-none transform transition hover:scale-110">
                            <svg class="w-10 h-10"
                                :class="(hoverRating >= star || rating >= star) ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600'"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </button>
                    </template>
                </div>
            </div>

            <!-- Step 2: Gating Logic -->
            <div x-show="step === 2" x-transition x-cloak>

                <!-- Positive Flow (4-5 Stars) -->
                <div x-show="rating >= 4">
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

                        <button @click="step = 1; rating = 0"
                            class="mt-4 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                            Retour
                        </button>
                    </div>
                </div>

                <!-- Negative Flow (1-3 Stars) -->
                <div x-show="rating < 4 && rating > 0">
                    <div class="text-center">
                        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-orange-100 mb-4">
                            <span class="text-3xl">🙏</span>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Désolé pour cette expérience
                        </h2>
                        <p class="text-gray-600 dark:text-gray-300 mb-6">
                            {{ $team->review_negative_message ?? "Nous sommes navrés que tout ne se soit pas passé comme prévu. Dites-nous ce qui n'a pas été, nous ferons tout pour nous rattraper." }}
                        </p>

                        <textarea x-model="feedback" rows="4"
                            class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white mb-4 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                            placeholder="Dites-nous en plus..."></textarea>

                        <button @click="submitInternal()"
                            class="block w-full py-3 px-4 bg-gray-900 dark:bg-gray-700 hover:bg-black text-white rounded-xl font-semibold shadow-lg transition">
                            Envoyer mon message au gérant
                        </button>
                        <button @click="step = 1; rating = 0"
                            class="mt-4 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                            Retour
                        </button>
                    </div>
                </div>

            </div>

            <!-- Step 3: Thank You (Internal) -->
            <div x-show="step === 3" x-transition x-cloak class="text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-emerald-100 mb-4">
                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Message envoyé</h2>
                <p class="text-gray-600 dark:text-gray-300">
                    Merci d'avoir pris le temps de nous écrire. Nous allons lire votre message avec attention.
                </p>
            </div>

        </div>

        <div class="mt-8 text-center text-sm text-gray-400">
            Propulsé par <a href="/" class="hover:text-emerald-500">ShouCloud</a>
        </div>
    </div>
    </x-guest-layout>