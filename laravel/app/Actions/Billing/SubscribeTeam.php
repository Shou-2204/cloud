<?php

namespace App\Actions\Billing;

use App\Models\Team;

class SubscribeTeam
{
    /**
     * Subscribe a team to a plan.
     *
     * @return \Laravel\Cashier\SubscriptionBuilder
     */
    public function execute(Team $team, string $priceId)
    {
        // Empêcher de s'abonner deux fois (Logique métier)
        if ($team->subscribed('default')) {
            throw new \Exception('Votre équipe est déjà abonnée !');
        }

        return $team->newSubscription('default', $priceId);
    }
}
