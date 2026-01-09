<?php

namespace App\Http\Controllers;

use App\Actions\Billing\SubscribeTeam;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        return view('billing.pricing');
    }

    public function checkout(Request $request, string $priceId, SubscribeTeam $subscriber)
    {
        $user = $request->user();

        // --- CORRECTION DU PROBLEME ---
        // Si l'utilisateur n'a pas d'équipe active, on regarde s'il en a une en stock
        if (! $user->currentTeam && $user->allTeams()->isNotEmpty()) {
            // On le force à basculer sur sa première équipe disponible
            $user->switchTeam($user->allTeams()->first());
        }
        // ------------------------------

        // Maintenant, on vérifie s'il est VRAIMENT sans équipe
        if (! $user->currentTeam) {
            return redirect()->route('onboarding')
                ->with('flash.banner', 'Veuillez créer une équipe pour souscrire un abonnement.');
        }

        $team = $user->currentTeam;

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