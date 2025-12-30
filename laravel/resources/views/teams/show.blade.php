<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Team Settings') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

            {{-- >>> LOGIQUE DE PROTECTION : EN ATTENTE <<< --}}
            @php
                $isPending = false;
                if (Auth::id() !== $team->user_id) { 
                     $membership = $team->users()->where('user_id', Auth::id())->first();
                     if ($membership && $membership->membership->is_approved == 0) {
                         $isPending = true;
                     }
                }
            @endphp

            @if ($isPending)
                {{-- 1. ALERTE JAUNE --}}
                <div class="bg-yellow-50 dark:bg-yellow-900/30 border border-yellow-200 dark:border-yellow-700 rounded-2xl p-4 shadow-sm backdrop-blur-sm transition-colors duration-300 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400 dark:text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm leading-5 font-medium text-yellow-800 dark:text-yellow-100">
                                {{ __('Demande d\'adhésion en attente') }}
                            </h3>
                            <div class="mt-2 text-sm leading-5 text-yellow-700 dark:text-yellow-200">
                                <p>
                                    {{ __('Vous avez demandé à rejoindre l\'équipe') }} <span class="font-bold">{{ $team->name }}</span>.
                                    {{ __('Vous devez attendre la validation par un administrateur.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 2. BOUTON QUITTER / ANNULER (Avec la nouvelle route custom) --}}
                <div class="flex items-center justify-center p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg border border-gray-200 dark:border-gray-700">
                    <div class="text-center">
                        <div class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                            {{ __('Si vous avez fait une erreur ou ne souhaitez plus rejoindre cette équipe, vous pouvez annuler votre demande.') }}
                        </div>

                        {{-- Formulaire utilisant notre route définie dans web.php --}}
                        <form method="POST" action="{{ route('teams.cancel-request', $team) }}">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                {{ __('Annuler ma demande (Quitter l\'équipe)') }}
                            </button>
                        </form>
                    </div>
                </div>

            @else
                {{-- >>> AFFICHAGE NORMAL <<< --}}

                @livewire('teams.update-team-name-form', ['team' => $team])

                @if (Auth::id() == $team->user_id)
                    <div class="mt-10 sm:mt-0">
                        @livewire('team-join-requests', ['teamId' => $team->id])
                    </div>
                @endif

                <div class="mt-10 sm:mt-0">
                    @livewire('teams.team-member-manager', ['team' => $team])
                </div>

                @if (Gate::check('delete', $team) && ! $team->personal_team)
                    <x-section-border />
                    <div class="mt-10 sm:mt-0">
                        @livewire('teams.delete-team-form', ['team' => $team])
                    </div>
                @endif

            @endif
        </div>
    </div>
</x-app-layout>