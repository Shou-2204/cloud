<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        // On crée juste l'utilisateur, sans transaction complexe, sans créer d'équipe
        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'has_set_password' => true,
        ]);

        try {
            $slackWebhook = config('services.slack.webhooks.users');
            if ($slackWebhook) {
                Http::post($slackWebhook, [
                    'text' => "🎉 Nouvel Utilisateur Inscrit !\n\n👤 *Nom:* {$user->name}\n📧 *Email:* {$user->email}",
                ]);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Slack Notification Failed on Regular User Registration: ' . $e->getMessage());
        }

        return $user;
    }
}
