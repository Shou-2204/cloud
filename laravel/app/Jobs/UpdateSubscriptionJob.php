<?php

namespace App\Jobs;

use App\Actions\Billing\SwapSubscription;
use App\Models\Team;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UpdateSubscriptionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Team $team,
        public string $priceId
    ) {}

    /**
     * Execute the job.
     */
    public function handle(SwapSubscription $swapSubscription): void
    {
        try {
            Log::info("Processing subscription swap for Team ID: {$this->team->id} to Price ID: {$this->priceId}");

            $swapSubscription->execute($this->team, $this->priceId);

            // Resolve plan name
            $planName = 'Abonnement Inconnu';
            foreach (config('subscription_plans', []) as $plan) {
                if (($plan['stripe_id_monthly'] ?? '') === $this->priceId || ($plan['stripe_id_yearly'] ?? '') === $this->priceId) {
                    $planName = $plan['name'];
                    break;
                }
            }

            // Send confirmation email
            \Illuminate\Support\Facades\Mail::to($this->team->owner->email)
                ->send(new \App\Mail\SubscriptionUpdated($this->team, $planName));

            Log::info("Successfully swapped subscription for Team ID: {$this->team->id}");
        } catch (Exception $e) {
            Log::error("Failed to swap subscription for Team ID: {$this->team->id}. Error: ".$e->getMessage());
            // Optionally release back to queue or fail
            $this->fail($e);
        }
    }
}
