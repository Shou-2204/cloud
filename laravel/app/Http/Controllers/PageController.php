<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

/**
 * Handles static page views (welcome, etc.).
 */
class PageController extends Controller
{
    /**
     * Display the welcome/landing page.
     * If user is authenticated, redirect to dashboard.
     */
    public function welcome(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('welcome');
    }
}
