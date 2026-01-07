<?php

namespace App\Http\Controllers;

use App\Actions\Billing\SubscribeTeam;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Affiche la page de choix des offres (Pricing)
     */
    public function index()
    {
        return view('billing.pricing');
    }

    /**
     * Redirige vers le paiement Stripe pour une offre donnée
     */
    public function checkout(Request $request, string $priceId, SubscribeTeam $subscriber)
    {
        $team = $request->user()->currentTeam;

        try {
            $checkout = $subscriber->execute($team, $priceId);

            return $checkout->checkout([
                'success_url' => route('dashboard') . '?checkout=success',
                'cancel_url' => route('subscription.index'),
            ]);

        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('flash.banner', $e->getMessage());
        }
    }
}
