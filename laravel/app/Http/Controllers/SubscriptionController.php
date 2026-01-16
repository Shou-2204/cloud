<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubscriptionController extends Controller
{
    /**
     * Display the pricing page (public).
     */
    public function index()
    {
        return view('subscription.index');
    }

    /**
     * Checkout logic (existing).
     */
    public function checkout($price)
    {
        $team = auth()->user()->currentTeam;

        if ($team->subscribed('default')) {
            return redirect()->route('subscription.show', $team)
                ->with('status', 'Vous avez déjà un abonnement actif pour cette équipe.');
        }

        // Check if billing info is missing
        if (empty($team->billing_name) || empty($team->billing_address) || empty($team->billing_city) || empty($team->billing_postal_code) || empty($team->billing_country)) {
            return view('subscription.checkout-form', [
                'team' => $team,
                'price' => $price
            ]);
        }

        return $team->newSubscription('default', $price)
            ->checkout([
                'success_url' => route('dashboard'),
                'cancel_url' => route('subscription.index'),
            ]);
    }

    public function storeBillingAndCheckout(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'billing_name' => 'required|string|max:255',
            'billing_address' => 'required|string|max:255',
            'billing_address_line2' => 'nullable|string|max:255',
            'billing_city' => 'required|string|max:255',
            'billing_state' => 'nullable|string|max:255',
            'billing_postal_code' => 'required|string|max:20',
            'billing_country' => 'required|string|max:2',
            'vat_id' => 'nullable|string|max:50',
            'price' => 'required|string',
        ]);

        $team = $request->user()->currentTeam;

        $team->update([
            'billing_name' => $validated['billing_name'],
            'billing_address' => $validated['billing_address'],
            'billing_address_line2' => $validated['billing_address_line2'] ?? null,
            'billing_city' => $validated['billing_city'],
            'billing_state' => $validated['billing_state'] ?? null,
            'billing_postal_code' => $validated['billing_postal_code'],
            'billing_country' => $validated['billing_country'],
            'vat_id' => $validated['vat_id'] ?? null,
        ]);

        $this->syncStripeBilling($team);

        // Proceed to checkout
        return $team->newSubscription('default', $validated['price'])
            ->checkout([
                'success_url' => route('dashboard'),
                'cancel_url' => route('subscription.index'),
            ]);
    }

    public function updateBilling(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'billing_name' => 'required|string|max:255',
            'billing_address' => 'required|string|max:255',
            'billing_address_line2' => 'nullable|string|max:255',
            'billing_city' => 'required|string|max:255',
            'billing_state' => 'nullable|string|max:255',
            'billing_postal_code' => 'required|string|max:20',
            'billing_country' => 'required|string|max:2',
            'vat_id' => 'nullable|string|max:50',
        ]);

        $team = $request->user()->currentTeam;
        $team->update([
            'billing_name' => $validated['billing_name'],
            'billing_address' => $validated['billing_address'],
            'billing_address_line2' => $validated['billing_address_line2'] ?? null,
            'billing_city' => $validated['billing_city'],
            'billing_state' => $validated['billing_state'] ?? null,
            'billing_postal_code' => $validated['billing_postal_code'],
            'billing_country' => $validated['billing_country'],
            'vat_id' => $validated['vat_id'] ?? null,
        ]);

        $this->syncStripeBilling($team);

        return back()->with('status', 'billing-updated');
    }

    protected function syncStripeBilling($team)
    {
        if (!$team->hasStripeId()) {
            return;
        }

        // 1. Sync Customer Details (Name & Address) using model defaults
        $team->syncStripeCustomerDetails();

        // 2. Manage Tax IDs (remains manual as it's specific)
        $existingTaxIds = $team->taxIds();
        $vatId = $team->vat_id;

        // If no VAT ID provided, remove all existing ones
        if (empty($vatId)) {
            foreach ($existingTaxIds as $taxId) {
                $team->deleteTaxId($taxId->id);
            }
            return;
        }

        // Determine Type
        $type = $this->determineTaxIdType($vatId);

        // Check if we already have this Tax ID
        $hasTaxId = $existingTaxIds->contains(function ($t) use ($vatId, $type) {
            return $t->value === $vatId && $t->type === $type;
        });

        if ($hasTaxId) {
            return; // Already synced
        }

        // Remove old Tax IDs (assuming 1 active for simplicity)
        foreach ($existingTaxIds as $taxId) {
            $team->deleteTaxId($taxId->id);
        }

        // Create new Tax ID
        try {
            $team->createTaxId($type, $vatId);
        } catch (\Exception $e) {
            // Ignore invalid tax ID errors from Stripe to prevent crashing
            // user feedback could be improved here but preventing 500 is priority
        }
    }

    protected function determineTaxIdType($vatId)
    {
        $vatId = strtoupper(trim($vatId));

        if (str_starts_with($vatId, 'GB')) {
            return 'gb_vat';
        }

        if (str_starts_with($vatId, 'CH')) {
            return 'ch_vat';
        }

        // Default to EU VAT for most European countries
        return 'eu_vat';
    }

    /**
     * Display the subscription management page.
     */
    public function show(Team $team)
    {
        // Security check
        $this->authorize('update', $team);

        $subscription = $team->subscription('default');
        $invoices = $team->invoicesRel; // Using the relationship we just added

        return view('subscription.show', [
            'team' => $team,
            'subscription' => $subscription,
            'invoices' => $invoices,
        ]);
    }

    /**
     * Cancel the subscription.
     */
    public function cancel(Request $request, Team $team)
    {
        $this->authorize('update', $team);

        // Redirect to Stripe Billing Portal
        return $team->redirectToBillingPortal(route('subscription.show', $team));
    }

    /**
     * Resume the subscription.
     */
    public function resume(Team $team)
    {
        $this->authorize('update', $team);

        $team->subscription('default')->resume();

        return redirect()->route('subscription.show', $team)
            ->with('status', 'Votre abonnement a été réactivé !');
    }
}