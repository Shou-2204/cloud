<?php

namespace App\Console\Commands;

use App\Models\CrmContact;
use App\Models\TeamSetting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ExpireLoyaltyPoints extends Command
{
    protected $signature = 'loyalty:expire-points';

    protected $description = 'Reset loyalty points for teams whose expiration date has passed';

    public function handle()
    {
        $today = now()->format('m-d'); // MM-DD

        // Find all team settings where expiration is enabled and the date matches today
        $settings = TeamSetting::where('loyalty_points_expire', true)
            ->where('loyalty_points_expiration_date', $today)
            ->get();

        $totalReset = 0;

        foreach ($settings as $setting) {
            $count = CrmContact::where('team_id', $setting->team_id)
                ->where('loyalty_points', '>', 0)
                ->update(['loyalty_points' => 0]);

            $totalReset += $count;

            $this->line("Team #{$setting->team_id}: reset {$count} contacts.");
        }

        $this->info("Done. Reset points for {$totalReset} contacts across {$settings->count()} teams.");
    }
}
