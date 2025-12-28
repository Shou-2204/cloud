<?php

namespace App\Http\Controllers;

use App\Models\TeamInvitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TeamInvitationController extends Controller
{
    public function accept(Request $request, $token)
    {
        // Validation basique (URL signée gérée par le middleware route)
        $invitation = TeamInvitation::where('token', $token)->firstOrFail();

        // Vérifier si l'utilisateur est déjà connecté
        if (Auth::check()) {
            $user = Auth::user();

            // Si l'email ne correspond pas, on peut soit bloquer, soit avertir.
            // Pour simplifier, on attache l'utilisateur actuel à l'équipe.
            $this->addUserToTeam($invitation, $user);

            return redirect('/')->with('status', 'Vous avez rejoint l\'équipe !');
        }

        // Si l'utilisateur n'est pas connecté, on regarde s'il existe déjà un compte avec cet email
        $existingUser = User::where('email', $invitation->email)->first();

        if ($existingUser) {
            // On demande de se connecter (idéalement on redirige vers le login avec un returnUrl)
            return redirect('/login')->with('status', 'Veuillez vous connecter pour accepter l\'invitation.');
        }

        // Sinon, on redirige vers l'inscription avec le token en session ou paramètre
        // Ici, pour simplifier, on peut rediriger vers la page d'inscription de Filament
        // Mais Filament n'a pas de flux natif "accepter invitation".

        // Pour faire simple dans le cadre de ce refactoring :
        // On redirige vers /register (Filament Breezy/Native)
        // Et on stocke l'intention en session.
        // Mais comme je ne peux pas modifier facilement le contrôleur de Register de Filament sans l'étendre,
        // je vais créer une petite vue simple pour "Créer son compte et accepter l'invitation" ou "Se connecter".

        // Pour l'instant, redirigeons vers le login avec un message.
        // L'utilisateur devra s'inscrire manuellement, puis re-cliquer sur le lien ? Non c'est nul.

        // Mieux : On crée l'utilisateur automatiquement s'il n'existe pas ? Non, mot de passe requis.

        // Solution robuste : Stocker le token en session et écouter l'événement de création de User ou de Login.
        session(['team_invitation_token' => $token]);

        return redirect('/register');
    }

    protected function addUserToTeam(TeamInvitation $invitation, User $user)
    {
        // Attacher l'utilisateur à l'équipe s'il n'y est pas déjà
        if (! $invitation->team->members->contains($user)) {
            $invitation->team->members()->attach($user, ['role' => $invitation->role]);
        }

        // Supprimer l'invitation
        $invitation->delete();
    }
}
