<?php

declare(strict_types=1);

namespace App\Actions\Billing;

use App\Models\Team;
use Exception;
use Laravel\Cashier\Subscription;

/**
 * Swaps a team's subscription to a new plan with prorated billing.
 */
class SwapSubscription
{
    /**
     * Execute the subscription swap.
     *
     * @throws Exception
     */
    public function execute(Team $team, string $newPriceId): Subscription
    {
        $subscription = $team->subscription('default');

        if (!$subscription) {
            throw new Exception('Aucun abonnement actif à modifier.');
        }

        // Swap and invoice immediately (prorated)
        return $subscription->swapAndInvoice($newPriceId);
    }
}
