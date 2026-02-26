<?php

namespace App\Livewire;

use App\Helpers\PhoneHelper;
use App\Models\CrmContact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class LoyaltyAddClient extends Component
{
    public $newClient = [
        'name' => '',
        'email' => '',
        'phone' => '',
        'date_of_birth' => null,
        'pass_token' => '',
        'opt_in_loyalty' => true,
        'opt_in_marketing' => false,
    ];

    public ?string $addClientSuccess = null;
    public ?string $addClientError = null;

    public function resetForm()
    {
        $this->newClient = [
            'name' => '',
            'email' => '',
            'phone' => '',
            'date_of_birth' => null,
            'pass_token' => '',
            'opt_in_loyalty' => true,
            'opt_in_marketing' => false,
        ];
        $this->addClientSuccess = null;
        $this->addClientError = null;
    }

    public function setPassToken($token)
    {
        $this->newClient['pass_token'] = $token;
    }

    public function addClient()
    {
        $team = Auth::user()->currentTeam;
        Gate::authorize('update', $team);

        $this->addClientSuccess = null;
        $this->addClientError = null;

        $this->validate([
            'newClient.name' => ['required', 'string', 'max:255'],
            'newClient.email' => ['nullable', 'email', 'max:255'],
            'newClient.phone' => ['nullable', 'string', 'max:30'],
            'newClient.date_of_birth' => ['nullable', 'date', 'before:today'],
            'newClient.pass_token' => ['nullable', 'string', 'max:255'],
            'newClient.opt_in_loyalty' => ['boolean'],
            'newClient.opt_in_marketing' => ['boolean'],
        ], [], [
            'newClient.name' => 'nom',
            'newClient.email' => 'email',
            'newClient.phone' => 'téléphone',
            'newClient.date_of_birth' => 'date de naissance',
            'newClient.pass_token' => 'code carte',
        ]);

        if (empty($this->newClient['email']) && empty($this->newClient['phone'])) {
            $this->addError('newClient.email', 'Veuillez fournir un email ou un numéro de téléphone.');
            return;
        }

        $normalizedPhone = PhoneHelper::toE164($this->newClient['phone']);

        // Check for existing contact
        if (!empty($this->newClient['email'])) {
            $existing = CrmContact::where('team_id', $team->id)->where('email', $this->newClient['email'])->first();
            if ($existing) {
                $this->addClientError = 'Un client avec cet email existe déjà.';
                return;
            }
        }
        if (!empty($normalizedPhone)) {
            $existing = CrmContact::where('team_id', $team->id)->where('phone', $normalizedPhone)->first();
            if ($existing) {
                $this->addClientError = 'Un client avec ce numéro de téléphone existe déjà.';
                return;
            }
        }

        // Check pass_token uniqueness
        if (!empty($this->newClient['pass_token'])) {
            $existing = CrmContact::where('team_id', $team->id)->where('pass_token', $this->newClient['pass_token'])->first();
            if ($existing) {
                $this->addClientError = 'Ce code carte est déjà associé à un autre client.';
                return;
            }
        }

        $contact = CrmContact::create([
            'team_id' => $team->id,
            'name' => $this->newClient['name'],
            'email' => $this->newClient['email'] ?: null,
            'phone' => $normalizedPhone ?: null,
            'date_of_birth' => $this->newClient['date_of_birth'] ?: null,
            'pass_token' => $this->newClient['pass_token'] ?: null,
            'opt_in_loyalty' => $this->newClient['opt_in_loyalty'],
            'opt_in_marketing' => $this->newClient['opt_in_marketing'],
        ]);

        // Generate pass token if none was provided
        if (empty($contact->pass_token)) {
            $service = new \App\Services\GeneratePassTokenService();
            $service->assignToken($contact);
        }

        $this->addClientSuccess = $contact->name;
        $this->newClient = [
            'name' => '',
            'email' => '',
            'phone' => '',
            'date_of_birth' => null,
            'pass_token' => '',
            'opt_in_loyalty' => true,
            'opt_in_marketing' => false,
        ];
    }

    public function render()
    {
        return view('livewire.loyalty-add-client')->layout('layouts.app');
    }
}
