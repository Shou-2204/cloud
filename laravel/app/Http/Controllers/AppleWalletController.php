<?php

namespace App\Http\Controllers;

use App\Models\CrmContact;
use App\Models\WalletDevice;
use App\Models\WalletRegistration;
use App\Services\ApplePassService;
use Illuminate\Http\Request;

class AppleWalletController extends Controller
{
    /**
     * Download a personalized .pkpass for a CrmContact.
     */
    public function downloadPass(CrmContact $contact, ApplePassService $passService)
    {
        try {
            $pkpassContent = $passService->generatePass($contact);

            return response($pkpassContent, 200, [
                'Content-Type' => 'application/vnd.apple.pkpass',
                'Content-Disposition' => 'attachment; filename="loyalty_' . $contact->pass_token . '.pkpass"',
            ]);
        } catch (\Exception $e) {
            \Log::error('AppleWalletController: Pass generation failed', [
                'contact_id' => $contact->id,
                'error' => $e->getMessage(),
            ]);
            return response('Erreur lors de la génération du pass : ' . $e->getMessage(), 500);
        }
    }

    // ========================================================================
    // Apple Wallet Web Service API (spec Apple PassKit)
    // These endpoints are called automatically by iOS devices.
    // ========================================================================

    /**
     * Register a device to receive push notifications for a pass.
     *
     * POST /api/v1/devices/{deviceLibraryIdentifier}/registrations/{passTypeIdentifier}/{serialNumber}
     */
    public function registerDevice(Request $request, string $deviceLibraryIdentifier, string $passTypeIdentifier, string $serialNumber)
    {
        $pushToken = $request->input('pushToken');

        if (empty($pushToken)) {
            return response()->json(['error' => 'pushToken is required'], 400);
        }

        // updateOrCreate — push_token can change after iOS restore/reinstall
        $device = WalletDevice::updateOrCreate(
            ['device_library_identifier' => $deviceLibraryIdentifier],
            ['push_token' => $pushToken]
        );

        // Create the registration (device ↔ pass association)
        $registration = WalletRegistration::firstOrCreate([
            'wallet_device_id' => $device->id,
            'pass_type_identifier' => $passTypeIdentifier,
            'serial_number' => $serialNumber,
        ]);

        // 201 = new registration, 200 = already existed
        return response()->json([], $registration->wasRecentlyCreated ? 201 : 200);
    }

    /**
     * Unregister a device from a pass.
     *
     * DELETE /api/v1/devices/{deviceLibraryIdentifier}/registrations/{passTypeIdentifier}/{serialNumber}
     */
    public function unregisterDevice(Request $request, string $deviceLibraryIdentifier, string $passTypeIdentifier, string $serialNumber)
    {
        $device = WalletDevice::where('device_library_identifier', $deviceLibraryIdentifier)->first();

        if (!$device) {
            return response()->json([], 200);
        }

        WalletRegistration::where('wallet_device_id', $device->id)
            ->where('pass_type_identifier', $passTypeIdentifier)
            ->where('serial_number', $serialNumber)
            ->delete();

        // Clean up device if no registrations left
        if ($device->registrations()->count() === 0) {
            $device->delete();
        }

        return response()->json([], 200);
    }

    /**
     * Get serial numbers of passes updated since a given tag.
     *
     * GET /api/v1/devices/{deviceLibraryIdentifier}/registrations/{passTypeIdentifier}?passesUpdatedSince={tag}
     */
    public function getUpdatedSerials(Request $request, string $deviceLibraryIdentifier, string $passTypeIdentifier)
    {
        $device = WalletDevice::where('device_library_identifier', $deviceLibraryIdentifier)->first();

        if (!$device) {
            return response()->json([], 204);
        }

        $query = WalletRegistration::where('wallet_device_id', $device->id)
            ->where('pass_type_identifier', $passTypeIdentifier);

        $tag = $request->query('passesUpdatedSince');

        if ($tag) {
            // Tag is a timestamp — find contacts updated after that time
            $serials = $query->pluck('serial_number');

            $updatedSerials = CrmContact::whereIn('id', $serials)
                ->where('updated_at', '>', $tag)
                ->pluck('id')
                ->values()
                ->toArray();

            if (empty($updatedSerials)) {
                return response()->json([], 204);
            }

            return response()->json([
                'serialNumbers' => $updatedSerials,
                'lastUpdated' => now()->toIso8601String(),
            ]);
        }

        // No tag → return all serial numbers
        $serials = $query->pluck('serial_number')->values()->toArray();

        if (empty($serials)) {
            return response()->json([], 204);
        }

        return response()->json([
            'serialNumbers' => $serials,
            'lastUpdated' => now()->toIso8601String(),
        ]);
    }

    /**
     * Get the latest version of a pass.
     *
     * GET /api/v1/passes/{passTypeIdentifier}/{serialNumber}
     */
    public function getLatestPass(Request $request, string $passTypeIdentifier, string $serialNumber, ApplePassService $passService)
    {
        $contact = $request->attributes->get('wallet_contact');

        if (!$contact) {
            return response()->json(['error' => 'Pass not found'], 404);
        }

        try {
            $pkpassContent = $passService->generatePass($contact);

            return response($pkpassContent, 200, [
                'Content-Type' => 'application/vnd.apple.pkpass',
                'Last-Modified' => $contact->updated_at->toRfc7231String(),
            ]);
        } catch (\Exception $e) {
            \Log::error('AppleWalletController: Pass generation failed during update', [
                'contact_id' => $contact->id,
                'error' => $e->getMessage(),
            ]);
            return response()->json(['error' => 'Internal error'], 500);
        }
    }

    /**
     * Receive log messages from Apple Wallet.
     *
     * POST /api/v1/log
     */
    public function logMessages(Request $request)
    {
        $logs = $request->input('logs', []);

        foreach ($logs as $log) {
            \Log::info('AppleWallet Device Log: ' . $log);
        }

        return response()->json([], 200);
    }
}
