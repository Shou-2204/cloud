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
        $validated = $request->validate([
            'pushToken' => 'required|string|min:64|max:200|regex:/^[a-f0-9]+$/i',
        ]);

        $pushToken = $validated['pushToken'];

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
            return response()->json([], 200);
        }

        $serials = WalletRegistration::where('wallet_device_id', $device->id)
            ->where('pass_type_identifier', $passTypeIdentifier)
            ->pluck('serial_number');

        if ($serials->isEmpty()) {
            return response()->json([], 204);
        }

        $tag = $request->query('passesUpdatedSince');

        // Get all contacts for these serials, with their real updated_at
        $contacts = CrmContact::whereIn('id', $serials);

        if ($tag) {
            try {
                $since = \Illuminate\Support\Carbon::parse($tag);
                $contacts = $contacts->where('updated_at', '>', $since);
            } catch (\Exception $e) {
                // Invalid tag, ignore and return all
            }
        }

        $updatedContacts = $contacts->get(['id', 'updated_at']);

        if ($updatedContacts->isEmpty()) {
            return response()->json([], 204);
        }

        // The lastUpdated tag MUST be the real latest updated_at from the contacts,
        // NOT now(). Apple uses this tag to detect changes — if the tag doesn't
        // advance past the contact's actual modification time, Apple enters an
        // infinite loop thinking nothing changed.
        $latestUpdate = $updatedContacts->max('updated_at');

        return response()->json([
            'serialNumbers' => $updatedContacts->pluck('id')->values()->toArray(),
            'lastUpdated' => $latestUpdate->toIso8601String(),
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
        $validated = $request->validate([
            'logs'   => 'required|array|max:10',
            'logs.*' => 'string|max:500',
        ]);

        $logs = $validated['logs'];

        foreach ($logs as $log) {
            \Log::info('AppleWallet Device Log: ' . $log);
        }

        return response()->json([], 200);
    }
}
