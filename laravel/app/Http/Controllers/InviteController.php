<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

/**
 * Handles invite link redirections.
 */
class InviteController extends Controller
{
    /**
     * Handle invite link access.
     * If not authenticated, store code and redirect to register.
     * If authenticated, redirect to onboarding with join code.
     */
    public function redirect(string $code): RedirectResponse
    {
        if (!Auth::check()) {
            session(['intended_join_code' => $code]);
            return redirect()->route('register');
        }

        return redirect()->route('onboarding', ['join' => $code]);
    }
}
