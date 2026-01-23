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
        $recipientEmail = $this->team->settings->feedback_email
            ?? $this->team->profile->email_public
            ?? $this->team->owner->email;

        // Send the summary email via queue (Horizon)
        \Illuminate\Support\Facades\Mail::to($recipientEmail)
            ->queue(new \App\Mail\NegativeRatingSummary(
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
     * Optimized: Uses SQL aggregations instead of loading all records.
     */
    public function getStatsProperty(): array
    {
        if (!$this->team) {
            return ['count' => 0, 'average' => 0, 'trend' => 0, 'positive' => 0, 'negative' => 0];
        }

        $days = $this->getDays();
        $startDate = now()->subDays($days);
        $previousStartDate = now()->subDays($days * 2);

        // Current period - Single optimized query with SQL aggregations
        $currentStats = TeamRating::where('team_id', $this->team->id)
            ->where('created_at', '>=', $startDate)
            ->selectRaw('
                COUNT(*) as count,
                AVG(rating) as average,
                SUM(CASE WHEN rating >= 4 THEN 1 ELSE 0 END) as positive,
                SUM(CASE WHEN rating <= 3 THEN 1 ELSE 0 END) as negative
            ')
            ->first();

        $currentCount = (int) ($currentStats->count ?? 0);
        $currentAverage = (float) ($currentStats->average ?? 0);
        $positiveCount = (int) ($currentStats->positive ?? 0);
        $negativeCount = (int) ($currentStats->negative ?? 0);

        // Previous period - Single optimized query for trend
        $previousAverage = (float) TeamRating::where('team_id', $this->team->id)
            ->where('created_at', '>=', $previousStartDate)
            ->where('created_at', '<', $startDate)
            ->avg('rating') ?? 0;

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
            'positive' => $positiveCount,
            'negative' => $negativeCount,
        ];
    }

    /**
     * Get chart data for the timeline.
     * Optimized: Uses a single GROUP BY query instead of N+1 queries.
     */
    public function getChartDataProperty(): array
    {
        if (!$this->team) {
            return ['labels' => [], 'data' => []];
        }

        $days = $this->getDays();
        $labels = [];
        $data = [];

        if ($days === 1) {
            // Hourly for 24h - Single query grouped by hour
            $startTime = now()->subHours(24);
            $ratingsGrouped = TeamRating::where('team_id', $this->team->id)
                ->where('created_at', '>=', $startTime)
                ->selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d %H:00:00") as hour_slot, AVG(rating) as avg_rating')
                ->groupBy('hour_slot')
                ->pluck('avg_rating', 'hour_slot');

            for ($i = 23; $i >= 0; $i--) {
                $slotTime = now()->subHours($i);
                $slotKey = $slotTime->format('Y-m-d H:00:00');
                $labels[] = $slotTime->format('H:i');
                $data[] = isset($ratingsGrouped[$slotKey]) ? round((float) $ratingsGrouped[$slotKey], 1) : null;
            }
        } else {
            // Daily for 7d/30d - Single query grouped by date
            $startDate = now()->subDays($days);
            $ratingsGrouped = TeamRating::where('team_id', $this->team->id)
                ->where('created_at', '>=', $startDate)
                ->selectRaw('DATE(created_at) as date, AVG(rating) as avg_rating')
                ->groupBy('date')
                ->pluck('avg_rating', 'date');

            for ($i = $days - 1; $i >= 0; $i--) {
                $date = now()->subDays($i);
                $dateKey = $date->toDateString();
                $labels[] = $date->format('d/m');
                $data[] = isset($ratingsGrouped[$dateKey]) ? round((float) $ratingsGrouped[$dateKey], 1) : null;
            }
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }

    /**
     * Get total average rating for the team.
     * Optimized: Uses SQL AVG directly instead of loading all records.
     */
    public function getTotalAverageProperty(): float
    {
        if (!$this->team) {
            return 0;
        }

        $average = TeamRating::where('team_id', $this->team->id)->avg('rating');

        return $average ? round((float) $average, 1) : 0;
    }

    public function render()
    {
        return view('livewire.team-ratings-stats');
    }
}
