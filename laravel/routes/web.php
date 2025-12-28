<?php

use App\Http\Controllers\TeamInvitationController;
use Illuminate\Support\Facades\Route;

// Route pour accepter l'invitation
Route::get('/team-invitations/accept/{token}', [TeamInvitationController::class, 'accept'])
    ->middleware('signed')
    ->name('team-invitations.accept');

// On redirige la racine vers /admin (ou plutôt, comme le panel est sur '/', Filament prend le relais)
// Si le panel est sur '/', cette route '/' ici pourrait entrer en conflit si elle est définie APRES Filament.
// Mais Filament s'enregistre généralement comme un fallback ou sur des routes précises.
// Comme j'ai mis path('/') dans le Panel, Filament devrait gérer la racine.
// Je supprime donc la route '/' par défaut de Laravel pour laisser la place à Filament.

// Je supprime aussi les routes dashboard de Jetstream obsolètes.
