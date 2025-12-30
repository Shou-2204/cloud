<?php

namespace App\Actions\Jetstream;

use App\Models\Team;
use Laravel\Jetstream\Contracts\DeletesTeams;

class DeleteTeam implements DeletesTeams
{
    /**
     * Delete the given team.
     */
    public function delete(Team $team): void
    {
        // On retire la validation pour autoriser la suppression de l'équipe perso
        // $this->validate($team);

        $team->purge();
    }
}