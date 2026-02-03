<?php

namespace App\Livewire;

use Livewire\Component;

class LeadCapture extends Component
{
    public $email = '';
    public $submitted = false;

    protected $rules = [
        'email' => 'required|email|unique:leads,email',
    ];

    protected $messages = [
        'email.required' => 'Veuillez entrer votre adresse email.',
        'email.email' => 'Veuillez entrer une adresse email valide.',
        'email.unique' => 'Vous êtes déjà inscrit(e) !',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function submit()
    {
        $this->validate();

        // Capture UTM parameters from request
        $utmSource = request()->query('utm_source');
        $utmMedium = request()->query('utm_medium');
        $utmCampaign = request()->query('utm_campaign');

        \App\Models\Lead::create([
            'email' => $this->email,
            'source' => 'landing_page',
            'utm_source' => $utmSource,
            'utm_medium' => $utmMedium,
            'utm_campaign' => $utmCampaign,
        ]);

        $this->submitted = true;
        $this->email = '';
    }

    public function render()
    {
        return view('livewire.lead-capture');
    }
}
