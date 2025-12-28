<?php

namespace App\Providers;

use App\Models\TeamInvitation;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
            URL::forceRootUrl(Config::get('app.url'));
        }

        // Écouter l'événement d'inscription pour traiter l'invitation en session
        Event::listen(Registered::class, function (Registered $event) {
            if (session()->has('team_invitation_token')) {
                $token = session('team_invitation_token');
                $invitation = TeamInvitation::where('token', $token)->first();

                if ($invitation && $event->user instanceof User) {
                    $invitation->team->members()->attach($event->user, ['role' => $invitation->role]);
                    $invitation->delete();
                    session()->forget('team_invitation_token');
                }
            }
        });
    }
}
