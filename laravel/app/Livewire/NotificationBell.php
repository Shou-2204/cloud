<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;
use Livewire\Component;

class NotificationBell extends Component
{
    public function getUnreadCountProperty(): int
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        return $user?->unreadNotifications()->count() ?? 0;
    }

    public function getNotificationsProperty()
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if (! $user) {
            return collect();
        }

        return $user->unreadNotifications()->take(5)->get();
    }

    public function markAsRead(string $notificationId): void
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        $user?->unreadNotifications()
            ->where('id', $notificationId)
            ->first()
            ?->markAsRead();
    }

    public function markAllAsRead(): void
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        $user?->unreadNotifications->markAsRead();
    }

    public function render()
    {
        return view('livewire.notification-bell');
    }
}
