<?php

namespace App\Jobs;

use App\Models\CrmContact;
use App\Services\AppleWalletPushService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AppleWalletPushJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public function __construct(
        public CrmContact $contact,
    ) {}

    public function handle(AppleWalletPushService $pushService): void
    {
        $pushService->notifyDevicesForContact($this->contact);
    }
}
