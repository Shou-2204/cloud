<div>
    {{-- AJOUT DE LA BORDURE ICI (Liée au composant) --}}
    <x-section-border />

    <div class="mt-10 sm:mt-0">
        <x-action-section>
            <x-slot name="title">
                {{ __('Demandes d\'adhésion') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Ces utilisateurs ont utilisé votre code d\'accès. Validez-les pour qu\'ils rejoignent l\'organisation officiellement.') }}
            </x-slot>

            <x-slot name="content">
                <div class="space-y-6">
                    @if($this->pendingUsers->isEmpty())
                        <div class="text-sm text-gray-500 dark:text-gray-400 italic">
                            {{ __('Aucune demande en attente pour le moment.') }}
                        </div>
                    @else
                        @foreach ($this->pendingUsers as $user)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <img class="w-10 h-10 rounded-full object-cover border-2 border-white dark:border-gray-700"
                                        src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">
                                    <div class="ms-4">
                                        <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $user->name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $user->email }}</div>
                                    </div>
                                </div>

                                <div class="flex items-center space-x-3">
                                    <button
                                        class="cursor-pointer text-sm text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 font-medium underline focus:outline-none"
                                        wire:click="deny('{{ $user->id }}')">
                                        {{ __('Refuser') }}
                                    </button>

                                    <button
                                        class="cursor-pointer inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                                        wire:click="approve('{{ $user->id }}')">
                                        {{ __('Valider') }}
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </x-slot>
        </x-action-section>
    </div>
</div>