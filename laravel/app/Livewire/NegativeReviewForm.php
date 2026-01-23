<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Team;
use App\Models\TeamRating;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

/**
 * Handles negative feedback submission from public review page.
 * Saves to database for daily digest instead of sending instant emails.
 */
class NegativeReviewForm extends Component
{
    public Team $team;

    public int $rating = 0;

    public string $feedback = '';

    public bool $submitted = false;

    public bool $rateLimited = false;

    /**
     * Minimum number of words required for negative feedback.
     */
    public const MIN_WORDS = 5;

    /**
     * Rate limit: seconds before another submission is allowed (1 hour).
     */
    public const RATE_LIMIT_SECONDS = 3600;

    public function mount(): void
    {
        // Check if already rate limited on component load
        $this->rateLimited = $this->isRateLimited();
    }

    /**
     * Listen for rating updates from Alpine.js
     */
    #[\Livewire\Attributes\On('set-rating')]
    public function setRating(int $rating): void
    {
        $this->rating = $rating;
    }

    protected function rules(): array
    {
        return [
            'rating' => ['required', 'integer', 'min:1', 'max:3'],
            'feedback' => ['required', 'string', 'min:20', 'max:1000'],
        ];
    }

    protected function messages(): array
    {
        return [
            'feedback.required' => 'Veuillez nous expliquer ce qui n\'a pas été.',
            'feedback.min' => 'Veuillez détailler un peu plus votre retour.',
            'feedback.max' => 'Votre message est trop long (maximum :max caractères).',
        ];
    }

    /**
     * Validate word count client-side helper.
     */
    public function getWordCountProperty(): int
    {
        return str_word_count($this->feedback);
    }

    /**
     * Check if feedback has enough words.
     */
    public function getHasEnoughWordsProperty(): bool
    {
        return $this->wordCount >= self::MIN_WORDS;
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

    /**
     * Generate a hash for spam tracking (anonymized).
     */
    protected function getSessionHash(): string
    {
        return hash('sha256', request()->ip().'|'.session()->getId());
    }

    /**
     * Check if current IP is rate limited for this team.
     */
    protected function isRateLimited(): bool
    {
        return Cache::has($this->getRateLimitKey());
    }

    /**
     * Apply rate limit for current IP.
     */
    protected function applyRateLimit(): void
    {
        Cache::put($this->getRateLimitKey(), true, self::RATE_LIMIT_SECONDS);
    }

    /**
     * Submit the negative feedback.
     */
    public function submit(): void
    {
        // Check rate limit first
        if ($this->isRateLimited()) {
            $this->rateLimited = true;
            $this->addError('feedback', 'Vous avez déjà envoyé un message récemment. Veuillez patienter avant de réessayer.');

            return;
        }

        $this->validate();

        // Check minimum word count
        if (! $this->hasEnoughWords) {
            $this->addError('feedback', 'Veuillez écrire au moins '.self::MIN_WORDS.' mots pour nous aider à comprendre.');

            return;
        }

        // Apply rate limit before saving
        $this->applyRateLimit();

        // Save to database (email sent via daily digest)
        TeamRating::create([
            'team_id' => $this->team->id,
            'rating' => $this->rating,
            'feedback' => $this->feedback,
            'session_hash' => $this->getSessionHash(),
        ]);

        $this->submitted = true;
    }

    public function render()
    {
        return view('livewire.negative-review-form');
    }
}
