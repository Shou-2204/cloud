<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function checkout(Request $request, string $priceId)
    {
        $team = $request->user()->currentTeam;

        // Empêcher de s'abonner deux fois
        if ($team->subscribed('default')) {
            return redirect()->route('dashboard')->with('flash.banner', 'Votre équipe est déjà abonnée !');
        }

        return $team
            ->newSubscription('default', $priceId)
            ->checkout([
                'success_url' => route('dashboard') . '?checkout=success',
                'cancel_url' => route('subscription.index'),
            ]);
    }
}
