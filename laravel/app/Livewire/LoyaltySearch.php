<?php

namespace App\Livewire;

use App\Helpers\PhoneHelper;
use App\Models\CrmContact;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LoyaltySearch extends Component
{
    public string $search = '';
    public ?CrmContact $selectedContact = null;

    public function updatedSearch()
    {
        $this->selectedContact = null;
    }

    public function selectContact(string $id)
    {
        $team = Auth::user()->currentTeam;
        $this->selectedContact = CrmContact::where('team_id', $team->id)->findOrFail($id);
    }

    public function clearSelection()
    {
        $this->selectedContact = null;
        $this->search = '';
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
        return view('livewire.loyalty-search')->layout('layouts.app');
    }
}
