<?php

namespace Tests\Feature;

use App\Jobs\UploadInvoiceToS3;
use App\Listeners\StripeInvoicePaidListener;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Laravel\Cashier\Events\WebhookReceived;
use Tests\TestCase;

class SubscriptionFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_subscription_page_is_accessible()
    {
        $user = User::factory()->withPersonalTeam()->create();
        $team = $user->currentTeam;

        $response = $this->actingAs($user)->get(route('subscription.show', $team));

        $response->assertStatus(200);
        $response->assertSee('Plan Actuel');
        $response->assertSee('Factures');
    }

    public function test_subscription_cancellation()
    {
        if (! getenv('STRIPE_SECRET')) {
            $this->markTestSkipped('Stripe secret key not set.');
        }

        $user = User::factory()->withPersonalTeam()->create();
        $team = $user->currentTeam;

        // Mock subscription
        $team->newSubscription('default', 'price_test')->create('pm_card_visa');

        $response = $this->actingAs($user)
            ->post(route('subscription.cancel', $team), [
                'reason' => 'too_expensive',
            ]);

        $response->assertRedirect(route('subscription.show', $team));
        $this->assertTrue($team->subscription('default')->onGracePeriod());
    }

    public function test_invoice_upload_job_is_dispatched()
    {
        Queue::fake();

        $event = new WebhookReceived([
            'type' => 'invoice.payment_succeeded',
            'data' => [
                'object' => [
                    'id' => 'in_123',
                    'customer' => 'cus_123',
                ],
            ],
        ]);

        $listener = app(StripeInvoicePaidListener::class);
        $listener->handle($event);

        Queue::assertPushed(UploadInvoiceToS3::class, function ($job) {
            return $job->invoiceId === 'in_123';
        });
    }
}
