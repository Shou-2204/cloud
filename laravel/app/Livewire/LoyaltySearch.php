<?php

namespace App\Livewire;

use App\Helpers\PhoneHelper;
use App\Models\CrmContact;
use App\Models\LoyaltyRedemption;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LoyaltySearch extends Component
{
    public string $search = '';
    public ?CrmContact $selectedContact = null;
    
    // Pour le programme à points
    public $pointsToAdd = null;
    
    // Pour l'annulation
    public $lastAction = null;

    public function updatedSearch()
    {
        $this->selectedContact = null;
        $this->pointsToAdd = null;
        $this->lastAction = null;

        $contacts = $this->contacts;
        if ($contacts->count() === 1) {
            $this->selectContact($contacts->first()->id);
        }
    }

    public function selectContact(string $id)
    {
        $team = Auth::user()->currentTeam;
        $this->selectedContact = CrmContact::where('team_id', $team->id)->findOrFail($id);
        $this->pointsToAdd = null;
        $this->lastAction = null;
    }

    public function clearSelection()
    {
        $this->selectedContact = null;
        $this->search = '';
        $this->pointsToAdd = null;
        $this->lastAction = null;
    }

    public function getContactsProperty()
    {
        if (strlen($this->search) < 2) {
            return collect();
        }

        $team = Auth::user()->currentTeam;
        $rawTerm = '%' . $this->search . '%';

        // Smart phone search: normalize input to E.164 so "0786118330" matches "+33786118330"
        $stripped = preg_replace('/[\s\-\.]/', '', $this->search);
        $normalizedPhone = PhoneHelper::toE164($stripped);

        return CrmContact::where('team_id', $team->id)
            ->where(function ($q) use ($rawTerm, $normalizedPhone, $stripped) {
                $q->where('name', 'LIKE', $rawTerm)
                  ->orWhere('email', 'LIKE', $rawTerm)
                  ->orWhere('pass_token', 'LIKE', $rawTerm);

                // Search phone with both raw input and E.164 normalized version
                $q->orWhere('phone', 'LIKE', $rawTerm);

                if ($normalizedPhone && $normalizedPhone !== $stripped) {
                    $q->orWhere('phone', $normalizedPhone);
                }
            })
            ->orderBy('name')
            ->limit(20)
            ->get();
    }

    public function recordVisit()
    {
        if (!$this->selectedContact) return;

        $team = Auth::user()->currentTeam;
        
        // Add 1 point/visit
        $this->selectedContact->increment('loyalty_points', 1);
        $this->selectedContact->update(['last_scanned_at' => now()]);
        
        $team->settings->update(['last_loyalty_scan_at' => now()]);
        
        $this->lastAction = ['type' => 'add', 'amount' => 1];
        
        $this->dispatch('visit-recorded');
    }

    public function addPoints()
    {
        if (!$this->selectedContact || !$this->pointsToAdd) return;

        $team = Auth::user()->currentTeam;
        
        $this->validate([
            'pointsToAdd' => ['required', 'integer', 'min:1', 'max:100000']
        ]);

        $this->selectedContact->increment('loyalty_points', $this->pointsToAdd);
        $this->selectedContact->update(['last_scanned_at' => now()]);
        
        $team->settings->update(['last_loyalty_scan_at' => now()]);
        
        $this->lastAction = ['type' => 'add', 'amount' => $this->pointsToAdd];
        
        $this->pointsToAdd = null;
        $this->dispatch('points-added');
    }

    public function undoLastAction()
    {
        if (!$this->selectedContact || !$this->lastAction) {
            return;
        }

        if ($this->lastAction['type'] === 'add') {
            $amount = $this->lastAction['amount'];
            if ($this->selectedContact->loyalty_points >= $amount) {
                $this->selectedContact->decrement('loyalty_points', $amount);
            } else {
                $this->selectedContact->update(['loyalty_points' => 0]);
            }
        } elseif ($this->lastAction['type'] === 'consume') {
            $this->selectedContact->increment('loyalty_points', $this->lastAction['amount']);
            
            // Delete the tracking record if it exists
            if (isset($this->lastAction['redemption_id'])) {
                LoyaltyRedemption::where('id', $this->lastAction['redemption_id'])->delete();
            }
        }
        
        $this->lastAction = null;
        $this->dispatch('action-undone');
    }

    public function consumeReward($rewardId)
    {
        if (!$this->selectedContact) return;
        
        $team = Auth::user()->currentTeam;
        $reward = $team->loyaltyRewards()->findOrFail($rewardId);

        if ($this->selectedContact->loyalty_points >= $reward->points_required) {
            $this->selectedContact->decrement('loyalty_points', $reward->points_required);
            
            // Log the redemption
            $redemption = LoyaltyRedemption::create([
                'team_id' => $team->id,
                'crm_contact_id' => $this->selectedContact->id,
                'loyalty_reward_id' => $reward->id,
                'points_spent' => $reward->points_required,
            ]);
            
            $this->lastAction = [
                'type' => 'consume', 
                'amount' => $reward->points_required,
                'redemption_id' => $redemption->id,
            ];
            $this->dispatch('reward-consumed');
        }
    }

    public function copyMagicLink()
    {
        if (!$this->selectedContact) {
            return;
        }

        $team = \App\Models\Team::find($this->selectedContact->team_id);
        
        $magicLink = \Illuminate\Support\Facades\URL::temporarySignedRoute(
            'profile.loyalty',
            now()->addHours(24),
            ['team' => $team->public_uuid, 'contact' => $this->selectedContact->id]
        );

        $shlinkService = app(\App\Services\ShlinkService::class);
        // Shorten the URL and set it to expire in 24 hours
        $shortUrl = $shlinkService->createShortUrl($magicLink, ['magic-link', 'loyalty'], now()->addHours(24));

        $finalUrl = $shortUrl ?? $magicLink;

        $this->dispatch('magic-link-generated', url: $finalUrl);
    }

    public function render()
    {
        return view('livewire.loyalty-search', [
            'teamLoyaltyProgram' => Auth::user()->currentTeam->settings->loyalty_program_type ?? null,
            'rewards' => Auth::user()->currentTeam->loyaltyRewards()->orderBy('points_required')->get() ?? collect(),
        ])->layout('layouts.app');
    }
}
