<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TeamLoyaltySettings extends Component
{
    public $team;
    public $state = [];
    public $newReward = ['name' => '', 'points_required' => '', 'icon' => 'gift'];
    public $confirmingProgramChange = false;
    public $newProgramType = null;
    public $confirmingRewardDeletion = false;
    public $rewardToDelete = null;

    /**
     * Mount the component.
     */
    public function mount(\App\Models\Team $team)
    {
        $this->team = $team;
        $exp = $team->settings->loyalty_points_expiration_date ?? '12-31';
        $currentYear = date('Y');

        $this->state = [
            'loyalty_enabled' => $team->settings->loyalty_enabled ?? false,
            'loyalty_program_type' => $team->settings->loyalty_program_type ?? null,
            'loyalty_points_expire' => $team->settings->loyalty_points_expire ?? false,
            'loyalty_points_expiration_date' => $currentYear . '-' . $exp,
        ];
    }

    public function selectProgramType($type)
    {
        if (!in_array($type, ['visits', 'points'])) {
            return;
        }

        if ($this->team->settings && 
            $this->team->settings->loyalty_program_type && 
            $this->team->settings->loyalty_program_type !== $type) {
            
            $this->newProgramType = $type;
            $this->confirmingProgramChange = true;
            return;
        }

        $this->state['loyalty_program_type'] = $type;
        $this->updateLoyaltySettings();
    }

    public function changeProgramAndResetPoints()
    {
        DB::transaction(function () {
            // Reset customer points
            $this->team->crmContacts()->update(['loyalty_points' => 0]);
            
            // Soft-delete all rewards for the team (using Eloquent to respect SoftDeletes)
            $this->team->loyaltyRewards->each->delete();
        });

        $this->state['loyalty_program_type'] = $this->newProgramType;
        $this->updateLoyaltySettings();
        $this->confirmingProgramChange = false;
        $this->newProgramType = null;
    }

    /**
     * Update the team loyalty settings.
     */
    public function updateLoyaltySettings()
    {
        $this->resetErrorBag();

        \Illuminate\Support\Facades\Gate::forUser($this->team->owner)->authorize('update', $this->team);

        $validated = $this->validate([
            'state.loyalty_enabled' => ['boolean'],
            'state.loyalty_program_type' => ['nullable', 'in:visits,points'],
            'state.loyalty_points_expire' => ['boolean'],
            'state.loyalty_points_expiration_date' => ['required_if:state.loyalty_points_expire,true', 'nullable', 'date'],
        ]);

        $expirationDate = null;
        if (!empty($validated['state']['loyalty_points_expiration_date'])) {
            $dateString = $validated['state']['loyalty_points_expiration_date'];
            // Extract MM-DD from YYYY-MM-DD
            if (strlen($dateString) >= 10) {
                $expirationDate = substr($dateString, 5, 5); 
            }
        }

        // Settings Updates
        $this->team->settings()->updateOrCreate([], [
            'loyalty_enabled' => $validated['state']['loyalty_enabled'],
            'loyalty_program_type' => $validated['state']['loyalty_program_type'],
            'loyalty_points_expire' => $validated['state']['loyalty_points_expire'],
            'loyalty_points_expiration_date' => $expirationDate,
        ]);

        $this->dispatch('saved');
    }

    // Rewards Management
    public function addReward()
    {
        $this->resetErrorBag('newReward');
        
        if ($this->team->loyaltyRewards()->count() >= 10) {
            $this->addError('newReward.name', 'Vous avez atteint la limite de 10 récompenses actives.');
            return;
        }
        
        $this->validate([
            'newReward.name' => ['required', 'string', 'max:255'],
            'newReward.points_required' => ['required', 'integer', 'min:1'],
            'newReward.icon' => ['required', 'string', 'max:50'],
        ], [], [
            'newReward.name' => 'nom de la récompense',
            'newReward.points_required' => 'nombre de ' . ($this->state['loyalty_program_type'] === 'visits' ? 'visites' : 'points') . ' requis',
            'newReward.icon' => 'icône',
        ]);

        \App\Models\LoyaltyReward::create([
            'team_id' => $this->team->id,
            'name' => $this->newReward['name'],
            'points_required' => $this->newReward['points_required'],
            'icon' => $this->newReward['icon'],
        ]);

        $this->newReward = ['name' => '', 'points_required' => '', 'icon' => 'gift'];
        $this->dispatch('reward-added');
    }

    public function confirmDeleteReward($id)
    {
        $this->rewardToDelete = $id;
        $this->confirmingRewardDeletion = true;
    }

    public function deleteReward()
    {
        if (!$this->rewardToDelete) return;

        $reward = \App\Models\LoyaltyReward::where('team_id', $this->team->id)->findOrFail($this->rewardToDelete);
        $reward->delete();
        $this->dispatch('reward-deleted');
        $this->confirmingRewardDeletion = false;
        $this->rewardToDelete = null;
    }

    public function getRewardsProperty()
    {
        return \App\Models\LoyaltyReward::where('team_id', $this->team->id)
            ->orderBy('points_required')
            ->get();
    }

    public function render()
    {
        return view('livewire.team-loyalty-settings');
    }
}
