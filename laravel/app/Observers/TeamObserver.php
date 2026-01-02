<?php

namespace App\Observers;

use App\Models\Team;
use App\Notifications\TeamActivityLog;

class TeamObserver
{
    /**
     * Log quand une équipe est CRÉÉE
     */
    public function created(Team $team): void
    {
        // On notifie le propriétaire
        $team->owner->notify(new TeamActivityLog('team_created', [
            'team_id' => $team->id,
            'team_name' => $team->name,
        ]));
    }

    /**
     * Log quand une équipe est RENOMMÉE
     */
    public function updated(Team $team): void
    {
        // On vérifie si le nom a changé (pour ne pas logger d'autres petites modifs)
        if ($team->isDirty('name')) {
            $originalName = $team->getOriginal('name');

            $team->owner->notify(new TeamActivityLog('team_renamed', [
                'team_id' => $team->id,
                'old_name' => $originalName,
                'new_name' => $team->name,
            ]));
        }
    }

    /**
     * Log quand une équipe est SUPPRIMÉE
     */
    public function deleted(Team $team): void
    {
        // Attention : l'équipe n'existe plus, mais l'objet User du propriétaire existe encore
        $team->owner->notify(new TeamActivityLog('team_deleted', [
            'team_id' => $team->id, // On garde l'ID pour archive
            'team_name' => $team->name,
        ]));
    }
}
