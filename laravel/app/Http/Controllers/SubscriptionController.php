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

        return $team->newSubscription('default', $price)
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
            'vat_id' => 'nullable|string|max:50',
        ]);

        $team = $request->user()->currentTeam;
        $team->update($validated);

        if ($team->hasStripeId()) {
            $team->updateStripeCustomer([
                'name' => $validated['billing_name'],
                'address' => [
                    'line1' => $validated['billing_address'],
                ],
            ]);

            // Note: Syncing Tax IDs via API is complex due to validation/types.
            // Ideally should use Customer Portal or explicit Tax ID management.
        }

        return back()->with('status', 'billing-updated');
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

        // Optional: Save the feedback/reason from $request->input('reason')

        if ($team->subscription('default')->onGracePeriod()) {
            // Already on grace period
            return back()->with('status', 'Votre abonnement est déjà en cours d\'annulation.');
        }

        // Cancel at end of period
        $team->subscription('default')->cancel();

        return redirect()->route('subscription.show', $team)
            ->with('status', 'Votre abonnement a été annulé avec succès. Il restera actif jusqu\'à la fin de la période.');
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