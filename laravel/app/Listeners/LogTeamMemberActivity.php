<?php

namespace App\Listeners;

use App\Notifications\TeamActivityLog;
use Laravel\Jetstream\Events\InvitingTeamMember;
use Laravel\Jetstream\Events\TeamMemberAdded;

class LogTeamMemberActivity
{
    public function handleTeamMemberAdded(TeamMemberAdded $event): void
    {
        $event->team->owner->notify(new TeamActivityLog('member_joined', [
            'team_id' => $event->team->id,
            'team_name' => $event->team->name,
            'user_email' => $event->user->email,
        ]));
    }

    public function handleInvitingTeamMember(InvitingTeamMember $event): void
    {
        $event->team->owner->notify(new TeamActivityLog('member_invited', [
            'team_id' => $event->team->id,
            'invited_email' => $event->email,
        ]));
    }
}
