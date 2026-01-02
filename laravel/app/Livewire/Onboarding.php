<?php

namespace App\Livewire;

use App\Models\Team;
use App\Notifications\TeamActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Onboarding extends Component
{
    public $newTeamName = '';
    public $joinCode = '';

    public function mount()
    {
        if (request()->has('join')) {
            $this->joinCode = request()->get('join');
        }
    }

    public function createTeam()
    {
        $this->validate(['newTeamName' => 'required|string|min:3']);
        $user = Auth::user();
        
        // Note: L'Observer TeamObserver détectera automatiquement cette création
        // et enverra la notification 'team_created'. Pas besoin de code ici.
        $team = $user->ownedTeams()->create([
            'name' => $this->newTeamName,
            'personal_team' => false,
        ]);
        
        $user->current_team_id = $team->id;
        $user->save();
        
        return redirect()->route('dashboard');
    }

    public function joinTeam()
    {
        $this->validate(['joinCode' => 'required|exists:teams,join_code']);

        $user = Auth::user();
        $team = Team::where('join_code', $this->joinCode)->first();

        $exists = DB::table('team_user')
                    ->where('team_id', $team->id)
                    ->where('user_id', $user->id)
                    ->exists();

        if ($exists || $team->owner_id === $user->id) {
             $user->current_team_id = $team->id;
             $user->save();
             return redirect()->route('dashboard');
        }

        DB::table('team_user')->insert([
            'team_id' => $team->id,
            'user_id' => $user->id,
            'role' => 'editor',
            'is_approved' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // LOGGING MANUEL (Requis car DB::insert ne déclenche pas d'events)
        $team->owner->notify(new TeamActivityLog('join_request_pending', [
            'team_name' => $team->name,
            'user_email' => $user->email,
            'via' => 'onboarding'
        ]));

        $user->current_team_id = $team->id;
        $user->save();

        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.onboarding');
    }
}