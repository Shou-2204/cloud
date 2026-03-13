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
        $contact->loadMissing('team.walletPassSettings', 'team.profile', 'team.settings', 'team.loyaltyRewards');

        $team = $contact->team;
        $settings = $team->walletPassSettings;
        $profile = $team->profile;
        $teamSettings = $team->settings;
        $config = config('services.apple_wallet');

        if (empty($contact->wallet_auth_token)) {
            $contact->update(['wallet_auth_token' => bin2hex(random_bytes(16))]);
            $contact->refresh();
        }

        $certPath = base_path($config['cert_path']);
        $pass = new PKPass($certPath, $config['cert_password']);

        // --- Récompenses ---
        $auxiliaryFields = [];
        $currentPoints = $contact->loyalty_points ?? 0;

        $nextReward = $team->loyaltyRewards
            ->where('points_required', '>', $currentPoints)
            ->sortBy('points_required')
            ->first();

        $lastReward = $team->loyaltyRewards
            ->where('points_required', '<=', $currentPoints)
            ->sortByDesc('points_required')
            ->first();

        if ($nextReward) {
            $remaining = $nextReward->points_required - $currentPoints;
            $unit = ($teamSettings->loyalty_program_type === 'visits') ? 'visites' : 'pts';
            $auxiliaryFields[] = [
                'key' => 'nextReward',
                'label' => '🎁 Prochaine récompense',
                'value' => $nextReward->name . ' — encore ' . $remaining . ' ' . $unit,
            ];
        }
        elseif ($lastReward) {
            $auxiliaryFields[] = [
                'key' => 'nextReward',
                'label' => '🎁 Récompense débloquée',
                'value' => $lastReward->name,
            ];
        }

        $backFields = $this->buildBackFields($profile, $teamSettings);

        $data = [
            'formatVersion' => 1,
            'passTypeIdentifier' => $config['pass_type_identifier'],
            'serialNumber' => $contact->id,
            'teamIdentifier' => $config['team_identifier'],
            'groupingIdentifier' => $team->public_uuid,
            'organizationName' => $team->name,
            'description' => 'Carte de fidélité ' . $team->name,
            'logoText' => $settings->logo_text ?: $team->name,
            'foregroundColor' => $this->hexToRgb($settings->foreground_color ?? '#FFFFFF'),
            'backgroundColor' => $this->hexToRgb($settings->background_color ?? '#282828'),
            'webServiceURL' => rtrim(config('app.url'), '/') . '/api',
            'authenticationToken' => $contact->wallet_auth_token,
            'storeCard' => [
                'headerFields' => [
                    [
                        'key' => 'clientName',
                        'label' => $settings->label_secondary ?? 'CLIENT',
                        'value' => $contact->name ?: 'Client',
                    ],
                ],
                'primaryFields' => [],
                'secondaryFields' => [
                    [
                        'key' => 'points',
                        'label' => $settings->label_primary ?? 'VOS POINTS',
                        'value' => (string)$currentPoints,
                        'changeMessage' => 'Vous avez maintenant %@ points.',
                    ],
                ],
                'auxiliaryFields' => $auxiliaryFields,
                'backFields' => $backFields,
            ],
            'barcode' => [
                'format' => 'PKBarcodeFormatQR',
                'message' => $contact->pass_token ?: $contact->id,
                'messageEncoding' => 'iso-8859-1',
                'altText' => $contact->pass_token,
            ],
            'barcodes' => [
                [
                    'format' => 'PKBarcodeFormatQR',
                    'message' => $contact->pass_token ?: $contact->id,
                    'messageEncoding' => 'iso-8859-1',
                    'altText' => $contact->pass_token,
                ],
            ],
        ];

        if (!empty($settings->label_color)) {
            $data['labelColor'] = $this->hexToRgb($settings->label_color);
        }

        $pass->setData($data);
        $this->addPassImages($pass, $settings);

        $pkpassContent = $pass->create(false);

        if (!$pkpassContent) {
            throw new \RuntimeException('Failed to create .pkpass file.');
        }

        return $pkpassContent;
    }

    /**
     * Build the back-of-card fields from team profile and loyalty settings.
     */
    private function buildBackFields($profile, $teamSettings): array
    {
        $backFields = [];

        // Programme type
        if (!empty($teamSettings->loyalty_program_type)) {
            $typeLabel = $teamSettings->loyalty_program_type === 'visits'
                ? 'Visites (1 passage = 1 pt)'
                : 'Points (selon le montant)';
            $backFields[] = [
                'key' => 'programType',
                'label' => 'Programme',
                'value' => $typeLabel,
            ];
        }

        // Points expiration
        if ($teamSettings->loyalty_points_expire) {
            if (!empty($teamSettings->loyalty_points_next_expiration)) {
                $expirationDate = \Carbon\Carbon::parse($teamSettings->loyalty_points_next_expiration);
                $expiryText = 'Vos points expirent le ' . $expirationDate->translatedFormat('d F Y');
            }
            elseif (!empty($teamSettings->loyalty_points_expiration_date)) {
                $expiryText = 'Expiration annuelle le ' . $teamSettings->loyalty_points_expiration_date;
            }
            else {
                $expiryText = 'Vos points ont une durée limitée';
            }
            $backFields[] = [
                'key' => 'pointsExpiry',
                'label' => 'Expiration',
                'value' => $expiryText,
            ];
        }
        else {
            $backFields[] = [
                'key' => 'pointsExpiry',
                'label' => 'Expiration',
                'value' => 'Vos points n\'expirent pas ✨',
            ];
        }

        // Address
        if (!empty($profile->address)) {
            $backFields[] = [
                'key' => 'address',
                'label' => 'Adresse',
                'value' => $profile->address,
            ];
        }

        // Phone (clickable)
        if (!empty($profile->phone)) {
            $cleanPhone = preg_replace('/\s+/', '', $profile->phone);
            $backFields[] = [
                'key' => 'phone',
                'label' => 'Téléphone',
                'value' => $profile->phone,
                'attributedValue' => '<a href="tel:' . $cleanPhone . '">' . $profile->phone . '</a>',
            ];
        }

        // Website (clickable)
        if (!empty($profile->website)) {
            $url = $profile->website;
            if (!str_starts_with($url, 'http')) {
                $url = 'https://' . $url;
            }
            $backFields[] = [
                'key' => 'website',
                'label' => 'Site web',
                'value' => $profile->website,
                'attributedValue' => '<a href="' . $url . '">' . $profile->website . '</a>',
            ];
        }

        // Email (clickable)
        if (!empty($profile->email_public)) {
            $backFields[] = [
                'key' => 'email',
                'label' => 'Email',
                'value' => $profile->email_public,
                'attributedValue' => '<a href="mailto:' . $profile->email_public . '">' . $profile->email_public . '</a>',
            ];
        }

        // Social networks (clickable)
        $socials = [
            'instagram' => ['field' => 'social_instagram', 'label' => 'Instagram', 'prefix' => 'https://instagram.com/'],
            'facebook' => ['field' => 'social_facebook', 'label' => 'Facebook', 'prefix' => 'https://facebook.com/'],
            'tiktok' => ['field' => 'social_tiktok', 'label' => 'TikTok', 'prefix' => 'https://tiktok.com/@'],
            'linkedin' => ['field' => 'social_linkedin', 'label' => 'LinkedIn', 'prefix' => 'https://linkedin.com/in/'],
            'twitter' => ['field' => 'social_twitter', 'label' => 'X (Twitter)', 'prefix' => 'https://x.com/'],
        ];

        foreach ($socials as $key => $meta) {
            $value = $profile->{ $meta['field']} ?? null;
            if (!empty($value)) {
                // If the value is already a full URL, use it; otherwise prepend prefix
                $url = str_starts_with($value, 'http') ? $value : $meta['prefix'] . ltrim($value, '@/');
                $backFields[] = [
                    'key' => $key,
                    'label' => $meta['label'],
                    'value' => $value,
                    'attributedValue' => '<a href="' . $url . '">' . $value . '</a>',
                ];
            }
        }

        return $backFields;
    }

    /**
     * Add images to the pass, preferring custom R2 images over defaults.
     */
    private function addPassImages(PKPass $pass, WalletPassSetting $settings): void
    {
        $disk = Storage::disk('cloud_public');

        // --- ICON (Used in notifications and on the pass) ---
        if ($settings->icon_path && $disk->exists($settings->icon_path)) {
            $iconContent = $disk->get($settings->icon_path);
            $pass->addFileContent($iconContent, 'icon.png');
            
            // Fallback for @2x and @3x: use the main icon if high-res versions weren't uploaded
            if ($settings->icon_2x_path && $disk->exists($settings->icon_2x_path)) {
                $pass->addFileContent($disk->get($settings->icon_2x_path), 'icon@2x.png');
            } else {
                $pass->addFileContent($iconContent, 'icon@2x.png');
                $pass->addFileContent($iconContent, 'icon@3x.png');
            }
        } else {
            // Extreme fallback to system defaults
            if (file_exists(public_path('images/wallet/icon.png'))) {
                $pass->addFile(public_path('images/wallet/icon.png'));
            }
            if (file_exists(public_path('images/wallet/icon@2x.png'))) {
                $pass->addFile(public_path('images/wallet/icon@2x.png'));
            }
        }

        // --- LOGO (Top left of the pass) ---
        if ($settings->logo_image_path && $disk->exists($settings->logo_image_path)) {
            $logoContent = $disk->get($settings->logo_image_path);
            $pass->addFileContent($logoContent, 'logo.png');

            if ($settings->logo_2x_path && $disk->exists($settings->logo_2x_path)) {
                $pass->addFileContent($disk->get($settings->logo_2x_path), 'logo@2x.png');
            } else {
                $pass->addFileContent($logoContent, 'logo@2x.png');
                $pass->addFileContent($logoContent, 'logo@3x.png');
            }
        } elseif (file_exists(public_path('images/wallet/logo.png'))) {
            $pass->addFile(public_path('images/wallet/logo.png'));
            if (file_exists(public_path('images/wallet/logo@2x.png'))) {
                $pass->addFile(public_path('images/wallet/logo@2x.png'));
            }
        }

        // --- STRIP (Background image) ---
        if ($settings->strip_path && $disk->exists($settings->strip_path)) {
            $stripContent = $disk->get($settings->strip_path);
            $pass->addFileContent($stripContent, 'strip.png');

            if ($settings->strip_2x_path && $disk->exists($settings->strip_2x_path)) {
                $pass->addFileContent($disk->get($settings->strip_2x_path), 'strip@2x.png');
            } else {
                $pass->addFileContent($stripContent, 'strip@2x.png');
                $pass->addFileContent($stripContent, 'strip@3x.png');
            }
        } elseif (file_exists(public_path('images/wallet/strip.png'))) {
            $pass->addFile(public_path('images/wallet/strip.png'));
            if (file_exists(public_path('images/wallet/strip@2x.png'))) {
                $pass->addFile(public_path('images/wallet/strip@2x.png'));
            }
        }
    }

    /**
     * Convert hex color (#FFFFFF) to Apple pass rgb() format.
     */
    private function hexToRgb(string $hex): string
    {
        $hex = ltrim($hex, '#');

        if (strlen($hex) === 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }

        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        return "rgb($r, $g, $b)";
    }
}