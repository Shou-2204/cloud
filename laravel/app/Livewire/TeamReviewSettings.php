<?php

namespace App\Livewire;

use App\Models\Team;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class TeamReviewSettings extends Component
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
     * Update the team review settings.
     */
    public function updateReviewSettings()
    {
        $this->resetErrorBag();

        Gate::forUser($this->team->owner)->authorize('update', $this->team);

        $validated = $this->validate([
            'state.google_place_id' => ['nullable', 'string', 'max:255'],
            'state.reviews_enabled' => ['boolean'],
            'state.google_review_url' => ['nullable', 'url', 'max:500'],
            'state.review_positive_message' => ['nullable', 'string', 'max:500'],
            'state.review_negative_message' => ['nullable', 'string', 'max:500'],
            'state.feedback_email' => ['nullable', 'email', 'max:255'],
            'state.digest_frequency' => ['nullable', 'in:daily,weekly,monthly,none'],
        ]);

        // Settings Updates
        $this->team->settings()->updateOrCreate([], Arr::only($validated['state'], [
            'google_place_id',
            'reviews_enabled',
            'google_review_url',
            'review_positive_message',
            'review_negative_message',
            'feedback_email',
            'digest_frequency',
        ]));

        $this->dispatch('saved');
    }

    public function render()
    {
        return view('livewire.team-review-settings');
    }
}
