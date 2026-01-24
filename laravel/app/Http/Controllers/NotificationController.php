<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Mark a notification as read and redirect to its target URL.
     */
    public function read(Request $request, string $id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Find the notification belonging to the user
        $notification = $user->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();

            // Infer URL logic (Legacy support matching the View logic)
            $data = $notification->data;
            $url = $data['url'] ?? '#';

            if ($url === '#' && isset($data['team_id'])) {
                try {
                    $url = route('teams.show', $data['team_id']);
                } catch (\Exception $e) {
                }
            }

            // Redirect
            if ($url && $url !== '#') {
                return redirect($url);
            }
        }

        // Fallback redirection
        return back();
    }
}
