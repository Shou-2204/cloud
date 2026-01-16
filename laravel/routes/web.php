<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController;
use App\Livewire\Onboarding;
use App\Models\Team;
use Illuminate\Http\Request;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TeamController;

// --- ROUTES PUBLIQUES ---

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);


Route::get('/pricing', [SubscriptionController::class, 'index'])->name('subscription.index');

// Action de paiement (Lien vers Stripe)
Route::get('/subscribe/{price}', [SubscriptionController::class, 'checkout'])->name('subscription.checkout');
Route::post('/subscribe/checkout', [SubscriptionController::class, 'storeBillingAndCheckout'])->name('subscription.store-checkout');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/invite/{code}', function ($code) {
    if (!auth()->check()) {
        session(['intended_join_code' => $code]);
        return redirect()->route('register');
    }

    return redirect()->route('onboarding', ['join' => $code]);
})->name('invite.link');

// --- ROUTES PROTÉGÉES (Connecté) ---

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    Route::get('/myteam', function () {
        $user = auth()->user();

        if (!$user->current_team_id) {
            return redirect()->route('onboarding');
        }

        return redirect()->route('teams.show', $user->current_team_id);
    })->name('team.hub');


    Route::get('/onboarding', Onboarding::class)->name('onboarding');

    // >>> NOUVELLE ROUTE : ANNULER SA DEMANDE / QUITTER L'ÉQUIPE <<<
    Route::delete('/teams/{team}/cancel-request', [TeamController::class, 'cancelRequest'])->name('teams.cancel-request');

    // Restoration des routes Jetstream (au cas où elles ne se chargent pas automatiquement)
    Route::group(['middleware' => 'verified'], function () {
        Route::get('/teams/create', [\Laravel\Jetstream\Http\Controllers\Livewire\TeamController::class, 'create'])->name('teams.create');
        Route::get('/teams/{team}', [\Laravel\Jetstream\Http\Controllers\Livewire\TeamController::class, 'show'])->name('teams.show');
        Route::put('/teams/{team}', [\Laravel\Jetstream\Http\Controllers\Livewire\TeamController::class, 'update'])->name('teams.update');
    });

    Route::middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
    ])->group(function () {

        // Route::get('/billing-portal', function (Request $request) {
        //     $user = $request->user();
        //     $team = $user->currentTeam;
        //     if (!$user->ownsTeam($team) && !$user->hasTeamRole($team, 'admin')) {
        //         abort(403, 'Seuls les administrateurs peuvent gérer la facturation.');
        //     }
        //     return $team->redirectToBillingPortal(route('dashboard'));
        // })->name('billing');

        // NEW : Subscription Management
        Route::prefix('team/{team}/subscription')->name('subscription.')->group(function () {
            Route::get('/', [SubscriptionController::class, 'show'])->name('show');
            Route::post('/cancel', [SubscriptionController::class, 'cancel'])->name('cancel');
            Route::post('/resume', [SubscriptionController::class, 'resume'])->name('resume');
            Route::post('/billing', [SubscriptionController::class, 'updateBilling'])->name('update-billing');
        });

    });

});
