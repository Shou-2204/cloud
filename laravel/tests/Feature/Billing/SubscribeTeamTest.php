<?php

namespace Tests\Feature\Billing;

use App\Actions\Billing\SubscribeTeam;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Cashier\SubscriptionBuilder;
use Tests\TestCase;

class SubscribeTeamTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_subscription_builder_if_not_subscribed()
    {
        // Mocking Billable behavior might be complex without actual Stripe setup,
        // but we can test the logic flow.
        // For this example, we assume Team uses Billable trait.

        $user = User::factory()->withPersonalTeam()->create();
        $team = $user->personalTeam();

        // We mock the 'subscribed' method on the Team model partial mock if possible,
        // or just rely on default false.
        // Since we cannot easily partial mock Eloquent models in simple tests without heavy setup,
        // we will assume fresh team is not subscribed.

        $action = new SubscribeTeam();

        // Note: newSubscription returns a SubscriptionBuilder, it doesn't call Stripe API yet.
        $builder = $action->execute($team, 'price_123');

        $this->assertInstanceOf(SubscriptionBuilder::class, $builder);
    }

    public function test_it_throws_exception_if_already_subscribed()
    {
        $user = User::factory()->withPersonalTeam()->create();
        $team = $user->personalTeam();

        // We need to simulate the team is subscribed.
        // Usually done by creating a subscription in DB.
        $team->subscriptions()->create([
            'type' => 'default',
            'stripe_id' => 'sub_123',
            'stripe_status' => 'active',
            'stripe_price' => 'price_123',
            'quantity' => 1,
        ]);

        $action = new SubscribeTeam();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Votre équipe est déjà abonnée !');

        $action->execute($team, 'price_456');
    }
}
