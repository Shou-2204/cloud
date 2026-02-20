<?php

namespace App\Livewire;

use App\Helpers\PhoneHelper;
use App\Models\Team;
use App\Models\CrmContact;
use Livewire\Component;

class JoinLoyaltyProgram extends Component
{
    public Team $team;
    
    public $name = '';
    public $email = '';
    public $phone = '';
    public $opt_in_loyalty = true;
    public $opt_in_marketing = false;

    /** @var string|false 'new'|'returning'|false */
    public $successMessage = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'nullable|email|max:255',
        'phone' => ['nullable', 'phone:FR'],
        'opt_in_loyalty' => 'accepted', // Must accept loyalty terms
        'opt_in_marketing' => 'boolean',
    ];

    public function mount(Team $team)
    {
        $this->team = $team;
    }

    public function submit()
    {
        $this->validate();

        if (empty($this->email) && empty($this->phone)) {
            $this->addError('contact', 'Veuillez fournir une adresse email ou un numéro de téléphone.');
            return;
        }

        // Normalize phone to E.164
        $normalizedPhone = PhoneHelper::toE164($this->phone);

        // Upsert by either email or phone depending on what's available
        $contact = null;
        if (!empty($this->email)) {
            $contact = CrmContact::where('team_id', $this->team->id)->where('email', $this->email)->first();
        }
        
        if (!$contact && !empty($normalizedPhone)) {
            $contact = CrmContact::where('team_id', $this->team->id)->where('phone', $normalizedPhone)->first();
        }

        $this->successMessage = $contact ? 'returning' : 'new';

        if ($contact) {
            $contact->update([
                'name' => $this->name,
                'phone' => $normalizedPhone ?: $contact->phone,
                'email' => $this->email ?: $contact->email,
                'opt_in_loyalty' => $this->opt_in_loyalty,
                'opt_in_marketing' => $this->opt_in_marketing,
            ]);
        } else {
            CrmContact::create([
                'team_id' => $this->team->id,
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $normalizedPhone,
                'opt_in_loyalty' => $this->opt_in_loyalty,
                'opt_in_marketing' => $this->opt_in_marketing,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.join-loyalty-program');
    }
}
