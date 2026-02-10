<?php

namespace App\Listeners;

use App\Jobs\UploadInvoiceToS3;
use App\Models\Team;
use App\Notifications\SubscriptionChanged;
use Illuminate\Support\Facades\Http;
use Laravel\Cashier\Events\WebhookReceived;

class StripeInvoicePaidListener
{
    /**
     * Handle the event.
     */
    public function handle(WebhookReceived $event): void
    {
        $type = $event->payload['type'] ?? '';
        $object = $event->payload['data']['object'] ?? [];

        match ($type) {
            'invoice.payment_succeeded' => $this->handleInvoicePaid($object),
            'customer.subscription.created' => $this->handleSubscriptionCreated($object),
            'customer.subscription.deleted' => $this->handleSubscriptionCancelled($object),
            default => null,
        };
    }

    /**
     * Handle invoice payment succeeded.
     */
    private function handleInvoicePaid(array $invoice): void
    {
        if (isset($invoice['id'])) {
            UploadInvoiceToS3::dispatch($invoice['id']);
        }
    }

    /**
     * Handle new subscription created.
     */
    private function handleSubscriptionCreated(array $subscription): void
    {
        $team = $this->findTeamByStripeId($subscription['customer'] ?? '');
        if (! $team) {
            return;
        }

        $planName = $this->resolvePlanName($subscription['items']['data'][0]['price']['id'] ?? null);
        $team->owner->notify(new SubscriptionChanged($planName, 'subscribed'));

        try {
            Http::post('https://hooks.slack.com/services/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', [
                'text' => "💰 Nouvel Abonnement !\n\n👤 *Client:* {$team->owner->name} ({$team->owner->email})\n🏢 *Équipe:* {$team->name}\n🏷 *Plan:* {$planName}",
            ]);
        } catch (\Exception $e) {
            // Silently fail
        }
    }

    /**
     * Handle subscription cancelled.
     */
    private function handleSubscriptionCancelled(array $subscription): void
    {
        $team = $this->findTeamByStripeId($subscription['customer'] ?? '');
        if (! $team) {
            return;
        }

        $planName = $this->resolvePlanName($subscription['items']['data'][0]['price']['id'] ?? null);
        $team->owner->notify(new SubscriptionChanged($planName, 'cancelled'));
    }

    /**
     * Find team by Stripe customer ID.
     */
    private function findTeamByStripeId(string $stripeId): ?Team
    {
        if (empty($stripeId)) {
            return null;
        }

        return Team::where('stripe_id', $stripeId)->first();
    }

    /**
     * Resolve plan name from Stripe price ID.
     */
    private function resolvePlanName(?string $stripePrice): string
    {
        if (! $stripePrice) {
            return 'Premium';
        }

        foreach (config('subscription_plans', []) as $plan) {
            if (($plan['stripe_id_monthly'] ?? '') === $stripePrice || ($plan['stripe_id_yearly'] ?? '') === $stripePrice) {
                return $plan['name'];
            }
        }

        return 'Premium';
    }
}
