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
        return auth()->user()->currentTeam
            ->newSubscription('default', $price)
            ->checkout([
                'success_url' => route('dashboard'),
                'cancel_url' => route('subscription.index'),
            ]);
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