<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;
// use Illuminate\Support\Facades\Event; // Plus besoin de cette façade pour ça
use App\Models\Team;
use App\Observers\TeamObserver;
use Laravel\Cashier\Cashier;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Configuration Cashier & Modèles
        Cashier::useCustomerModel(Team::class);
        Team::observe(TeamObserver::class);

        // J'AI SUPPRIMÉ LES BLOCS "Event::listen" ICI.
        // Laravel fait maintenant la liaison automatiquement grâce à l'Event Discovery.

        // Force HTTPS en prod
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
            URL::forceRootUrl(Config::get('app.url'));
        }
    }
}