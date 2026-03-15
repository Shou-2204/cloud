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

    public \App\Models\Team $team;
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
            'label_primary' => 'VOS POINTS',
            'label_secondary' => 'TITULAIRE',
            'foreground_color' => $settings->foreground_color ?? '#FFFFFF',
            'background_color' => $settings->background_color ?? '#282828',
            'label_color' => $settings->label_color ?? '#CCCCCC',
            'logo_text' => $settings->logo_text ?? $this->team->name,
            'latitude' => $settings->latitude,
            'longitude' => $settings->longitude,
            'relevant_text' => $settings->relevant_text,
        ];
    }

    /**
     * Save the wallet pass settings (colors + labels + geofencing).
     */
    public function save()
    {
        $this->resetErrorBag();

        Gate::forUser($this->team->owner)->authorize('update', $this->team);

        $this->state['label_primary'] = 'VOS POINTS';
        $this->state['label_secondary'] = 'TITULAIRE';

        $validated = $this->validate([
            'state.label_primary' => ['required', 'string', 'max:50'],
            'state.label_secondary' => ['required', 'string', 'max:50'],
            'state.foreground_color' => ['required', 'string', 'regex:/^#[0-9A-Fa-f]{3,6}$/'],
            'state.background_color' => ['required', 'string', 'regex:/^#[0-9A-Fa-f]{3,6}$/'],
            'state.label_color' => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{3,6}$/'],
            'state.logo_text' => ['nullable', 'string', 'max:30'],
            'state.latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'state.longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'state.relevant_text' => ['nullable', 'string', 'max:255'],
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

        // Ensure settings exist
        $settings = $this->team->walletPassSettings()->firstOrCreate([]);

        // Delete old file if exists
        if ($settings->{$column}) {
            $disk->delete($settings->{$column});
        }

        // Store new file
        $filename = $type . '.png';
        $path = $this->{$property}->storeAs($folder, $filename, 'cloud_public');

        $updateData = [$column => $path];

        // When uploading icon, also save as logo (same image for both)
        if ($type === 'icon') {
            if ($settings->logo_image_path) {
                $disk->delete($settings->logo_image_path);
            }
            $logoPath = $folder . '/logo.png';
            $disk->copy($path, $logoPath);
            $updateData['logo_image_path'] = $logoPath;
        }

        $settings = $this->team->walletPassSettings()->updateOrCreate([], $updateData);
        $settings->touch(); // Force updated_at refresh for cache-busting preview

        $this->{$property} = null;
        $this->team->refresh();

        $this->dispatch('image-uploaded');
        $this->dispatch('saved');
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
            $settings->touch();
        }

        $this->team->refresh();
        $this->dispatch('image-removed');
        $this->dispatch('saved');
    }

    /**
     * Set a predefined color theme.
     */
    public function setTheme(string $theme)
    {
        Gate::forUser($this->team->owner)->authorize('update', $this->team);

        $themes = [
            'midnight' => ['bg' => '#000000', 'fg' => '#FFFFFF', 'label' => '#A1A1AA'],
            'gold'     => ['bg' => '#1A1A1A', 'fg' => '#D4AF37', 'label' => '#C5A028'],
            'blue'     => ['bg' => '#002B5B', 'fg' => '#FFFFFF', 'label' => '#3CCF4E'],
            'white'    => ['bg' => '#F8FAFC', 'fg' => '#0F172A', 'label' => '#64748B'],
            'crimson'  => ['bg' => '#7F1D1D', 'fg' => '#FFFFFF', 'label' => '#FCA5A5'],
        ];

        if (isset($themes[$theme])) {
            $this->state['background_color'] = $themes[$theme]['bg'];
            $this->state['foreground_color'] = $themes[$theme]['fg'];
            $this->state['label_color'] = $themes[$theme]['label'];
            $this->save();
        }
    }

    /**
     * Reset all settings to defaults.
     */
    public function resetToDefaults()
    {
        Gate::forUser($this->team->owner)->authorize('update', $this->team);

        $this->state = [
            'label_primary' => 'VOS POINTS',
            'label_secondary' => 'TITULAIRE',
            'foreground_color' => '#FFFFFF',
            'background_color' => '#000000',
            'label_color' => '#A1A1AA',
            'logo_text' => $this->team->name,
        ];

        $this->save();
    }

    public function getSettingsProperty()
    {
        return $this->team->walletPassSettings;
    }

    public function getGoogleWalletEnabledProperty(): bool
    {
        return app(\App\Services\GoogleWalletService::class)->isEnabled();
    }

    public function getGoogleWalletPreviewUrlProperty(): ?string
    {
        if (!$this->googleWalletEnabled) {
            return null;
        }

        $contact = \App\Models\CrmContact::where('team_id', $this->team->id)->first();
        if (!$contact) {
            return null;
        }

        return route('wallet.google-pass', $contact);
    }

    public function updated($name, $value)
    {
        // Force refresh for preview
    }

    public function render()
    {
        return view('livewire.team-wallet-settings');
    }
}
