<?php

namespace App\Http\Controllers;

use App\Actions\Auth\CreateUserFromProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class AppleController extends Controller
{
    public function redirectToApple()
    {
        return Socialite::driver('apple')->redirect();
    }

    public function handleAppleCallback(CreateUserFromProvider $creator)
    {
        try {
            $appleUser = Socialite::driver('apple')->user();

            $user = $creator->execute('apple', $appleUser);

            Auth::login($user);

            return redirect('/dashboard');

        } catch (\Exception $e) {
            Log::error('Apple Auth Error: ' . $e->getMessage(), [
                'exception' => $e,
            ]);
            return redirect('/login')->with('error', 'Erreur de connexion Apple.');
        }
    }
}
