<?php

namespace App\Livewire;

use App\Models\WalletPassSetting;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class TeamWalletSettings extends Component
{
    use WithFileUploads;

    public $team;
    public $state = [];

    // File uploads
    public $iconFile = null;
    public $icon2xFile = null;
    public $logoFile = null;
    public $logo2xFile = null;
    public $stripFile = null;
    public $strip2xFile = null;

    public function mount(\App\Models\Team $team)
    {
        $this->team = $team;
        $settings = $team->walletPassSettings;

        $this->state = [
            'label_primary' => $settings->label_primary ?? 'VOS POINTS',
            'label_secondary' => $settings->label_secondary ?? 'CLIENT',
            'foreground_color' => $settings->foreground_color ?? '#FFFFFF',
            'background_color' => $settings->background_color ?? '#282828',
            'label_color' => $settings->label_color ?? '#CCCCCC',
            'logo_text' => $settings->logo_text ?? $team->name,
        ];
    }

    /**
     * Save the wallet pass settings (colors + labels).
     */
    public function save()
    {
        $this->resetErrorBag();

        Gate::forUser($this->team->owner)->authorize('update', $this->team);

        $validated = $this->validate([
            'state.label_primary' => ['required', 'string', 'max:50'],
            'state.label_secondary' => ['required', 'string', 'max:50'],
            'state.foreground_color' => ['required', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'state.background_color' => ['required', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'state.label_color' => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'state.logo_text' => ['nullable', 'string', 'max:30'],
        ]);

        $this->team->walletPassSettings()->updateOrCreate([], $validated['state']);

        $this->dispatch('saved');
    }

    /**
     * Upload an image file for the pass.
     */
    public function uploadImage(string $type)
    {
        Gate::forUser($this->team->owner)->authorize('update', $this->team);

        $propertyMap = [
            'icon' => 'iconFile',
            'icon_2x' => 'icon2xFile',
            'logo' => 'logoFile',
            'logo_2x' => 'logo2xFile',
            'strip' => 'stripFile',
            'strip_2x' => 'strip2xFile',
        ];

        $columnMap = [
            'icon' => 'icon_path',
            'icon_2x' => 'icon_2x_path',
            'logo' => 'logo_image_path',
            'logo_2x' => 'logo_2x_path',
            'strip' => 'strip_path',
            'strip_2x' => 'strip_2x_path',
        ];

        $property = $propertyMap[$type] ?? null;
        $column = $columnMap[$type] ?? null;

        if (!$property || !$column || !$this->{$property}) {
            return;
        }

        $this->validate([
            $property => ['required', 'image', 'mimes:png', 'max:2048'],
        ]);

        $disk = Storage::disk('cloud_public');
        $folder = 'wallet-passes/' . $this->team->id;

        // Delete old file if exists
        $settings = $this->team->walletPassSettings;
        if ($settings->{$column}) {
            $disk->delete($settings->{$column});
        }

        // Store new file
        $filename = $type . '.png';
        $path = $this->{$property}->storeAs($folder, $filename, 'cloud_public');

        $this->team->walletPassSettings()->updateOrCreate([], [
            $column => $path,
        ]);

        $this->{$property} = null;
        $this->team->refresh();

        $this->dispatch('image-uploaded');
    }

    /**
     * Remove a custom image and fall back to default.
     */
    public function removeImage(string $type)
    {
        Gate::forUser($this->team->owner)->authorize('update', $this->team);

        $columnMap = [
            'icon' => 'icon_path',
            'icon_2x' => 'icon_2x_path',
            'logo' => 'logo_image_path',
            'logo_2x' => 'logo_2x_path',
            'strip' => 'strip_path',
            'strip_2x' => 'strip_2x_path',
        ];

        $column = $columnMap[$type] ?? null;
        if (!$column) return;

        $settings = $this->team->walletPassSettings;
        if ($settings->{$column}) {
            Storage::disk('cloud_public')->delete($settings->{$column});
            $settings->update([$column => null]);
        }

        $this->team->refresh();
        $this->dispatch('image-removed');
    }

    /**
     * Reset all settings to defaults.
     */
    public function resetToDefaults()
    {
        Gate::forUser($this->team->owner)->authorize('update', $this->team);

        $this->state = [
            'label_primary' => 'VOS POINTS',
            'label_secondary' => 'CLIENT',
            'foreground_color' => '#FFFFFF',
            'background_color' => '#282828',
            'label_color' => '#CCCCCC',
            'logo_text' => $this->team->name,
        ];

        $this->save();
    }

    public function getSettingsProperty()
    {
        return $this->team->walletPassSettings;
    }

    public function render()
    {
        return view('livewire.team-wallet-settings');
    }
}
