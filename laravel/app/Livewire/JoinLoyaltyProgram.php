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
    public $date_of_birth = null;
    public $opt_in_loyalty = true;
    public $opt_in_marketing = false;
    public $loyalty_points = 0;

    /** @var string|false 'new'|'returning'|false */
    public $successMessage = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'nullable|email|max:255',
        'phone' => ['nullable', 'phone:FR'],
        'date_of_birth' => 'nullable|date|before:today',
        'opt_in_loyalty' => 'accepted',
        'opt_in_marketing' => 'boolean',
    ];

    public ?string $contactUuid = null;
    public ?string $createdContactId = null;
    public bool $isMagicLink = false;

    public function mount(Team $team)
    {
        $this->team = $team;
        
        // Vérifier si c'est un magic link signé
        if (request()->hasValidSignature() && request()->has('contact')) {
            $this->contactUuid = request()->query('contact');
            
            // Pré-remplir les infos si le client existe
            $contact = CrmContact::where('team_id', $this->team->id)
                ->where('id', $this->contactUuid)
                ->first();
                
            if ($contact) {
                // Check if magic link was already used (one-time token)
                if ($contact->magic_link_used_at) {
                    $this->successMessage = 'expired';
                    return;
                }

                $this->isMagicLink = true;
                $this->name = $contact->name;
                $this->email = $contact->email;
                $this->phone = $contact->phone;
                $this->date_of_birth = $contact->date_of_birth ? \Carbon\Carbon::parse($contact->date_of_birth)->format('Y-m-d') : null;
                $this->opt_in_loyalty = (bool) $contact->opt_in_loyalty;
                $this->opt_in_marketing = (bool) $contact->opt_in_marketing;
                $this->loyalty_points = $contact->loyalty_points;
            }
        }
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

        // Si on est en mode "Magic Link" validé
        if ($this->isMagicLink && $this->contactUuid) {
            $contact = CrmContact::where('team_id', $this->team->id)->where('id', $this->contactUuid)->first();
            
            if ($contact) {
                $contact->update([
                    'name' => $this->name,
                    'phone' => $normalizedPhone,
                    'email' => $this->email,
                    'date_of_birth' => $this->date_of_birth,
                    'opt_in_loyalty' => $this->opt_in_loyalty,
                    'opt_in_marketing' => $this->opt_in_marketing,
                    'magic_link_used_at' => now(), // Invalidate the magic link (one-time use)
                ]);
                $this->createdContactId = $contact->id;
                $this->successMessage = 'updated';

                $this->dispatch('passCreated', [
                    'downloadUrl' => route('wallet.download-pass', $this->createdContactId)
                ]);
                return;
            }
        }

        // --- Logique d'inscription classique (Non Magic Link) ---
        
        // On vérifie si le client existe déjà
        $existingContact = null;
        if (!empty($this->email)) {
            $existingContact = CrmContact::where('team_id', $this->team->id)->where('email', $this->email)->first();
        }
        if (!$existingContact && !empty($normalizedPhone)) {
            $existingContact = CrmContact::where('team_id', $this->team->id)->where('phone', $normalizedPhone)->first();
        }

        if ($existingContact) {
            // Generic message to prevent user enumeration (don't reveal if email/phone exists)
            $this->addError('contact', 'Un problème est survenu. Si vous êtes déjà inscrit(e), demandez un lien de mise à jour à votre commerçant.');
            return;
        }

        // Création du nouveau client
        $contact = CrmContact::create([
            'team_id' => $this->team->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $normalizedPhone,
            'date_of_birth' => $this->date_of_birth,
            'opt_in_loyalty' => $this->opt_in_loyalty,
            'opt_in_marketing' => $this->opt_in_marketing,
        ]);
        
        // Génération du token pour le nouveau client
        $service = new \App\Services\GeneratePassTokenService();
        $service->assignToken($contact);

        $this->createdContactId = $contact->id;
        $this->successMessage = 'new';

        $this->dispatch('passCreated', [
            'downloadUrl' => route('wallet.download-pass', $this->createdContactId)
        ]);
    }

    public function render()
    {
        return view('livewire.join-loyalty-program');
    }
}
