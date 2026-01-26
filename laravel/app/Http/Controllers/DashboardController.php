<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

/**
 * Handles dashboard views.
 */
class DashboardController extends Controller
{
    /**
     * Display the main dashboard.
     */
    public function index(): mixed
    {
        /** @var \App\Models\User $user */
        $user = \Illuminate\Support\Facades\Auth::user();

        if (is_null($user->current_team_id)) {
            return redirect()->route('onboarding');
        }

        return view('dashboard');
    }
}
