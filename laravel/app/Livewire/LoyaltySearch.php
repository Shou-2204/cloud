<?php

namespace App\Livewire;

use App\Helpers\PhoneHelper;
use App\Jobs\AppleWalletPushJob;
use App\Models\CrmContact;
use App\Models\LoyaltyRedemption;
use App\Services\LoyaltyProgressService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class LoyaltySearch extends Component
{
    public string $search = '';
    public ?CrmContact $selectedContact = null;
    
    // Pour le programme à points
    public $pointsToAdd = null;
    
    // Pour l'annulation
    public $lastAction = null;

    // Cached values (loaded once in mount/selectContact)
    public $teamLoyaltyProgram = null;

    public function mount()
    {
        $team = Auth::user()->currentTeam;
        $this->teamLoyaltyProgram = $team->settings->loyalty_program_type ?? null;
    }

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

    public function getRewardsProperty()
    {
        return Auth::user()->currentTeam->loyaltyRewards()
            ->orderBy('points_required')
            ->get();
    }

    public function recordVisit()
    {
        if (!$this->selectedContact) return;

        $team = Auth::user()->currentTeam;
        Gate::authorize('update', $team);

        DB::transaction(function () use ($team) {
            // Refresh to get the latest data
            $this->selectedContact->refresh();

            $this->selectedContact->increment('loyalty_points', 1);
            $this->selectedContact->update(['last_scanned_at' => now()]);
            
            $team->settings->update(['last_loyalty_scan_at' => now()]);
        });
        
        $this->selectedContact->refresh();
        $this->lastAction = ['type' => 'add', 'amount' => 1];
        
        $this->dispatch('visit-recorded');
        AppleWalletPushJob::dispatch($this->selectedContact);
    }

    public function addPoints()
    {
        if (!$this->selectedContact || !$this->pointsToAdd) return;

        $team = Auth::user()->currentTeam;
        Gate::authorize('update', $team);

        // Guard: only allow arbitrary point additions in 'points' mode
        if ($this->teamLoyaltyProgram !== 'points') {
            return;
        }

        $this->validate([
            'pointsToAdd' => ['required', 'integer', 'min:1', 'max:100000']
        ]);

        $amount = (int) $this->pointsToAdd;

        DB::transaction(function () use ($team, $amount) {
            $this->selectedContact->refresh();

            $this->selectedContact->increment('loyalty_points', $amount);
            $this->selectedContact->update(['last_scanned_at' => now()]);
            
            $team->settings->update(['last_loyalty_scan_at' => now()]);
        });
        
        $this->selectedContact->refresh();
        $this->lastAction = ['type' => 'add', 'amount' => $amount];
        
        $this->pointsToAdd = null;
        $this->dispatch('points-added');
        AppleWalletPushJob::dispatch($this->selectedContact);
    }

    public function undoLastAction()
    {
        if (!$this->selectedContact || !$this->lastAction) {
            return;
        }

        $team = Auth::user()->currentTeam;
        Gate::authorize('update', $team);

        DB::transaction(function () use ($team) {
            $this->selectedContact->refresh();

            if ($this->lastAction['type'] === 'add') {
                $amount = $this->lastAction['amount'];
                if ($this->selectedContact->loyalty_points >= $amount) {
                    $this->selectedContact->decrement('loyalty_points', $amount);
                } else {
                    $this->selectedContact->update(['loyalty_points' => 0]);
                }
            } elseif ($this->lastAction['type'] === 'consume') {
                $this->selectedContact->increment('loyalty_points', $this->lastAction['amount']);
                
                // Delete the tracking record — scoped to team for ownership safety
                if (isset($this->lastAction['redemption_id'])) {
                    LoyaltyRedemption::where('id', $this->lastAction['redemption_id'])
                        ->where('team_id', $team->id)
                        ->delete();
                }
            }
        });
        
        $this->selectedContact->refresh();
        $this->lastAction = null;
        $this->dispatch('action-undone');
        AppleWalletPushJob::dispatch($this->selectedContact);
    }

    public function consumeReward($rewardId)
    {
        if (!$this->selectedContact) return;
        
        $team = Auth::user()->currentTeam;
        Gate::authorize('update', $team);

        $reward = $team->loyaltyRewards()->findOrFail($rewardId);

        $redemption = DB::transaction(function () use ($team, $reward) {
            // Lock the contact row to prevent race conditions (double-click, multiple tabs)
            $contact = CrmContact::where('id', $this->selectedContact->id)->lockForUpdate()->first();

            if ($contact->loyalty_points < $reward->points_required) {
                return null; // Not enough points after re-check
            }

            $contact->decrement('loyalty_points', $reward->points_required);
            
            // Log the redemption with denormalized reward name
            return LoyaltyRedemption::create([
                'team_id' => $team->id,
                'crm_contact_id' => $contact->id,
                'loyalty_reward_id' => $reward->id,
                'reward_name' => $reward->name,
                'points_spent' => $reward->points_required,
            ]);
        });

        if ($redemption) {
            $this->selectedContact->refresh();
            $this->lastAction = [
                'type' => 'consume', 
                'amount' => $reward->points_required,
                'redemption_id' => $redemption->id,
            ];
            $this->dispatch('reward-consumed');
            AppleWalletPushJob::dispatch($this->selectedContact);
        }
    }

    public function copyMagicLink()
    {
        if (!$this->selectedContact) {
            return;
        }

        $team = \App\Models\Team::find($this->selectedContact->team_id);

        // Reset the one-time flag so this new link works
        $this->selectedContact->update(['magic_link_used_at' => null]);
        
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
        $rewards = $this->rewards;
        $progress = null;

        if ($this->selectedContact && $this->teamLoyaltyProgram) {
            $progress = LoyaltyProgressService::getProgress(
                $this->selectedContact,
                $this->teamLoyaltyProgram,
                $rewards
            );
        }

        return view('livewire.loyalty-search', [
            'teamLoyaltyProgram' => $this->teamLoyaltyProgram,
            'rewards' => $rewards,
            'progress' => $progress,
        ])->layout('layouts.app');
    }
}
