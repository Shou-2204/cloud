<?php

namespace App\Filament\Resources\Teams\Pages;

use App\Filament\Resources\Teams\TeamResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTeam extends CreateRecord
{
    protected static string $resource = TeamResource::class;

    protected function afterCreate(): void
    {
        $team = $this->record;
        $user = $team->owner;

        // Ensure the owner is attached to the team members list as approved (if logic requires it)
        // Check if already attached to avoid duplicates? BelongsToMany syncWithoutDetaching is safer.
        // Assuming 'role' is 'admin' or similar for owner standard Jetstream.
        $team->users()->attach($user, ['role' => 'admin', 'is_approved' => true]);

        // Switch the owner's current team to this new team
        $user->switchTeam($team);
    }
}
