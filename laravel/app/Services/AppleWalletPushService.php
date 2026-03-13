<?php

namespace App\Services;

use App\Models\CrmContact;
use App\Models\WalletRegistration;

class AppleWalletPushService
{
    /**
     * Send an empty push notification to all devices registered for this contact's pass.
     *
     * Apple Wallet expects a completely EMPTY push body (no JSON, no aps key).
     * This is fundamentally different from regular APNs pushes, so we use raw cURL/HTTP2
     * instead of the Pushok library (which always injects an "aps" key).
     *
     * Flow:
     * 1. Device receives empty push
     * 2. Device calls GET /api/v1/devices/{deviceId}/registrations/{passTypeId} to get updated serials
     * 3. Device calls GET /api/v1/passes/{passTypeId}/{serial} to get the new .pkpass
     */
    public function notifyDevicesForContact(CrmContact $contact): void
    {
        $config = config('services.apple_wallet');
        $passTypeId = $config['pass_type_identifier'];

        // Find all device registrations for this contact's pass
        $registrations = WalletRegistration::where('pass_type_identifier', $passTypeId)
            ->where('serial_number', $contact->id)
            ->with('device')
            ->get();

        if ($registrations->isEmpty()) {
            \Log::info('AppleWalletPushService: No registrations found for contact ' . $contact->id);
            return;
        }

        // Load the certificate and key for APNs
        $certPath = base_path($config['push_cert_path']);
        $keyPath = base_path($config['push_key_path']);

        if (!file_exists($certPath) || !file_exists($keyPath)) {
            \Log::warning('AppleWalletPushService: Push certificate or key not found.', [
                'cert_path' => $certPath,
                'key_path' => $keyPath,
            ]);
            return;
        }

        // Create a temporary combined PEM file (cert + key) for cURL
        $combinedPemPath = tempnam(sys_get_temp_dir(), 'apns_wallet_');
        $combinedContent = file_get_contents($certPath) . "\n" . file_get_contents($keyPath);
        file_put_contents($combinedPemPath, $combinedContent);

        $successCount = 0;
        $failCount = 0;

        foreach ($registrations as $registration) {
            $device = $registration->device;
            if (!$device || empty($device->push_token)) {
                continue;
            }

            try {
                $result = $this->sendEmptyPush($device->push_token, $combinedPemPath);
                if ($result) {
                    $successCount++;
                } else {
                    $failCount++;
                }
            } catch (\Exception $e) {
                $failCount++;
                \Log::warning('AppleWalletPushService: Push failed for device', [
                    'device_id' => $device->device_library_identifier,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        // Cleanup
        @unlink($combinedPemPath);

        \Log::info('AppleWalletPushService: Push complete', [
            'contact_id' => $contact->id,
            'success' => $successCount,
            'failed' => $failCount,
        ]);
    }

    /**
     * Send an empty push notification via HTTP/2 to APNs.
     *
     * Apple Wallet passes require an empty push body — just an empty JSON object {}.
     * Using raw cURL because the Pushok library injects an "aps" key which Apple rejects.
     */
    private function sendEmptyPush(string $deviceToken, string $pemPath): bool
    {
        $url = 'https://api.push.apple.com/3/device/' . $deviceToken;

        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_PORT => 443,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'apns-push-type: background',
                'apns-priority: 5',
                'apns-topic: ' . config('services.apple_wallet.pass_type_identifier'),
            ],
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => '{}',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2_0,
            CURLOPT_SSLCERT => $pemPath,
            CURLOPT_HEADER => true,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            \Log::warning('AppleWalletPushService: cURL error', [
                'error' => $curlError,
                'device_token' => substr($deviceToken, 0, 10) . '...',
            ]);
            return false;
        }

        if ($httpCode !== 200) {
            \Log::warning('AppleWalletPushService: APNs returned non-200', [
                'http_code' => $httpCode,
                'response' => $response,
                'device_token' => substr($deviceToken, 0, 10) . '...',
            ]);
            return false;
        }

        return true;
    }
}
