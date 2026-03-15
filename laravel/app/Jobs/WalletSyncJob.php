<?php

namespace App\Jobs;

use App\Models\CrmContact;
use App\Services\AppleWalletPushService;
use App\Services\GoogleWalletService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class WalletSyncJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public function __construct(
        public CrmContact $contact,
    ) {}

    public function handle(AppleWalletPushService $applePush, GoogleWalletService $googleService): void
    {
        // Apple — push silencieux vers les devices enregistrés
        try {
            $applePush->notifyDevicesForContact($this->contact);
        } catch (\Exception $e) {
            Log::error('WalletSyncJob: Apple push failed', [
                'contact_id' => $this->contact->id,
                'error' => $e->getMessage(),
            ]);
        }

        // Google — PATCH direct sur l'API (silencieux si pas configuré)
        try {
            $googleService->updatePoints($this->contact);
        } catch (\Exception $e) {
            Log::error('WalletSyncJob: Google update failed', [
                'contact_id' => $this->contact->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
