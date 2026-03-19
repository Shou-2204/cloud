<?php

namespace App\Console\Commands;

use App\Models\CrmContact;
use Illuminate\Console\Command;

class ResetGoogleWalletNotifyCount extends Command
{
    protected $signature = 'google-wallet:reset-notify-count';
    protected $description = 'Reset the daily Google Wallet notification counter for all contacts';

    public function handle(): int
    {
        $updated = CrmContact::where('google_wallet_notify_count', '>', 0)
            ->update(['google_wallet_notify_count' => 0]);

        $this->info("Reset notification count for {$updated} contacts.");

        return self::SUCCESS;
    }
}
