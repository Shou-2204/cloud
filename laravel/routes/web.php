<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController;
use App\Livewire\Onboarding;
use App\Models\Team;           // <--- Important pour la route custom
use Illuminate\Http\Request;   // <--- Important pour la route custom

// --- ROUTES PUBLIQUES ---

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

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


    Route::get('/teams', function () {
        $user = auth()->user();

        if (! $user->current_team_id) {
            return redirect()->route('onboarding');
        }

        return redirect()->route('teams.show', $user->current_team_id);
    })->name('team.hub');


    Route::get('/onboarding', Onboarding::class)->name('onboarding');

    // >>> NOUVELLE ROUTE : ANNULER SA DEMANDE / QUITTER L'ÉQUIPE <<<
    Route::delete('/teams/{team}/cancel-request', function (Request $request, Team $team) {
        // 1. Sécurité : On vérifie que l'utilisateur est bien lié à l'équipe (même en attente)
        if (! $request->user()->teams()->where('team_id', $team->id)->exists()) {
            abort(403);
        }

        // 2. On retire l'utilisateur de l'équipe
        $team->removeUser($request->user());

        // 3. Si c'était son équipe active, on remet à NULL pour éviter le bug d'affichage
        if ($request->user()->current_team_id === $team->id) {
            $request->user()->forceFill(['current_team_id' => null])->save();
        }

        return redirect()->route('dashboard');
    })->name('teams.cancel-request');

});