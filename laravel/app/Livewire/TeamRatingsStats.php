<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Team;
use App\Models\TeamRating;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

/**
 * Displays rating statistics for the current team on dashboard.
 */
class TeamRatingsStats extends Component
{
    public ?Team $team = null;

    public function mount(): void
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $this->team = $user->currentTeam;
    }

    /**
     * Get stats for a given period.
     */
    protected function getStatsForPeriod(int $days): array
    {
        if (!$this->team) {
            return ['count' => 0, 'average' => 0, 'trend' => 0];
        }

        $startDate = now()->subDays($days);
        $previousStartDate = now()->subDays($days * 2);

        // Current period
        $currentRatings = TeamRating::where('team_id', $this->team->id)
            ->where('created_at', '>=', $startDate)
            ->get();

        $currentCount = $currentRatings->count();
        $currentAverage = $currentCount > 0 ? $currentRatings->avg('rating') : 0;

        // Previous period (for trend comparison)
        $previousRatings = TeamRating::where('team_id', $this->team->id)
            ->where('created_at', '>=', $previousStartDate)
            ->where('created_at', '<', $startDate)
            ->get();

        $previousAverage = $previousRatings->count() > 0 ? $previousRatings->avg('rating') : 0;

        // Calculate trend (-1 = down, 0 = stable, 1 = up)
        $trend = 0;
        if ($previousAverage > 0 && $currentAverage > 0) {
            $diff = $currentAverage - $previousAverage;
            if ($diff > 0.1) {
                $trend = 1;
            } elseif ($diff < -0.1) {
                $trend = -1;
            }
        }

        return [
            'count' => $currentCount,
            'average' => round($currentAverage, 1),
            'trend' => $trend,
        ];
    }

    public function getStats24hProperty(): array
    {
        return $this->getStatsForPeriod(1);
    }

    public function getStats7dProperty(): array
    {
        return $this->getStatsForPeriod(7);
    }

    public function getStats30dProperty(): array
    {
        return $this->getStatsForPeriod(30);
    }

    public function getTotalAverageProperty(): float
    {
        if (!$this->team) {
            return 0;
        }

        $ratings = TeamRating::where('team_id', $this->team->id)->get();
        return $ratings->count() > 0 ? round($ratings->avg('rating'), 1) : 0;
    }

    public function render()
    {
        return view('livewire.team-ratings-stats');
    }
}
