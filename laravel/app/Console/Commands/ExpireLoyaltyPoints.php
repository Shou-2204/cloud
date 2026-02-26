<?php

namespace App\Console\Commands;

use App\Models\CrmContact;
use App\Models\LoyaltyRedemption;
use App\Models\TeamSetting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ExpireLoyaltyPoints extends Command
{
    protected $signature = 'loyalty:expire-points';

    protected $description = 'Reset loyalty points for teams whose expiration date has passed';

    public function handle()
    {
        $today = now()->toDateString(); // YYYY-MM-DD

        // Find all team settings where expiration is enabled and the next expiration date has passed
        $settings = TeamSetting::where('loyalty_points_expire', true)
            ->whereNotNull('loyalty_points_next_expiration')
            ->where('loyalty_points_next_expiration', '<=', $today)
            ->get();

        $totalReset = 0;

        foreach ($settings as $setting) {
            DB::transaction(function () use ($setting, &$totalReset) {
                // Get contacts with points > 0 for this team
                $contacts = CrmContact::where('team_id', $setting->team_id)
                    ->where('loyalty_points', '>', 0)
                    ->get();

                foreach ($contacts as $contact) {
                    // Log the expiration as a redemption record for traceability
                    LoyaltyRedemption::create([
                        'type' => 'expiration',
                        'team_id' => $setting->team_id,
                        'crm_contact_id' => $contact->id,
                        'loyalty_reward_id' => null,
                        'reward_name' => 'Expiration annuelle',
                        'points_spent' => $contact->loyalty_points,
                    ]);
                }

                // Reset all points
                $count = CrmContact::where('team_id', $setting->team_id)
                    ->where('loyalty_points', '>', 0)
                    ->update(['loyalty_points' => 0]);

                $totalReset += $count;

                // Advance the next expiration date by 1 year
                $nextDate = \Carbon\Carbon::parse($setting->loyalty_points_next_expiration)->addYear();
                $setting->update(['loyalty_points_next_expiration' => $nextDate->toDateString()]);

                $this->line("Team #{$setting->team_id}: reset {$count} contacts, next expiration: {$nextDate->toDateString()}.");
            });
        }

        $this->info("Done. Reset points for {$totalReset} contacts across {$settings->count()} teams.");
    }
}
