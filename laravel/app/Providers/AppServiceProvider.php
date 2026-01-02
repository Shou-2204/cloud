<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use App\Models\Team;
use App\Observers\TeamObserver;
use Laravel\Jetstream\Events\TeamMemberAdded;
use Laravel\Jetstream\Events\InvitingTeamMember;
use App\Listeners\LogTeamMemberActivity;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Team::observe(TeamObserver::class);

        Event::listen(
            TeamMemberAdded::class,
            [LogTeamMemberActivity::class, 'handleTeamMemberAdded']
        );

        Event::listen(
            InvitingTeamMember::class,
            [LogTeamMemberActivity::class, 'handleInvitingTeamMember']
        );

        if ($this->app->environment('production')) {
            URL::forceScheme('https');
            URL::forceRootUrl(Config::get('app.url'));
        }
    }
}