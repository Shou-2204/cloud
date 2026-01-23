<?php

namespace App\Providers;

use App\Models\Team;
use App\Observers\TeamObserver;
use Illuminate\Support\Facades\Config;
// use Illuminate\Support\Facades\Event; // Plus besoin de cette façade pour ça
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
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

        // Prevent Lazy Loading & other silent errors in non-prod
        \Illuminate\Database\Eloquent\Model::shouldBeStrict(! $this->app->isProduction());

        // J'AI SUPPRIMÉ LES BLOCS "Event::listen" ICI.
        // Laravel fait maintenant la liaison automatiquement grâce à l'Event Discovery.

        // Force HTTPS en prod
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
            URL::forceRootUrl(Config::get('app.url'));
        }

        // Dynamic Password Policy for Registration View
        \Illuminate\Support\Facades\View::composer('auth.register', function ($view) {
            $rulesProvider = new class
            {
                use \App\Actions\Fortify\PasswordValidationRules;

                public function getRules()
                {
                    return $this->passwordRules();
                }
            };

            $rules = $rulesProvider->getRules();
            $passwordRule = null;

            foreach ($rules as $rule) {
                if ($rule instanceof \Illuminate\Validation\Rules\Password) {
                    $passwordRule = $rule;
                    break;
                }
            }

            $policy = [
                'min' => 8,
                'mixedCase' => false,
                'numbers' => false,
                'symbols' => false,
            ];

            if ($passwordRule) {
                $reflection = new \ReflectionClass($passwordRule);
                foreach (['min', 'mixedCase', 'numbers', 'symbols'] as $prop) {
                    if ($reflection->hasProperty($prop)) {
                        $property = $reflection->getProperty($prop);
                        $property->setAccessible(true);
                        $policy[$prop] = $property->getValue($passwordRule);
                    }
                }
            }

            $view->with('passwordPolicy', $policy);
        });
    }
}
