<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Team;
use App\Notifications\TeamActivityLog;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

/**
 * Gère l'approbation et le refus des membres en attente.
 * Les actions sont logguées en base de données via TeamActivityLog.
 */
class TeamJoinRequests extends Component
{
    public int $teamId;

    protected $listeners = ['saved' => '$refresh'];

    public function mount($teamId)
    {
        $this->teamId = $teamId;
    }

    public function getPendingUsersProperty()
    {
        $ids = DB::table('team_user')
            ->where('team_id', $this->teamId)
            ->where('is_approved', 0)
            ->pluck('user_id');

        if ($ids->isEmpty()) {
            return collect();
        }

        return User::whereIn('id', $ids)->get();
    }

    public function approve($userId)
    {
        DB::table('team_user')
            ->where('team_id', $this->teamId)
            ->where('user_id', $userId)
            ->update(['is_approved' => 1]);

        $team = Team::find($this->teamId);
        $user = User::find($userId);

        if ($team && $user) {
            $team->owner->notify(new TeamActivityLog('member_approved', [
                'team_name' => $team->name,
                'user_email' => $user->email,
                'user_id' => $user->id,
            ]));

            $user->notify(new TeamActivityLog('request_accepted', [
                'team_name' => $team->name
            ]));
        }

        $this->dispatch('saved');
        
        return redirect()->route('teams.show', $this->teamId);
    }

    public function deny($userId)
    {
        $user = User::find($userId);
        $team = Team::find($this->teamId);

        if ($user && $team) {
            $team->owner->notify(new TeamActivityLog('member_denied', [
                'team_name' => $team->name,
                'denied_email' => $user->email,
            ]));

            if ($user->current_team_id == $this->teamId) {
                $user->forceFill([
                    'current_team_id' => null,
                ])->save();
            }

            DB::table('team_user')
                ->where('team_id', $this->teamId)
                ->where('user_id', $userId)
                ->delete();
        }

        $this->dispatch('saved');

        return redirect()->route('teams.show', $this->teamId);
    }

    public function render()
    {
        return view('livewire.team-join-requests');
    }
}