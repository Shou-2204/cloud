<?php

namespace Tests\Feature;

use App\Models\Team;
use App\Models\User;
use App\Models\TeamInvoice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Laravel\Cashier\Cashier;
use Tests\TestCase;
use App\Listeners\StripeInvoicePaidListener;
use Laravel\Cashier\Events\WebhookReceived;
use Illuminate\Support\Facades\Event;
use App\Jobs\UploadInvoiceToS3;
use Illuminate\Support\Facades\Queue;

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
        $user = User::factory()->withPersonalTeam()->create();
        $team = $user->currentTeam;

        // Mock subscription
        $team->newSubscription('default', 'price_test')->create('pm_card_visa');

        $response = $this->actingAs($user)
            ->post(route('subscription.cancel', $team), [
                'reason' => 'too_expensive'
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
                ]
            ]
        ]);

        $listener = new StripeInvoicePaidListener();
        $listener->handle($event);

        Queue::assertPushed(UploadInvoiceToS3::class, function ($job) {
            return $job->invoiceId === 'in_123';
        });
    }
}
