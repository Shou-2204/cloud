<?php

namespace App\Livewire;

use App\Models\Team;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class TeamProfileSettings extends Component
{
    use WithFileUploads;

    public $team;

    public $state = [];

    public $logo;

    public $cover;

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
     * Update the team profile information.
     */
    public function updateProfileInformation()
    {
        $this->resetErrorBag();

        Gate::forUser($this->team->owner)->authorize('update', $this->team);

        $validated = $this->validate([
            'state.tagline' => ['nullable', 'string', 'max:255'],
            'state.bio' => ['nullable', 'string', 'max:1000'],
            'state.phone' => ['nullable', 'string', 'max:20'],
            'state.email_public' => ['nullable', 'email', 'max:255'],
            'state.website' => ['nullable', 'url', 'max:255'],
            'state.address' => ['nullable', 'string', 'max:500'],
            'state.social_instagram' => ['nullable', 'url', 'max:255'],
            'state.social_facebook' => ['nullable', 'url', 'max:255'],
            'state.social_tiktok' => ['nullable', 'url', 'max:255'],
            'state.social_linkedin' => ['nullable', 'url', 'max:255'],
            'state.social_twitter' => ['nullable', 'url', 'max:255'],
            'state.google_place_id' => ['nullable', 'string', 'max:255'],
            'state.reviews_enabled' => ['boolean'],
            'state.google_review_url' => ['nullable', 'url', 'max:500'],
            'state.review_positive_message' => ['nullable', 'string', 'max:500'],
            'state.review_negative_message' => ['nullable', 'string', 'max:500'],
            'state.feedback_email' => ['nullable', 'email', 'max:255'],
            'state.digest_frequency' => ['nullable', 'in:daily,weekly,monthly,none'],
            'logo' => ['nullable', 'image', 'max:2048'], // 2MB Max
            'cover' => ['nullable', 'image', 'max:4096'], // 4MB Max
        ]);

        if (isset($this->logo)) {
            $this->team->profile()->updateOrCreate([], [
                'logo_path' => $this->logo->storePublicly('team-logos', ['disk' => 'cloud_public']),
            ]);
        }

        if (isset($this->cover)) {
            $this->team->profile()->updateOrCreate([], [
                'cover_image_path' => $this->cover->storePublicly('team-covers', ['disk' => 'cloud_public']),
            ]);
        }

        // Profile Updates
        $this->team->profile()->updateOrCreate([], Arr::only($validated['state'], [
            'tagline',
            'bio',
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

    /**
     * Delete the team's logo.
     */
    public function deleteLogo()
    {
        Gate::forUser($this->team->owner)->authorize('update', $this->team);

        if ($this->team->profile->logo_path) {
            Storage::disk('cloud_public')->delete($this->team->profile->logo_path);
            $this->team->profile()->update(['logo_path' => null]);
        }

        $this->state['logo_path'] = null;
    }

    /**
     * Delete the team's cover image.
     */
    public function deleteCover()
    {
        Gate::forUser($this->team->owner)->authorize('update', $this->team);

        if ($this->team->profile->cover_image_path) {
            Storage::disk('cloud_public')->delete($this->team->profile->cover_image_path);
            $this->team->profile()->update(['cover_image_path' => null]);
        }

        $this->state['cover_image_path'] = null;
    }

    public function render()
    {
        return view('livewire.team-profile-settings');
    }
}
