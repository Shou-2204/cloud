<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

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

        $this->dispatch('saved');
        
        // CORRECTION ICI : Redirection propre vers la page de l'équipe
        return redirect()->route('teams.show', $this->teamId);
    }

    public function deny($userId)
    {
        $user = User::find($userId);

        if ($user) {
            // 1. NETTOYAGE CRITIQUE :
            // Si l'utilisateur a cette équipe définie comme "Équipe actuelle", on lui retire.
            // Sinon, il verra toujours le nom de l'équipe en haut à droite (fantôme).
            if ($user->current_team_id == $this->teamId) {
                $user->forceFill([
                    'current_team_id' => null,
                ])->save();
            }

            // 2. SUPPRESSION DU LIEN
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