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
    public string $period = '7d'; // Default period

    public function mount(): void
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $this->team = $user->currentTeam;
    }

    public function setPeriod(string $period): void
    {
        $this->period = $period;

        // Dispatch event to update chart
        $this->dispatch('chart-updated', [
            'labels' => $this->chartData['labels'],
            'data' => $this->chartData['data'],
        ]);
    }

    /**
     * Send negative ratings summary by email.
     */
    public function sendNegativeSummary(): void
    {
        if (!$this->team) {
            return;
        }

        $days = $this->getDays();
        $startDate = now()->subDays($days);

        $negativeRatings = TeamRating::where('team_id', $this->team->id)
            ->where('created_at', '>=', $startDate)
            ->where('rating', '<=', 3)
            ->orderByDesc('created_at')
            ->get();

        if ($negativeRatings->isEmpty()) {
            return;
        }

        // Determine recipient
        $recipientEmail = $this->team->feedback_email
            ?? $this->team->email_public
            ?? $this->team->owner->email;

        // Send the summary email
        \Illuminate\Support\Facades\Mail::to($recipientEmail)
            ->send(new \App\Mail\NegativeRatingSummary(
                teamName: $this->team->name,
                ratings: $negativeRatings,
                period: $this->period,
            ));

        session()->flash('summary_sent', true);
    }

    /**
     * Get the number of days for current period.
     */
    protected function getDays(): int
    {
        return match ($this->period) {
            '24h' => 1,
            '7d' => 7,
            '30d' => 30,
            default => 7,
        };
    }

    /**
     * Get stats for current period.
     */
    public function getStatsProperty(): array
    {
        if (!$this->team) {
            return ['count' => 0, 'average' => 0, 'trend' => 0, 'positive' => 0, 'negative' => 0];
        }

        $days = $this->getDays();
        $startDate = now()->subDays($days);
        $previousStartDate = now()->subDays($days * 2);

        // Current period
        $currentRatings = TeamRating::where('team_id', $this->team->id)
            ->where('created_at', '>=', $startDate)
            ->get();

        $currentCount = $currentRatings->count();
        $currentAverage = $currentCount > 0 ? $currentRatings->avg('rating') : 0;
        $positiveCount = $currentRatings->where('rating', '>=', 4)->count();
        $negativeCount = $currentRatings->where('rating', '<=', 3)->count();

        // Previous period (for trend)
        $previousRatings = TeamRating::where('team_id', $this->team->id)
            ->where('created_at', '>=', $previousStartDate)
            ->where('created_at', '<', $startDate)
            ->get();

        $previousAverage = $previousRatings->count() > 0 ? $previousRatings->avg('rating') : 0;

        $trend = 0;
        if ($previousAverage > 0 && $currentAverage > 0) {
            $diff = $currentAverage - $previousAverage;
            if ($diff > 0.1)
                $trend = 1;
            elseif ($diff < -0.1)
                $trend = -1;
        }

        return [
            'count' => $currentCount,
            'average' => round($currentAverage, 1),
            'trend' => $trend,
            'positive' => $positiveCount,
            'negative' => $negativeCount,
        ];
    }

    /**
     * Get chart data for the timeline.
     */
    public function getChartDataProperty(): array
    {
        if (!$this->team) {
            return ['labels' => [], 'data' => []];
        }

        $days = $this->getDays();
        $labels = [];
        $data = [];

        // For each day/hour in period, calculate average
        if ($days === 1) {
            // Hourly for 24h
            for ($i = 23; $i >= 0; $i--) {
                $start = now()->subHours($i + 1);
                $end = now()->subHours($i);

                $ratings = TeamRating::where('team_id', $this->team->id)
                    ->whereBetween('created_at', [$start, $end])
                    ->get();

                $labels[] = $end->format('H:i');
                $data[] = $ratings->count() > 0 ? round($ratings->avg('rating'), 1) : null;
            }
        } else {
            // Daily for 7d/30d
            for ($i = $days - 1; $i >= 0; $i--) {
                $date = now()->subDays($i);

                $ratings = TeamRating::where('team_id', $this->team->id)
                    ->whereDate('created_at', $date->toDateString())
                    ->get();

                $labels[] = $date->format('d/m');
                $data[] = $ratings->count() > 0 ? round($ratings->avg('rating'), 1) : null;
            }
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
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

