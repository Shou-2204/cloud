<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class LeadCapture extends Component
{
    public string $email = '';
    public string $name = '';
    public string $phone = '';
    public bool $withDetails = false;

    public function mount(bool $withDetails = false)
    {
        $this->withDetails = $withDetails;
    }
    public $submitted = false;

    protected function rules()
    {
        $rules = [
            'email' => ['required', 'email', 'unique:leads,email'],
        ];

        if ($this->withDetails) {
            $rules['name'] = ['nullable', 'string', 'max:255'];
            $rules['phone'] = ['nullable', 'string', 'max:255'];
        }

        return $rules;
    }

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

        // Get UTM parameters from session or request
        $utmSource = session('utm_source', request()->cookie('utm_source'));
        $utmMedium = session('utm_medium', request()->cookie('utm_medium'));
        $utmCampaign = session('utm_campaign', request()->cookie('utm_campaign'));

        \App\Models\Lead::create([
            'email' => $this->email,
            'name' => $this->name,
            'phone' => $this->phone,
            'source' => 'lead_capture_form',
            'utm_source' => $utmSource,
            'utm_medium' => $utmMedium,
            'utm_campaign' => $utmCampaign,
        ]);

        try {
            $message = "🚀 Nouvelle Lead Capture !\n\n📧 *Email:* {$this->email}\n📍 *Source:* {$utmSource}\n🔗 *Campagne:* {$utmCampaign}";
            
            if ($this->withDetails) {
                $message .= "\n👤 *Nom:* {$this->name}\n📞 *Téléphone:* {$this->phone}";
            }

            Http::post('https://hooks.slack.com/services/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', [
                'text' => $message,
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
