<?php

namespace App\Services;

use App\Models\CrmContact;
use App\Models\Team;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GoogleWalletService
{
    private const API_BASE = 'https://walletobjects.googleapis.com/walletobjects/v1';

    private ?array $serviceAccountKey = null;
    private ?string $accessToken = null;

    /**
     * Check if Google Wallet is configured (ISSUER_ID present).
     */
    public function isEnabled(): bool
    {
        return !empty(config('services.google_wallet.issuer_id'));
    }

    /**
     * Create or update the LoyaltyClass for a team.
     *
     * @return string The class ID
     */
    public function createOrUpdateClass(Team $team): string
    {
        if (!$this->isEnabled()) {
            throw new \RuntimeException('Google Wallet is not configured.');
        }

        $issuerId = config('services.google_wallet.issuer_id');
        $classId = "{$issuerId}.{$team->public_uuid}";

        $team->loadMissing('walletPassSettings', 'profile');
        $settings = $team->walletPassSettings;

        // Build logo URL from R2 public storage
        $logoUrl = null;
        if ($settings?->icon_path) {
            $logoUrl = Storage::disk('cloud_public')->url($settings->icon_path);
        }

        $classPayload = [
            'id' => $classId,
            'issuerName' => $team->name,
            'programName' => $settings?->logo_text ?: 'Ma Fidélité',
            'reviewStatus' => 'UNDER_REVIEW',
            'hexBackgroundColor' => $settings?->background_color ?? '#282828',
            'loyaltyPointsLabel' => 'VOS POINTS',
        ];
        if ($settings?->latitude && $settings?->longitude) {
            $classPayload['locations'] = [
                [
                    'latitude' => (float) $settings->latitude,
                    'longitude' => (float) $settings->longitude,
                ]
        ];
    }

        // Banner (Bandeau Google)
        $heroImage = null;
        if ($settings?->strip_path) {
            $heroImage = Storage::disk('cloud_public')->url($settings->strip_path);
        }

        if ($logoUrl) {
            $classPayload['programLogo'] = [
                'sourceUri' => [
                    'uri' => $logoUrl,
                    'description' => $team->name . ' Logo',
                ],
            ];
        }

        if ($heroImage) {
            $classPayload['heroImage'] = [
                'sourceUri' => [
                    'uri' => $heroImage,
                    'description' => $team->name . ' Banner',
                ],
            ];
        }

        // Try to create, if 409 → update
        $response = $this->apiRequest('POST', '/loyaltyClass', $classPayload);

        if ($response['httpCode'] === 409) {
            // Already exists, update via PUT
            $response = $this->apiRequest('PUT', "/loyaltyClass/{$classId}", $classPayload);
        }

        if ($response['httpCode'] >= 400) {
            Log::error('GoogleWalletService: Failed to create/update class', [
                'class_id' => $classId,
                'http_code' => $response['httpCode'],
                'body' => $response['body'],
            ]);
            throw new \RuntimeException('Failed to create/update Google Wallet class: ' . ($response['body']['message'] ?? 'Unknown error'));
        }

        // Store the class ID on the team's settings
        if ($settings) {
            $settings->update([
                'google_wallet_class_id' => $classId,
                'google_class_synced_at' => now(),
            ]);
        }

        return $classId;
    }

    /**
     * Create or update a LoyaltyObject for a contact.
     *
     * @return string The object ID
     */
    public function createOrUpdateObject(CrmContact $contact): string
    {
        if (!$this->isEnabled()) {
            throw new \RuntimeException('Google Wallet is not configured.');
        }

        $contact->loadMissing('team.walletPassSettings');

        $issuerId = config('services.google_wallet.issuer_id');
        $classId = "{$issuerId}.{$contact->team->public_uuid}";
        $objectId = "{$issuerId}.{$contact->id}";

        // Calculate next reward for the text module
        $contact->team->loadMissing('settings', 'loyaltyRewards');
        $programType = $contact->team->settings->loyalty_program_type ?? 'points';
        $rewards = $contact->team->loyaltyRewards;

        $progress = \App\Services\LoyaltyProgressService::getProgress($contact, $programType, $rewards);
        $nextRewardText = 'Aucune récompense';
        if (!empty($progress['next_reward'])) {
            $diff = $progress['next_reward']['points_remaining'];
            $nextRewardText = "{$progress['next_reward']['name']} dans {$diff} " . $progress['unit_label'];
        }

        $objectPayload = [
            'id' => $objectId,
            'classId' => $classId,
            'state' => 'ACTIVE',
            'accountId' => $contact->pass_token,
            'accountName' => $contact->name ?: 'Client',
            'barcode' => [
                'type' => 'QR_CODE',
                'value' => $contact->pass_token ?: (string) $contact->id,
                'alternateText' => $contact->pass_token ?: (string) $contact->id,
            ],
            'textModulesData' => [
                [
                    'header' => 'Prochaine récompense',
                    'body' => $nextRewardText,
                    'id' => 'next_reward',
                ]
            ],
            'loyaltyPoints' => [
                'label' => 'VOS POINTS', // ← label sur l'objet aussi
                'balance' => [
                    'int' => (int) ($contact->loyalty_points ?? 0),
                ],
            ],

        ];
        
         //Geofencing
        if ($contact->team->walletPassSettings?->relevant_text) {
            $objectPayload['notifications'] = [
                'upcomingNotification' => [
                    'enableNotification' => true,
                ]
            ];
        }
        // Try to create, if 409 → update
        $response = $this->apiRequest('POST', '/loyaltyObject', $objectPayload);

        if ($response['httpCode'] === 409) {
            $response = $this->apiRequest('PATCH', "/loyaltyObject/{$objectId}", $objectPayload);
        }

        if ($response['httpCode'] >= 400) {
            Log::error('GoogleWalletService: Failed to create/update object', [
                'object_id' => $objectId,
                'http_code' => $response['httpCode'],
                'body' => $response['body'],
            ]);
            throw new \RuntimeException('Failed to create/update Google Wallet object.');
        }

        return $objectId;
    }

    /**
     * Generate an "Add to Google Wallet" URL with a signed JWT.
     */
    public function generateAddToWalletUrl(CrmContact $contact): string
    {
        $issuerId = config('services.google_wallet.issuer_id');
        $objectId = "{$issuerId}.{$contact->id}";
        $key = $this->getServiceAccountKey();

        $header = [
            'alg' => 'RS256',
            'typ' => 'JWT',
        ];

        $payload = [
            'iss' => $key['client_email'],
            'aud' => 'google',
            'typ' => 'savetowallet',
            'iat' => time(),
            'payload' => [
                'loyaltyObjects' => [
                    ['id' => $objectId],
                ],
            ],
        ];

        $jwt = $this->signJwt($header, $payload, $key['private_key']);

        return "https://pay.google.com/gp/v/save/{$jwt}";
    }

    /**
     * Update only the loyalty points for a contact's existing object.
     */
    public function updatePoints(CrmContact $contact): void
    {
        if (!$this->isEnabled()) {
            return;
        }

        $issuerId = config('services.google_wallet.issuer_id');
        $objectId = "{$issuerId}.{$contact->id}";

        $contact->loadMissing('team.settings', 'team.loyaltyRewards');
        $programType = $contact->team->settings->loyalty_program_type ?? 'points';
        $rewards = $contact->team->loyaltyRewards;

        $progress = \App\Services\LoyaltyProgressService::getProgress($contact, $programType, $rewards);
        $nextRewardText = 'Aucune récompense';
        if (!empty($progress['next_reward'])) {
            $diff = $progress['next_reward']['points_remaining'];
            $nextRewardText = "{$progress['next_reward']['name']} dans {$diff} " . $progress['unit_label'];
        }

        $patchPayload = [
            'loyaltyPoints' => [
                'label' => 'VOS POINTS',
                'balance' => [
                    'int' => (int) ($contact->loyalty_points ?? 0),
                ],
            ],
            'textModulesData' => [
                [
                    'header' => 'Prochaine récompense',
                    'body' => $nextRewardText,
                    'id' => 'next_reward',
                ]
            ],
        ];

        $response = $this->apiRequest('PATCH', "/loyaltyObject/{$objectId}", $patchPayload);

        // 404 = object doesn't exist yet (user never added to Google Wallet), skip silently
        if ($response['httpCode'] === 404) {
            return;
        }

        if ($response['httpCode'] >= 400) {
            Log::warning('GoogleWalletService: Failed to update points', [
                'object_id' => $objectId,
                'http_code' => $response['httpCode'],
                'body' => $response['body'],
            ]);
        }
    }

    // ========================================================================
    // Private Helpers
    // ========================================================================

    /**
     * Make an authenticated API request to Google Wallet API.
     */
    private function apiRequest(string $method, string $endpoint, array $payload): array
    {
        $url = self::API_BASE . $endpoint;
        $token = $this->getAccessToken();

        $ch = curl_init();

        $headers = [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json',
        ];

        $curlOpts = [
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
        ];

        switch ($method) {
            case 'POST':
                $curlOpts[CURLOPT_POST] = true;
                $curlOpts[CURLOPT_POSTFIELDS] = json_encode($payload);
                break;
            case 'PUT':
                $curlOpts[CURLOPT_CUSTOMREQUEST] = 'PUT';
                $curlOpts[CURLOPT_POSTFIELDS] = json_encode($payload);
                break;
            case 'PATCH':
                $curlOpts[CURLOPT_CUSTOMREQUEST] = 'PATCH';
                $curlOpts[CURLOPT_POSTFIELDS] = json_encode($payload);
                break;
        }

        curl_setopt_array($ch, $curlOpts);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            Log::error('GoogleWalletService: cURL error', ['error' => $curlError, 'url' => $url]);
            return ['httpCode' => 0, 'body' => ['error' => $curlError]];
        }

        return [
            'httpCode' => $httpCode,
            'body' => json_decode($response, true) ?? [],
        ];
    }

    /**
     * Get an OAuth2 access token using the service account JWT.
     */
    private function getAccessToken(): string
    {
        return cache()->remember('google_wallet_access_token', 3500, function () {
            $key = $this->getServiceAccountKey();

            $header = ['alg' => 'RS256', 'typ' => 'JWT'];

            $now = time();
            $payload = [
                'iss' => $key['client_email'],
                'scope' => 'https://www.googleapis.com/auth/wallet_object.issuer',
                'aud' => 'https://oauth2.googleapis.com/token',
                'iat' => $now,
                'exp' => $now + 3600,
            ];

            $jwt = $this->signJwt($header, $payload, $key['private_key']);

            // Exchange JWT for access token
            $ch = curl_init('https://oauth2.googleapis.com/token');
            curl_setopt_array($ch, [
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => http_build_query([
                    'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                    'assertion' => $jwt,
                ]),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 15,
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $data = json_decode($response, true);

            if ($httpCode !== 200 || empty($data['access_token'])) {
                Log::error('GoogleWalletService: Failed to get access token', [
                    'http_code' => $httpCode,
                    'response' => $data,
                ]);
                throw new \RuntimeException('Failed to authenticate with Google Wallet API.');
            }

            return $data['access_token'];
        });
    }

    /**
     * Load the service account JSON key file.
     */
    private function getServiceAccountKey(): array
    {
        if ($this->serviceAccountKey) {
            return $this->serviceAccountKey;
        }

        $keyPath = base_path(config('services.google_wallet.key_path'));

        if (!file_exists($keyPath)) {
            throw new \RuntimeException("Google Wallet service account key not found at: {$keyPath}");
        }

        $this->serviceAccountKey = json_decode(file_get_contents($keyPath), true);

        if (!$this->serviceAccountKey || empty($this->serviceAccountKey['private_key'])) {
            throw new \RuntimeException('Invalid Google Wallet service account key.');
        }

        return $this->serviceAccountKey;
    }

    /**
     * Sign a JWT using RS256 with openssl_sign().
     */
    private function signJwt(array $header, array $payload, string $privateKey): string
    {
        $headerEncoded = $this->base64UrlEncode(json_encode($header));
        $payloadEncoded = $this->base64UrlEncode(json_encode($payload));

        $dataToSign = "{$headerEncoded}.{$payloadEncoded}";

        $success = openssl_sign($dataToSign, $signature, $privateKey, OPENSSL_ALGO_SHA256);

        if (!$success) {
            throw new \RuntimeException('Failed to sign JWT: ' . openssl_error_string());
        }

        return "{$dataToSign}." . $this->base64UrlEncode($signature);
    }

    /**
     * Base64url encode (RFC 4648 §5).
     */
    private function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
}