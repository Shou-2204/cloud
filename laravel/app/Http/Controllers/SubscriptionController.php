<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Billing\SwapSubscription;
use App\Actions\Billing\SyncStripeBilling;
use App\Http\Requests\Billing\StoreBillingRequest;
use App\Http\Requests\Billing\SwapSubscriptionRequest;
use App\Mail\SubscriptionCancellationNotice;
use App\Models\Team;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Laravel\Cashier\Checkout;

/**
 * Handles subscription management: pricing, checkout, billing, and plan swaps.
 */
class SubscriptionController extends Controller
{
    public function __construct(
        protected SyncStripeBilling $syncStripeBilling,
        protected SwapSubscription $swapSubscription,
    ) {
    }

    /**
     * Display the pricing page (public).
     */
    public function index(): View
    {
        return view('subscription.index');
    }

    /**
     * Redirect to current team's subscription page.
     */
    public function redirectToCurrentTeam(): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->current_team_id) {
            return redirect()->route('onboarding');
        }

        return redirect()->route('subscription.show', $user->current_team_id);
    }

    /**
     * Handle checkout flow - show billing form or redirect to Stripe.
     */
    public function checkout(string $price): View|Checkout|RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $team = $user->currentTeam;

        if ($team->subscribed('default')) {
            return redirect()->route('subscription.show', $team)
                ->with('status', 'Vous avez déjà un abonnement actif pour cette équipe.');
        }

        // Check if billing info is missing
        if ($this->isBillingInfoMissing($team)) {
            return view('subscription.checkout-form', [
                'team' => $team,
                'price' => $price,
            ]);
        }

        return $this->createCheckoutSession($team, $price);
    }

    /**
     * Store billing info and proceed to Stripe checkout.
     */
    public function storeBillingAndCheckout(StoreBillingRequest $request): Checkout
    {
        /** @var \App\Models\User $user */
        $user = $request->user();
        $team = $user->currentTeam;

        $this->updateTeamBilling($team, $request->validated());
        $this->syncStripeBilling->execute($team);

        return $this->createCheckoutSession($team, $request->validated('price'));
    }

    /**
     * Update team billing information.
     */
    public function updateBilling(StoreBillingRequest $request, Team $team): RedirectResponse
    {
        $this->authorize('update', $team);

        $this->updateTeamBilling($team, $request->validated());
        $this->syncStripeBilling->execute($team);

        return back()->with('status', 'billing-updated');
    }

    /**
     * Display the subscription management page.
     */
    public function show(Team $team): View
    {
        $this->authorize('update', $team);

        $subscription = $team->subscription('default');
        $invoices = $team->invoicesRel;

        $planName = $this->resolvePlanName($subscription?->stripe_price);

        return view('subscription.show', [
            'team' => $team,
            'subscription' => $subscription,
            'invoices' => $invoices,
            'planName' => $planName,
        ]);
    }

    /**
     * Swap the subscription to a new plan.
     */
    public function update(SwapSubscriptionRequest $request, Team $team): RedirectResponse
    {
        $this->authorize('update', $team);

        // Dispatch job for async processing
        \App\Jobs\UpdateSubscriptionJob::dispatch($team, $request->validated('price'));

        return redirect()->route('subscription.index')
            ->with('status', 'Le changement de votre abonnement est en cours de traitement. La mise à jour sera effective dans quelques instants.');
    }

    /**
     * Handle subscription cancellation with feedback email.
     */
    public function cancel(Request $request, Team $team): mixed
    {
        $this->authorize('update', $team);

        // Validate cancellation reason
        $validated = $request->validate([
            'reason' => ['required', 'string', 'in:too_expensive,missing_features,bugs,other'],
            'contact_allowed' => ['nullable'],
        ]);

        /** @var \App\Models\User $user */
        $user = $request->user();

        // Send cancellation notification email to admin
        Mail::to(config('app.admin_notification_email'))
            ->send(new SubscriptionCancellationNotice(
                team: $team,
                reason: $validated['reason'],
                contactAllowed: isset($validated['contact_allowed']),
                userEmail: $user->email,
                userName: $user->name,
            ));

        return $team->redirectToBillingPortal(route('subscription.show', $team));
    }

    /**
     * Resume a cancelled subscription.
     */
    public function resume(Team $team): RedirectResponse
    {
        $this->authorize('update', $team);

        $team->subscription('default')->resume();

        return redirect()->route('subscription.show', $team)
            ->with('status', 'Votre abonnement a été réactivé !');
    }

    // ========================================
    // Private Helper Methods
    // ========================================

    /**
     * Check if required billing fields are missing.
     */
    private function isBillingInfoMissing(Team $team): bool
    {
        return empty($team->billing_name)
            || empty($team->billing_address)
            || empty($team->billing_city)
            || empty($team->billing_postal_code)
            || empty($team->billing_country);
    }

    /**
     * Update team with billing information.
     *
     * @param array<string, mixed> $data
     */
    private function updateTeamBilling(Team $team, array $data): void
    {
        $team->update([
            'billing_name' => $data['billing_name'],
            'billing_address' => $data['billing_address'],
            'billing_address_line2' => $data['billing_address_line2'] ?? null,
            'billing_city' => $data['billing_city'],
            'billing_state' => $data['billing_state'] ?? null,
            'billing_postal_code' => $data['billing_postal_code'],
            'billing_country' => $data['billing_country'],
            'vat_id' => $data['vat_id'] ?? null,
        ]);
    }

    /**
     * Create a Stripe Checkout session.
     */
    private function createCheckoutSession(Team $team, string $price): Checkout
    {
        return $team->newSubscription('default', $price)
            ->checkout([
                'success_url' => route('dashboard'),
                'cancel_url' => route('subscription.index'),
            ]);
    }

    /**
     * Resolve plan name from Stripe price ID.
     */
    private function resolvePlanName(?string $stripePrice): string
    {
        if (!$stripePrice) {
            return 'Abonnement Inconnu';
        }

        foreach (config('subscription_plans') as $plan) {
            if ($plan['stripe_id_monthly'] === $stripePrice || $plan['stripe_id_yearly'] === $stripePrice) {
                return $plan['name'];
            }
        }

        return 'Abonnement Inconnu';
    }
}