<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Http;
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

        try {
            Http::post('https://hooks.slack.com/services/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', [
                'text' => "🚀 Nouvelle Lead Capture !\n\n📧 *Email:* {$this->email}\n📍 *Source:* {$utmSource}\n🔗 *Campagne:* {$utmCampaign}",
            ]);
        } catch (\Exception $e) {
            // Silently fail to avoid disrupting user experience
        }

        $this->submitted = true;
        $this->email = '';
    }

    public function render()
    {
        return view('livewire.lead-capture');
    }
}
