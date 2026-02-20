<?php

namespace App\Livewire;

use Livewire\Component;

class TeamLoyaltySettings extends Component
{
    public $team;

    public $state = [];

    /**
     * Mount the component.
     */
    public function mount(\App\Models\Team $team)
    {
        $this->team = $team;
        $this->state = [
            'loyalty_enabled' => $team->settings->loyalty_enabled ?? false,
        ];
    }

    /**
     * Update the team loyalty settings.
     */
    public function updateLoyaltySettings()
    {
        $this->resetErrorBag();

        \Illuminate\Support\Facades\Gate::forUser($this->team->owner)->authorize('update', $this->team);

        $validated = $this->validate([
            'state.loyalty_enabled' => ['boolean'],
        ]);

        // Settings Updates
        $this->team->settings()->updateOrCreate([], \Illuminate\Support\Arr::only($validated['state'], [
            'loyalty_enabled',
        ]));

        $this->dispatch('saved');
    }

    public function render()
    {
        return view('livewire.team-loyalty-settings');
    }
}
