<?php

namespace App\Services;

use App\Models\CrmContact;
use App\Models\WalletRegistration;
use Pushok\AuthProvider\Certificate;
use Pushok\Client;
use Pushok\Notification;
use Pushok\Payload;

class AppleWalletPushService
{
    /**
     * Send an empty push notification to all devices registered for this contact's pass.
     *
     * This triggers the Apple Wallet update flow:
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
            return;
        }

        // Build the APNs client — certificate-based auth only
        $certPath = base_path($config['push_cert_path']);
        $keyPath = base_path($config['push_key_path']);

        if (!file_exists($certPath) || !file_exists($keyPath)) {
            \Log::warning('AppleWalletPushService: Push certificate or key not found.', [
                'cert_path' => $certPath,
                'key_path' => $keyPath,
            ]);
            return;
        }

        try {
            // Pushok's Certificate AuthProvider expects a single file containing both cert and key.
            // We create a temporary combined file for this request.
            $combinedPemPath = tempnam(sys_get_temp_dir(), 'apns_');
            $combinedContent = file_get_contents($certPath) . "\n" . file_get_contents($keyPath);
            file_put_contents($combinedPemPath, $combinedContent);

            $authProvider = Certificate::create([
                'certificate_path' => $combinedPemPath,
                'certificate_secret' => null, // PEM key has no passphrase
                'app_bundle_id' => $passTypeId,
            ]);

            $client = new Client($authProvider, $production = true);

            $notifications = [];

            foreach ($registrations as $registration) {
                $device = $registration->device;
                if (!$device || empty($device->push_token)) {
                    continue;
                }

                // Apple Wallet expects an empty JSON payload
                $payload = Payload::create();

                $notification = new Notification($payload, $device->push_token);

                $notifications[] = $notification;
            }

            if (empty($notifications)) {
                return;
            }

            $client->addNotifications($notifications);
            $responses = $client->push();

            foreach ($responses as $response) {
                if ($response->getStatusCode() !== 200) {
                    \Log::warning('AppleWalletPushService: Push failed', [
                        'device_token' => $response->getDeviceToken(),
                        'status' => $response->getStatusCode(),
                        'reason' => $response->getReasonPhrase(),
                    ]);
                }
            }

            // Cleanup the temporary combined cert file
            @unlink($combinedPemPath);

        } catch (\Exception $e) {
            // Also cleanup on error
            if (isset($combinedPemPath) && file_exists($combinedPemPath)) {
                @unlink($combinedPemPath);
            }
            \Log::error('AppleWalletPushService: Error sending push notifications', [
                'error' => $e->getMessage(),
                'contact_id' => $contact->id,
            ]);
        }
    }
}
