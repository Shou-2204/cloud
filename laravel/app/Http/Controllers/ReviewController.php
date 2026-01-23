<?php

declare(strict_types=1);

namespace App\Http\Controllers;

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
            $googleData = $this->googlePlacesService->getPlaceReviews($team->settings->google_place_id);
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

        if ($team && $team->subscribed()) {
            if (! $this->googlePlacesService->isConfigured()) {
                $error = 'service_not_configured';
            } elseif ($team->settings->google_place_id) {
                $googleData = $this->googlePlacesService->getPlaceReviews(
                    $team->settings->google_place_id
                );
                $error = $googleData['error'] ?? null;
            } else {
                $error = 'google_place_id_missing';
            }
        }

        return view('reviews.public', [
            'team' => $team,
            'googleData' => $googleData,
            'error' => $error,
        ]);
    }

    /**
     * Display private feedbacks (rating <= 3).
     */
    public function privateFeedbacks(): View
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $team = $user->currentTeam;

        $negativeRatings = collect();

        if ($team && $team->subscribed()) {
            $negativeRatings = TeamRating::where('team_id', $team->id)
                ->where('rating', '<=', 3)
                ->whereNotNull('feedback')
                ->where('feedback', '!=', '')
                ->orderByDesc('created_at')
                ->paginate(15);
        }

        return view('reviews.private', [
            'ratings' => $negativeRatings,
            'team' => $team,
        ]);
    }
}
