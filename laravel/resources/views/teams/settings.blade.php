<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Paramètres de l\'organisation') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Tabs Navigation --}}
            <div class="mb-8 border-b border-gray-200 dark:border-gray-700">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    @foreach($tabs as $key => $label)
                        <a href="{{ route('teams.settings', ['team' => $team->id, 'tab' => $key]) }}"
                           class="{{ $activeTab === $key 
                               ? 'border-emerald-500 text-emerald-600 dark:text-emerald-400' 
                               : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}
                               whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                            {{ $label }}
                        </a>
                    @endforeach
                </nav>
            </div>

            {{-- Content Area --}}
            <div>
                @if($activeTab === 'general')
                    <livewire:team-general-settings :team="$team" />
                @elseif($activeTab === 'public-profile')
                    <livewire:team-public-profile-settings :team="$team" />
                @elseif($activeTab === 'reviews')
                    <livewire:team-review-settings :team="$team" />
                @elseif($activeTab === 'members')
                    <div class="mt-10 sm:mt-0">
                        @if (Gate::check('addTeamMember', $team))
                            <div class="mt-10 sm:mt-0 mb-10">
                                <livewire:team-join-requests :team="$team" />
                            </div>
                        @endif

                        <div class="mt-10 sm:mt-0">
                            @livewire('teams.team-member-manager', ['team' => $team])
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
