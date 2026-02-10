<div class="w-full">
    @if ($submitted)
        <!-- Success Message -->
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-90"
            x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-700 text-emerald-800 dark:text-emerald-200 px-6 py-4 rounded-xl flex items-center gap-3 mb-4">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <div>
                <p class="font-bold">Merci pour votre intérêt !</p>
                <p class="text-sm">Nous vous contacterons dès le lancement.</p>
            </div>
        </div>
    @endif

    <!-- Form -->
    <form wire:submit.prevent="submit" class="w-full">
        @if ($withDetails)
            <div class="mb-6 text-center">
                <p class="font-bold text-lg text-gray-800 dark:text-gray-200">Des questions ? Vous souhaitez être recontacté ?</p>
            </div>
            <div class="flex flex-col gap-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <input wire:model.live="name" type="text" placeholder="Votre Nom"
                            class="w-full px-6 py-4 text-base rounded-xl border-2 border-gray-200 dark:border-emerald-dark-400 bg-white dark:bg-emerald-dark-500 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-emerald-500 dark:focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 transition-all outline-none @error('name') border-red-500 dark:border-red-500 @enderror">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <input wire:model.live="phone" type="tel" placeholder="Votre Téléphone"
                            class="w-full px-6 py-4 text-base rounded-xl border-2 border-gray-200 dark:border-emerald-dark-400 bg-white dark:bg-emerald-dark-500 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-emerald-500 dark:focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 transition-all outline-none @error('phone') border-red-500 dark:border-red-500 @enderror">
                        @error('phone')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div>
                    <input wire:model.live="email" type="email" placeholder="votre@email.com"
                        class="w-full px-6 py-4 text-base rounded-xl border-2 border-gray-200 dark:border-emerald-dark-400 bg-white dark:bg-emerald-dark-500 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-emerald-500 dark:focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 transition-all outline-none @error('email') border-red-500 dark:border-red-500 @enderror">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit"
                    class="w-full px-8 py-4 text-base font-bold text-white bg-emerald-600 hover:bg-emerald-500 dark:bg-emerald-600 dark:hover:bg-emerald-500 rounded-xl transition-all shadow-xl shadow-emerald-500/20 transform hover:-translate-y-1 hover:shadow-2xl hover:shadow-emerald-500/30">
                    Être recontacté
                </button>
            </div>
        @else
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1">
                    <input wire:model.live="email" type="email" placeholder="votre@email.com"
                        class="w-full px-6 py-4 text-base rounded-xl border-2 border-gray-200 dark:border-emerald-dark-400 bg-white dark:bg-emerald-dark-500 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-emerald-500 dark:focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 transition-all outline-none @error('email') border-red-500 dark:border-red-500 @enderror">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit"
                    class="px-8 py-4 text-base font-bold text-white bg-emerald-600 hover:bg-emerald-500 dark:bg-emerald-600 dark:hover:bg-emerald-500 rounded-xl transition-all shadow-xl shadow-emerald-500/20 transform hover:-translate-y-1 hover:shadow-2xl hover:shadow-emerald-500/30 whitespace-nowrap">
                    Je réserve ma place
                </button>
            </div>
        @endif
    </form>
</div>