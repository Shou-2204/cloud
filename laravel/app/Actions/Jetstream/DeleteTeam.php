<?php

/*
 * Action de suppression d'équipe.
 * Vérifie l'absence d'abonnement actif avant de purger les données.
 * Autorise la suppression des équipes personnelles si la condition d'abonnement est respectée.
 */

namespace App\Actions\Jetstream;

use App\Models\Team;
use Illuminate\Validation\ValidationException;
use Laravel\Jetstream\Contracts\DeletesTeams;

class DeleteTeam implements DeletesTeams
{
    public function delete(Team $team): void
    {
        if ($team->subscribed()) {
            throw ValidationException::withMessages([
                'team' => 'Impossible de supprimer cette équipe car un abonnement est en cours. Veuillez le résilier avant de continuer.',
            ]);
        }

        $team->purge();
    }
}