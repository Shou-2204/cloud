<?php

declare(strict_types=1);

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TeamController;
use App\Livewire\Onboarding;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Routes are organized by:
| 1. Public Routes (no auth)
| 2. Guest Routes (for non-authenticated users)
| 3. Authenticated Routes (auth required)
|
*/

// ============================================
// PUBLIC ROUTES
// ============================================

Route::get('/', [PageController::class, 'welcome'])->name('welcome');

// Google OAuth
Route::prefix('auth/google')->group(function (): void {
    Route::get('/', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/callback', [GoogleController::class, 'handleGoogleCallback']);
});

// Magic Link Auth
Route::post('/login/magic-link', [App\Http\Controllers\Auth\MagicLinkController::class, 'store'])->name('login.magic-link');
Route::get('/login/magic-link/{user}', [App\Http\Controllers\Auth\MagicLinkController::class, 'verify'])->name('login.magic-link.verify');

// Solutions (Siloing)
Route::name('solutions.')->prefix('solutions')->group(function () {
    Route::get('/', [App\Http\Controllers\PublicSiteController::class, 'solutions'])->name('index');
    Route::get('/{slug}', [App\Http\Controllers\PublicSiteController::class, 'solution'])->name('show');
});

// Blog / Resources
Route::name('blog.')->prefix('blog')->group(function () {
    Route::get('/', [App\Http\Controllers\PublicSiteController::class, 'blog'])->name('index');
    Route::get('/{slug}', [App\Http\Controllers\PublicSiteController::class, 'post'])->name('show');
});

// Features
Route::get('/features', [App\Http\Controllers\PublicSiteController::class, 'features'])->name('features');

// Company Pages
Route::get('/about', [App\Http\Controllers\PublicSiteController::class, 'about'])->name('about');
Route::get('/contact', [App\Http\Controllers\PublicSiteController::class, 'contact'])->name('contact');
Route::get('/faq', [App\Http\Controllers\PublicSiteController::class, 'faq'])->name('faq');

// Legal
Route::get('/legal/{page}', [App\Http\Controllers\PublicSiteController::class, 'legal'])->name('legal.show');

// Unsubscribe
Route::get('/news_unsubscribe', App\Livewire\Unsubscribe::class)->name('news_unsubscribe');

// Subscription (Public)
Route::get('/pricing', [SubscriptionController::class, 'index'])->name('subscription.index');
Route::get('/subscribe/{price}', [SubscriptionController::class, 'checkout'])->name('subscription.checkout');
Route::post('/subscribe/checkout', [SubscriptionController::class, 'storeBillingAndCheckout'])->name('subscription.store-checkout');

// Invite Links (Public with conditional redirect)
Route::get('/invite/{code}', [InviteController::class, 'redirect'])->name('invite.link');

// Public Organisation Profile (Business Card)
Route::get('/p/{team:public_uuid}', [App\Http\Controllers\PublicProfileController::class, 'show'])->name('profile.public');
Route::get('/p/{team:public_uuid}/survey', [App\Http\Controllers\PublicProfileController::class, 'review'])->name('profile.survey');
Route::get('/p/{team:public_uuid}/loyalty', [App\Http\Controllers\PublicProfileController::class, 'loyalty'])->name('profile.loyalty');

// Sales Conditions (Legacy Redirect or Keep as is?)
// Keeping for backward compatibility if needed, else we rely on /legal/terms
Route::get('/cgv', function () {
    return redirect()->route('legal.show', 'terms');
})->name('sales.show');

// Dynamic Robots.txt
Route::get('/robots.txt', function () {
    $content = "User-agent: *\n";
    $content .= "Disallow: /nova/\n";
    $content .= "Disallow: /admin/\n";
    $content .= "Disallow: /dashboard\n";
    $content .= "Disallow: /myteam\n";
    $content .= "Disallow: /mysubscription\n\n";
    $content .= 'Sitemap: '.url('/sitemap.xml');

    return response($content, 200)
        ->header('Content-Type', 'text/plain');
});

// ============================================
// AUTHENTICATED ROUTES
// ============================================

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function (): void {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Quick Redirects
    Route::get('/myteam', [TeamController::class, 'redirectToCurrentTeam'])->name('team.hub');
    Route::get('/mysubscription', [SubscriptionController::class, 'redirectToCurrentTeam'])->name('mysubscription');

    // Onboarding
    Route::get('/onboarding', Onboarding::class)->name('onboarding');

    // Team Management
    Route::delete('/teams/{team}/cancel-request', [TeamController::class, 'cancelRequest'])->name('teams.cancel-request');

    // Jetstream Team Routes (explicit registration for reliability)
    Route::prefix('teams')->group(function (): void {
        Route::get('/create', function () {
            return redirect()->route('onboarding');
        })->name('teams.create');

        // Team Settings with Tabs
        Route::get('/{team}', function ($team) {
            return redirect()->route('teams.settings', ['team' => $team, 'tab' => 'general']);
        })->name('teams.show');

        // Main Settings Route
        Route::get('/{team}/settings/{tab?}', [App\Http\Controllers\TeamSettingsController::class, 'show'])
            ->name('teams.settings');

        Route::put('/{team}', [\Laravel\Jetstream\Http\Controllers\Livewire\TeamController::class, 'update'])->name('teams.update');
    });

    // Subscription Management (Team-scoped)
    Route::prefix('team/{team}/subscription')
        ->name('subscription.')
        ->group(function (): void {
            Route::get('/', [SubscriptionController::class, 'show'])->name('show');
            Route::post('/swap', [SubscriptionController::class, 'update'])->name('swap');
            Route::post('/cancel', [SubscriptionController::class, 'cancel'])->name('cancel');
            Route::post('/resume', [SubscriptionController::class, 'resume'])->name('resume');
            Route::post('/billing', [SubscriptionController::class, 'updateBilling'])->name('update-billing');
        });

    // Reviews Section (for subscribed teams)
    Route::prefix('reviews')->name('reviews.')->group(function (): void {
        Route::get('/stats', [App\Http\Controllers\ReviewController::class, 'stats'])->name('stats');
        Route::get('/public', [App\Http\Controllers\ReviewController::class, 'publicReviews'])->name('public');
        Route::get('/private', [App\Http\Controllers\ReviewController::class, 'privateFeedbacks'])->name('private');
    });

    // Notifications Interaction
    Route::get('/notifications/{id}/read', [App\Http\Controllers\NotificationController::class, 'read'])->name('notifications.read');
});
