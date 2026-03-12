<?php

namespace App\Services;

use App\Models\CrmContact;
use App\Models\WalletPassSetting;
use Illuminate\Support\Facades\Storage;
use PKPass\PKPass;

class ApplePassService
{
    /**
     * Generate a .pkpass binary for a given CrmContact.
     *
     * Uses the team's WalletPassSetting for customization.
     * Generates wallet_auth_token on first call if not set.
     */
    public function generatePass(CrmContact $contact): string
    {
        $contact->loadMissing('team.walletPassSettings', 'team.profile');

        $team = $contact->team;
        $settings = $team->walletPassSettings;
        $config = config('services.apple_wallet');

        // Ensure wallet_auth_token exists (generated once, never changes)
        if (empty($contact->wallet_auth_token)) {
            $contact->update([
                'wallet_auth_token' => bin2hex(random_bytes(16)),
            ]);
            $contact->refresh();
        }

        $certPath = base_path($config['cert_path']);
        $certPassword = $config['cert_password'];

        $pass = new PKPass($certPath, $certPassword);

        $data = [
            'formatVersion' => 1,
            'passTypeIdentifier' => $config['pass_type_identifier'],
            'serialNumber' => $contact->id, // UUID
            'teamIdentifier' => $config['team_identifier'],
            'groupingIdentifier' => $team->public_uuid,

            'organizationName' => $team->name,
            'description' => 'Carte de fidélité ' . $team->name,
            'logoText' => $settings->logo_text ?: $team->name,

            'foregroundColor' => $this->hexToRgb($settings->foreground_color ?? '#FFFFFF'),
            'backgroundColor' => $this->hexToRgb($settings->background_color ?? '#282828'),

            // Web Service for auto-updates
            'webServiceURL' => rtrim(config('app.url'), '/') . '/api',
            'authenticationToken' => $contact->wallet_auth_token,

            'storeCard' => [
                'primaryFields' => [
                    [
                        'key' => 'points',
                        'label' => $settings->label_primary ?? 'VOS POINTS',
                        'value' => (string) ($contact->loyalty_points ?? 0),
                        'changeMessage' => 'Vous avez maintenant %@ points.',
                    ],
                ],
                'secondaryFields' => [
                    [
                        'key' => 'clientName',
                        'label' => $settings->label_secondary ?? 'CLIENT',
                        'value' => $contact->name ?: 'Client',
                    ],
                ],
            ],

            'barcode' => [
                'format' => 'PKBarcodeFormatQR',
                'message' => $contact->pass_token ?: $contact->id,
                'messageEncoding' => 'iso-8859-1',
            ],
            'barcodes' => [
                [
                    'format' => 'PKBarcodeFormatQR',
                    'message' => $contact->pass_token ?: $contact->id,
                    'messageEncoding' => 'iso-8859-1',
                ],
            ],
        ];

        // Optional label color
        if (!empty($settings->label_color)) {
            $data['labelColor'] = $this->hexToRgb($settings->label_color);
        }

        $pass->setData($data);

        // Add images — prefer team-custom images from R2, fallback to defaults
        $this->addPassImages($pass, $settings);

        $pkpassContent = $pass->create(false);

        if (!$pkpassContent) {
            throw new \RuntimeException('Failed to create .pkpass file. Check certificates and images.');
        }

        return $pkpassContent;
    }

    /**
     * Add images to the pass, preferring custom R2 images over defaults.
     */
    private function addPassImages(PKPass $pass, WalletPassSetting $settings): void
    {
        $disk = Storage::disk('cloud_public');

        // Icon (required)
        if ($settings->icon_path && $disk->exists($settings->icon_path)) {
            $pass->addFileContent($disk->get($settings->icon_path), 'icon.png');
        } elseif (file_exists(public_path('images/wallet/icon.png'))) {
            $pass->addFile(public_path('images/wallet/icon.png'));
        } else {
            throw new \RuntimeException('Missing required icon.png — upload via Wallet settings or place in public/images/wallet/');
        }

        // Icon @2x
        if ($settings->icon_2x_path && $disk->exists($settings->icon_2x_path)) {
            $pass->addFileContent($disk->get($settings->icon_2x_path), 'icon@2x.png');
        } elseif (file_exists(public_path('images/wallet/icon@2x.png'))) {
            $pass->addFile(public_path('images/wallet/icon@2x.png'));
        }

        // Logo
        if ($settings->logo_image_path && $disk->exists($settings->logo_image_path)) {
            $pass->addFileContent($disk->get($settings->logo_image_path), 'logo.png');
        } elseif (file_exists(public_path('images/wallet/logo.png'))) {
            $pass->addFile(public_path('images/wallet/logo.png'));
        }

        // Logo @2x
        if ($settings->logo_2x_path && $disk->exists($settings->logo_2x_path)) {
            $pass->addFileContent($disk->get($settings->logo_2x_path), 'logo@2x.png');
        } elseif (file_exists(public_path('images/wallet/logo@2x.png'))) {
            $pass->addFile(public_path('images/wallet/logo@2x.png'));
        }

        // Strip (background image behind primary fields)
        if ($settings->strip_path && $disk->exists($settings->strip_path)) {
            $pass->addFileContent($disk->get($settings->strip_path), 'strip.png');
        } elseif (file_exists(public_path('images/wallet/strip.png'))) {
            $pass->addFile(public_path('images/wallet/strip.png'));
        }

        // Strip @2x
        if ($settings->strip_2x_path && $disk->exists($settings->strip_2x_path)) {
            $pass->addFileContent($disk->get($settings->strip_2x_path), 'strip@2x.png');
        } elseif (file_exists(public_path('images/wallet/strip@2x.png'))) {
            $pass->addFile(public_path('images/wallet/strip@2x.png'));
        }
    }

    /**
     * Convert hex color (#FFFFFF) to Apple pass rgb() format.
     */
    private function hexToRgb(string $hex): string
    {
        $hex = ltrim($hex, '#');

        if (strlen($hex) === 3) {
            $hex = $hex[0].$hex[0] . $hex[1].$hex[1] . $hex[2].$hex[2];
        }

        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        return "rgb($r, $g, $b)";
    }
}
