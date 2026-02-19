<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Jobs\FetchGoogleReviews;
use App\Models\TeamRating;
use App\Services\GooglePlacesService;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function __construct(
        private GooglePlacesService $googlePlacesService
    ) {}

    /**
     * Display the statistics page with ratings chart.
     */
    public function stats(): View
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $team = $user->currentTeam;

        $googleData = null;

        if ($team && $team->subscribed() && $team->settings->google_place_id) {
            // Try to get from cache
            $googleData = $this->googlePlacesService->getCachedReviews($team->settings->google_place_id);

            // If not in cache, dispatch job to fetch it
            if (! $googleData) {
                FetchGoogleReviews::dispatch($team->settings->google_place_id);
                // Return empty/loading state for now
                $googleData = [
                    'reviews' => [],
                    'rating' => null,
                    'total_reviews' => null,
                    'name' => null,
                    'error' => null,
                    'loading' => true, // Flag to show "Loading..." in UI
                ];
            }
        }

        return view('reviews.stats', [
            'googleData' => $googleData,
        ]);
    }

    /**
     * Display public reviews from Google My Business.
     */
    public function publicReviews(): View
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $team = $user->currentTeam;

        $googleData = null;
        $error = null;
        $isLoading = false;

        if ($team && $team->subscribed()) {
            if (! $this->googlePlacesService->isConfigured()) {
                $error = 'service_not_configured';
            } elseif ($team->settings->google_place_id) {
                // Try to get from cache
                $googleData = $this->googlePlacesService->getCachedReviews($team->settings->google_place_id);

                if (! $googleData) {
                    FetchGoogleReviews::dispatch($team->settings->google_place_id);
                    $isLoading = true;
                } else {
                    $error = $googleData['error'] ?? null;
                }
            } else {
                $error = 'google_place_id_missing';
            }
        }

        return view('reviews.public', [
            'team' => $team,
            'googleData' => $googleData,
            'error' => $error,
            'isLoading' => $isLoading,
        ]);
    }

    /**
     * Display private feedbacks (rating <= 3).
     */
    public function privateFeedbacks(): mixed
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $team = $user->currentTeam;

        if (is_null($team)) {
             return redirect()->route('onboarding');
        }

        $this->authorize('viewPrivateFeedbacks', $team);

        $feedbacks = collect();

        if ($team->subscribed()) {
            $this->markPrivateFeedbackNotificationsAsRead($user);

            $feedbacks = TeamRating::where('team_id', $team->id)
                ->whereNotNull('feedback')
                ->where('feedback', '!=', '')
                ->orderByDesc('created_at')
                ->paginate(15);
        }

        return view('reviews.private', [
            'ratings' => $feedbacks,
            'team' => $team,
        ]);
    }

    private function markPrivateFeedbackNotificationsAsRead(\App\Models\User $user): void
    {
        $user->unreadNotifications()
            ->where('type', \App\Notifications\NewPrivateFeedback::class)
            ->get()
            ->markAsRead();
    }
}
