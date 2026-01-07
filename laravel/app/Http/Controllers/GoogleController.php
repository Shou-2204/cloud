<?php

namespace App\Http\Controllers;

use App\Actions\Auth\CreateUserFromProvider;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    // 1. Rediriger l'utilisateur vers Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // 2. Google nous renvoie l'utilisateur
    public function handleGoogleCallback(CreateUserFromProvider $creator)
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = $creator->execute('google', $googleUser);

            // On connecte l'utilisateur
            Auth::login($user);

            return redirect('/dashboard');

        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Erreur de connexion Google.');
        }
    }
}
