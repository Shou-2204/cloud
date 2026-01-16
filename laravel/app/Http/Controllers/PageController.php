<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

/**
 * Handles static page views (welcome, etc.).
 */
class PageController extends Controller
{
    /**
     * Display the welcome/landing page.
     */
    public function welcome(): View
    {
        return view('welcome');
    }
}
