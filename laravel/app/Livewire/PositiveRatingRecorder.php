<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Team;
use App\Models\TeamRating;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

/**
 * Records positive ratings (4-5 stars) to the database.
 */
class PositiveRatingRecorder extends Component
{
    public Team $team;

    public int $rating = 0;

    public bool $recorded = false;

    public bool $hasAlreadyVoted = false;

    /**
     * Rate limit: seconds before another submission is allowed (24 hours).
     */
    public const RATE_LIMIT_SECONDS = 86400;

    public function mount(): void
    {
        // Check if user has already voted on page load
        $this->hasAlreadyVoted = $this->isRateLimited();
    }

    /**
     * Record a positive rating.
     */
    #[\Livewire\Attributes\On('record-positive-rating')]
    public function record(int $rating): void
    {
        if ($rating < 4 || $rating > 5) {
            return;
        }

        // Check rate limit
        if ($this->isRateLimited()) {
            $this->hasAlreadyVoted = true;
            $this->recorded = true;

            return;
        }

        $this->rating = $rating;
        $this->applyRateLimit();

        TeamRating::create([
            'team_id' => $this->team->id,
            'rating' => $rating,
            'feedback' => null,
            'session_hash' => $this->getSessionHash(),
        ]);

        $this->recorded = true;
    }

    /**
     * Rate limit key based on IP + session.
     * Allows multiple users on same network (WiFi) to submit independently.
     */
    protected function getRateLimitKey(): string
    {
        $ip = request()->ip();
        $sessionId = session()->getId();

        return "review_limit:{$this->team->id}:{$ip}:{$sessionId}";
    }

    protected function getSessionHash(): string
    {
        return hash('sha256', request()->ip().'|'.session()->getId());
    }

    protected function isRateLimited(): bool
    {
        return Cache::has($this->getRateLimitKey());
    }

    protected function applyRateLimit(): void
    {
        Cache::put($this->getRateLimitKey(), true, self::RATE_LIMIT_SECONDS);
    }

    public function render()
    {
        return view('livewire.positive-rating-recorder');
    }
}
