<?php

namespace App\Livewire;

use App\Jobs\AppleWalletPushJob;
use App\Models\CrmContact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class WalletCampaign extends Component
{
    public string $message = '';
    public bool $isSending = false;

    public function mount()
    {
        $team = Auth::user()->currentTeam;
        $this->message = $team->walletPassSettings->campaign_message ?? '';
    }

    public function sendCampaign()
    {
        $team = Auth::user()->currentTeam;
        Gate::authorize('update', $team);

        $this->validate([
            'message' => 'required|string|max:255',
        ]);

        $this->isSending = true;

        // 1. Save the message globally for the team's passes
        $settings = $team->walletPassSettings;
        if (!$settings->exists) {
            $settings->team_id = $team->id;
        }
        $settings->campaign_message = $this->message;
        $settings->save();

        // 2. Find all contacts with wallet registrations
        // This is a simplified approach: we notify all contacts of the team.
        // The service logic handles skipping those with no devices.
        $contacts = CrmContact::where('team_id', $team->id)
            ->whereNotNull('wallet_auth_token')
            ->get();

        foreach ($contacts as $contact) {
            // Important: refresh updated_at so getUpdatedSerials detects the change
            $contact->touch();
            AppleWalletPushJob::dispatch($contact);
        }

        $this->isSending = false;
        session()->flash('success', 'Votre campagne a été envoyée avec succès à ' . $contacts->count() . ' clients !');
        
        $this->dispatch('campaign-sent');
    }

    public function render()
    {
        return view('livewire.wallet-campaign')->layout('layouts.app');
    }
}
