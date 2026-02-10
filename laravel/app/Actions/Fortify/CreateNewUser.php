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
            Http::post('https://hooks.slack.com/services/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', [
                'text' => "🎉 Nouvel Utilisateur Inscrit !\n\n👤 *Nom:* {$user->name}\n📧 *Email:* {$user->email}",
            ]);
        } catch (\Exception $e) {
            // Silently fail
        }

        return $user;
    }
}
