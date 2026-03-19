<?php

namespace App\Jobs;

use App\Models\Team;
use App\Models\CrmContact;
use App\Services\AppleWalletPushService;
use App\Services\GoogleWalletService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SyncTeamWalletPassesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Team $team) {}

    public function handle(GoogleWalletService $googleService, AppleWalletPushService $applePushService): void
    {
        Log::info('SyncTeamWalletPassesJob: Starting sync for team ' . $this->team->id);

        // 1. Google Wallet Sync (Update Class)
        try {
            if ($googleService->isEnabled()) {
                $googleService->createOrUpdateClass($this->team);
                Log::info('SyncTeamWalletPassesJob: Google Wallet class updated.');
            }
        } catch (\Exception $e) {
            Log::error('SyncTeamWalletPassesJob: Google sync failed', ['error' => $e->getMessage()]);
        }

        // 2. Apple Wallet Sync (Silent Pushes)
        try {
            // Find all contacts for this team that have wallet registrations
            $contacts = CrmContact::where('team_id', $this->team->id)
                ->whereHas('walletRegistrations')
                ->get();

            if ($contacts->isNotEmpty()) {
                Log::info('SyncTeamWalletPassesJob: Notifying Apple devices for ' . $contacts->count() . ' contacts.');
                
                // Touch the generated contacts so the Apple Wallet API (passesUpdatedSince)
                // recognizes that a change has occurred and downloads the new pass.
                CrmContact::whereIn('id', $contacts->pluck('id'))->update(['updated_at' => now()]);

                foreach ($contacts as $contact) {
                    $applePushService->notifyDevicesForContact($contact);
                }
            }
        } catch (\Exception $e) {
            Log::error('SyncTeamWalletPassesJob: Apple push sync failed', ['error' => $e->getMessage()]);
        }
    }
}
