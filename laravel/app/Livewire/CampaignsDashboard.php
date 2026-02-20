<?php

namespace App\Livewire;

use Livewire\Component;

class CampaignsDashboard extends Component
{
    public function render()
    {
        return view('livewire.campaigns-dashboard')->layout('layouts.app');
    }
}
