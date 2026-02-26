<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CleanupOldLoyaltyRewards extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'loyalty:cleanup-rewards';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Permanently delete soft-deleted loyalty rewards older than 1 year';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = \App\Models\LoyaltyReward::onlyTrashed()
            ->where('deleted_at', '<', now()->subDays(365))
            ->forceDelete();

        $this->info("Successfully permanently deleted {$count} old loyalty rewards.");
    }
}
