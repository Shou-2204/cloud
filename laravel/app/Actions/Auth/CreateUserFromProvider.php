<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Contracts\User as SocialiteUser;

class CreateUserFromProvider
{
    /**
     * Create or retrieve a user from a social provider.
     *
     * @param  string  $provider
     * @param  \Laravel\Socialite\Contracts\User  $providerUser
     * @return \App\Models\User
     */
    public function execute(string $provider, SocialiteUser $providerUser): User
    {
        // On cherche si l'utilisateur existe déjà par email
        $user = User::where('email', $providerUser->getEmail())->first();

        if (!$user) {
            // Il n'existe pas, on le crée
            $user = User::create([
                'name' => $providerUser->getName(),
                'email' => $providerUser->getEmail(),
                'password' => Hash::make(Str::random(16)), // Mot de passe aléatoire sécurisé
            ]);
        }

        return $user;
    }
}
