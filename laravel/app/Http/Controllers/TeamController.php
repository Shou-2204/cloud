<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Handles team-related operations.
 */
class TeamController extends Controller
{
    /**
     * Redirect to user's current team settings page.
     */
    public function redirectToCurrentTeam(): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (! $user->current_team_id) {
            return redirect()->route('onboarding');
        }

        return redirect()->route('teams.show', $user->current_team_id);
    }

    /**
     * Cancel a pending team join request.
     */
    public function cancelRequest(Request $request, Team $team): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        // Security: Verify user is linked to team
        if (! $user->teams()->where('team_id', $team->id)->exists()) {
            abort(403);
        }

        // Remove user from team
        $team->removeUser($user);

        // Reset current team if it was this one
        if ($user->current_team_id === $team->id) {
            $user->forceFill(['current_team_id' => null])->save();
        }

        return redirect()->route('dashboard');
    }
}
