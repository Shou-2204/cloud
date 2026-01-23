<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationBell extends Component
{
    public function getUnreadCountProperty(): int
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        return $user?->unreadNotifications()->count() ?? 0;
    }

    public function render()
    {
        return view('livewire.notification-bell');
    }
}
