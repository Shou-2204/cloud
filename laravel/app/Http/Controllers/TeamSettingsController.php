<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Laravel\Jetstream\Jetstream;

class TeamSettingsController extends Controller
{
    /**
     * Show the team settings screen.
     *
     * @param  mixed  $team
     * @return \Illuminate\View\View
     */
    public function show(Request $request, $teamId, string $tab = 'general')
    {
        $team = $teamId;
        if (! $team instanceof \App\Models\Team) {
            $team = Jetstream::newTeamModel()->findOrFail($teamId);
        }

        if (Gate::denies('view', $team)) {
            abort(403);
        }

        $tabs = [
            'general' => 'Informations générales',
            'public-profile' => 'Profil public',
            'reviews' => 'Gestion des avis',
            'members' => 'Membres',
        ];

        if (! array_key_exists($tab, $tabs)) {
            abort(404);
        }

        return view('teams.settings', [
            'user' => $request->user(),
            'team' => $team,
            'activeTab' => $tab,
            'tabs' => $tabs,
        ]);
    }
}
