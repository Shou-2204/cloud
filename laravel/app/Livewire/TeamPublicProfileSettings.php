<?php

namespace App\Livewire;

use App\Models\Team;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class TeamPublicProfileSettings extends Component
{
    public $team;

    public $state = [];

    /**
     * Mount the component.
     */
    public function mount(Team $team)
    {
        $this->team = $team;
        $this->state = array_merge(
            $team->withoutRelations()->toArray(),
            $team->profile->makeHidden(['id', 'team_id', 'created_at', 'updated_at'])->toArray(),
            $team->settings->makeHidden(['id', 'team_id', 'created_at', 'updated_at'])->toArray()
        );
    }

    /**
     * Update the team public profile information.
     */
    public function updatePublicProfileInformation()
    {
        $this->resetErrorBag();

        Gate::forUser($this->team->owner)->authorize('update', $this->team);

        $validated = $this->validate([
            'state.phone' => ['nullable', 'string', 'max:20'],
            'state.email_public' => ['nullable', 'email', 'max:255'],
            'state.website' => ['nullable', 'url', 'max:255'],
            'state.address' => ['nullable', 'string', 'max:500'],
            'state.social_instagram' => ['nullable', 'url', 'max:255'],
            'state.social_facebook' => ['nullable', 'url', 'max:255'],
            'state.social_tiktok' => ['nullable', 'url', 'max:255'],
            'state.social_linkedin' => ['nullable', 'url', 'max:255'],
            'state.social_twitter' => ['nullable', 'url', 'max:255'],
        ]);

        // Profile Updates
        $this->team->profile()->updateOrCreate([], Arr::only($validated['state'], [
            'phone',
            'email_public',
            'website',
            'address',
            'social_instagram',
            'social_facebook',
            'social_tiktok',
            'social_linkedin',
            'social_twitter',
        ]));

        $this->dispatch('saved');
    }

    public function render()
    {
        return view('livewire.team-public-profile-settings');
    }
}
