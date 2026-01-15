<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Cancel a pending team join request.
     */
    public function cancelRequest(Request $request, Team $team)
    {
        // 1. Sécurité : On vérifie que l'utilisateur est bien lié à l'équipe (même en attente)
        if (!$request->user()->teams()->where('team_id', $team->id)->exists()) {
            abort(403);
        }

        // 2. On retire l'utilisateur de l'équipe
        $team->removeUser($request->user());

        // 3. Si c'était son équipe active, on remet à NULL pour éviter le bug d'affichage
        if ($request->user()->current_team_id === $team->id) {
            $request->user()->forceFill(['current_team_id' => null])->save();
        }

        return redirect()->route('dashboard');
    }
}
