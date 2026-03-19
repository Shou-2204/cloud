<?php

namespace App\Livewire;

use App\Jobs\FetchGoogleReviews;
use App\Services\GooglePlacesService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class GoogleReviewsStats extends Component
{
    /**
     * Component to display Google Reviews stats with auto-refresh.
     */
    public function render(GooglePlacesService $googlePlacesService)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $team = $user->currentTeam;
        $googleData = null;
        $isLoading = false;

        if ($team && $team->subscribed() && $team->settings->google_place_id) {
            // Try to get from cache
            $googleData = $googlePlacesService->getCachedReviews($team->settings->google_place_id);

            // If not in cache, dispatch job and show loading
            if (! $googleData) {
                FetchGoogleReviews::dispatch($team->settings->google_place_id);
                $isLoading = true;
                $googleData = [
                    'reviews' => [],
                    'rating' => null,
                    'total_reviews' => null,
                    'name' => null,
                    'error' => null,
                ];
            }
        }

        return view('livewire.google-reviews-stats', [
            'googleData' => $googleData,
            'isLoading' => $isLoading,
        ]);
    }
}
