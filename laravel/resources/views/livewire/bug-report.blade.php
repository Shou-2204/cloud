<div>
    {{-- Bug Report Modal --}}
    <div x-data="{ open: @entangle('isOpen') }" x-show="open" x-cloak class="fixed inset-0 z-50 overflow-y-auto"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">

        {{-- Backdrop --}}
        <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-500 bg-opacity-75 dark:bg-gray-900 dark:bg-opacity-75 transition-opacity"
            @click="$wire.closeModal()">
        </div>

        {{-- Modal Panel --}}
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div x-show="open" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative transform overflow-hidden rounded-lg bg-white dark:bg-emerald-dark-500 px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6"
                @click.away="$wire.closeModal()">

                @if($submitted)
                    {{-- Success State --}}
                    <div class="text-center py-6">
                        <div
                            class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-emerald-100 dark:bg-emerald-900/50">
                            <svg class="h-6 w-6 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">Merci pour votre rapport !</h3>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            Votre rapport de bug a été envoyé à notre équipe. Nous l'examinerons dans les plus brefs délais.
                        </p>
                        <div class="mt-6">
                            <button type="button" wire:click="closeModal"
                                class="inline-flex justify-center rounded-md bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600">
                                Fermer
                            </button>
                        </div>
                    </div>
                @else
                    {{-- Form State --}}
                    <div>
                        <div class="flex items-center gap-3">
                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/50">
                                <svg class="h-5 w-5 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 12.75c1.148 0 2.278.08 3.383.237 1.037.146 1.866.966 1.866 2.013 0 3.728-2.35 6.75-5.25 6.75S6.75 18.728 6.75 15c0-1.046.83-1.867 1.866-2.013A24.204 24.204 0 0112 12.75zm0 0c2.883 0 5.647.508 8.207 1.44a23.91 23.91 0 01-1.152 6.06M12 12.75c-2.883 0-5.647.508-8.207 1.44a23.91 23.91 0 001.152 6.06M12 12.75V6.75m0 0a2.25 2.25 0 10-4.5 0m4.5 0a2.25 2.25 0 114.5 0m-4.5 0V4.5" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold leading-6 text-gray-900 dark:text-white" id="modal-title">
                                Signaler un bug
                            </h3>
                        </div>

                        <div class="mt-4">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Décrivez le problème que vous avez rencontré. Soyez le plus précis possible pour nous aider
                                à le résoudre rapidement.
                            </p>
                        </div>

                        <form wire:submit="submit" class="mt-4">
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Description du bug
                                </label>
                                <textarea wire:model="description" id="description" rows="5"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-emerald-dark-400 dark:bg-emerald-dark-600 dark:text-white shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm"
                                    placeholder="Décrivez ce que vous faisiez quand le bug s'est produit, ce que vous attendiez, et ce qui s'est passé à la place..."></textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
                                <button type="submit" wire:loading.attr="disabled"
                                    wire:loading.class="opacity-50 cursor-not-allowed"
                                    class="inline-flex w-full justify-center rounded-md bg-emerald-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600 sm:col-start-2">
                                    <span wire:loading.remove wire:target="submit">Envoyer le rapport</span>
                                    <span wire:loading wire:target="submit">Envoi en cours...</span>
                                </button>
                                <button type="button" wire:click="closeModal"
                                    class="mt-3 inline-flex w-full justify-center rounded-md bg-white dark:bg-emerald-dark-600 px-3 py-2 text-sm font-semibold text-gray-900 dark:text-white shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-emerald-dark-400 hover:bg-gray-50 dark:hover:bg-emerald-dark-500 sm:col-start-1 sm:mt-0">
                                    Annuler
                                </button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>