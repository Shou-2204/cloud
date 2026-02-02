<?php

namespace App\Livewire;

use App\Models\Team;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class TeamGeneralSettings extends Component
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
        $this->state = array_merge([
            'name' => $team->name,
            'tagline' => null,
            'bio' => null,
            'logo_path' => null,
            'cover_image_path' => null,
        ], $team->withoutRelations()->toArray(), $team->profile->makeHidden(['id', 'team_id', 'created_at', 'updated_at'])->toArray());
    }

    /**
     * Update the team general information.
     */
    public function updateGeneralInformation()
    {
        $this->resetErrorBag();

        Gate::forUser($this->team->owner)->authorize('update', $this->team);

        $validated = $this->validate([
            'state.name' => ['required', 'string', 'max:255'],
            'state.tagline' => ['nullable', 'string', 'max:255'],
            'state.bio' => ['nullable', 'string', 'max:1000'],
            'logo' => ['nullable', 'image', 'max:2048'], // 2MB Max
            'cover' => ['nullable', 'image', 'max:4096'], // 4MB Max
        ]);

        $this->team->update(['name' => $validated['state']['name']]);

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
        return view('livewire.team-general-settings');
    }
}
