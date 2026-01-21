<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\TeamRating;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ReviewController extends Controller
{
    /**
     * Display the statistics page with ratings chart.
     */
    public function stats(): View
    {
        return view('reviews.stats');
    }

    /**
     * Display negative feedbacks (rating <= 3).
     */
    public function negative(): View
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

        return view('reviews.negative', [
            'ratings' => $negativeRatings,
            'team' => $team,
        ]);
    }
}
