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