<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Services\SlackNotificationService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function __construct(
        protected SlackNotificationService $slack
    ) {}

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

        $this->slack->notifyUser(
            "🎉 Nouvel Utilisateur Inscrit !\n\n👤 *Nom:* {$user->name}\n📧 *Email:* {$user->email}"
        );

        return $user;
    }
}
