<x-public-layout :seo="['title' => 'Enquête de satisfaction - ' . $team->name, 'description' => 'Votre avis compte pour ' . $team->name]">
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 flex flex-col items-center justify-center p-4">

        <!-- Header -->
        <div class="text-center mb-8">
            @if($team->profile->logo_path)
                <img src="{{ Storage::disk('cloud_public')->url($team->profile->logo_path) }}" alt="{{ $team->name }}"
                    class="h-20 w-20 rounded-full mx-auto mb-4 object-cover shadow-lg">
            @endif
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Enquête de satisfaction</h1>
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
            },
            setRating(value) {
                this.rating = value;
                // Petit délai pour l'animation visuelle avant de changer d'étape
                setTimeout(() => {
                    this.step = 2;
                }, 300);
            }
        }" class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 max-w-md w-full transition-all duration-300">

            <!-- Step 1: Stars -->
            <div x-show="step === 1" x-transition>
                <h2 class="text-xl font-semibold text-center text-gray-900 dark:text-white mb-6">Comment s'est passée
                    votre expérience ?</h2>

                <div class="flex flex-col items-center mb-8">
                    <div class="flex justify-center space-x-2">
                        <template x-for="star in 5">
                            <button @click="setRating(star)" @mouseenter="hoverRating = star"
                                @mouseleave="hoverRating = 0"
                                class="focus:outline-none transform transition duration-200" :class="{
                                    'hover:scale-125': hoverRating === star,
                                    'scale-125': rating === star,
                                    'animate-bounce text-yellow-400 drop-shadow-lg': star === 5 && (hoverRating === 5 || rating === 5),
                                    'hover:scale-110': star !== 5
                                }">
                                <svg class="w-10 h-10"
                                    :class="(hoverRating >= star || (hoverRating === 0 && rating >= star)) ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600'"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </button>
                        </template>
                    </div>

                    <!-- Validation Button Removed -->
                    <div x-show="rating > 0" x-transition class="mt-8 text-center" style="display: none;">
                    </div>
                </div>
            </div>

            <!-- Step 2: Gating Logic -->
            <div x-show="step === 2" x-transition x-cloak>

                <!-- Positive Flow (4-5 Stars) -->
                <div x-show="rating >= 4"
                    x-init="$watch('rating', value => { if(value >= 4) { Livewire.dispatch('record-positive-rating', { rating: value }) } })">
                    @livewire('positive-rating-recorder', ['team' => $team], key('positive-rating-' . $team->id))
                </div>

                <!-- Negative Flow (1-3 Stars) - Using Livewire Component -->
                <div x-show="rating < 4 && rating > 0"
                    x-init="$watch('rating', value => { if(value > 0 && value < 4) { Livewire.dispatch('set-rating', { rating: value }) } })">
                    @livewire('negative-review-form', ['team' => $team], key('negative-review-' . $team->id))


                </div>

            </div>

            <!-- Step 3: Thank You (for positive reviews that came back) -->
            <div x-show="step === 3" x-transition x-cloak class="text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-emerald-100 mb-4">
                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Merci !</h2>
                <p class="text-gray-600 dark:text-gray-300">
                    Votre avis compte beaucoup pour nous.
                </p>
                <div class="mt-6">
                    <a href="{{ route('profile.public', $team->public_uuid) }}"
                        class="text-emerald-600 hover:underline">Retour au profil</a>
                </div>
            </div>

        </div>


    </div>
</x-public-layout>