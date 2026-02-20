<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LoyaltyDashboard extends Component
{
    public function render()
    {
        return view('livewire.loyalty-dashboard')->layout('layouts.app');
    }
}
