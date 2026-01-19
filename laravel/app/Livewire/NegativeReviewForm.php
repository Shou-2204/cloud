<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Mail\NegativeFeedbackReceived;
use App\Models\Team;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

/**
 * Handles negative feedback submission from public review page.
 */
class NegativeReviewForm extends Component
{
    public Team $team;
    public int $rating = 0;
    public string $feedback = '';
    public bool $submitted = false;

    /**
     * Minimum number of words required for negative feedback.
     */
    protected const MIN_WORDS = 5;

    protected function rules(): array
    {
        return [
            'rating' => ['required', 'integer', 'min:1', 'max:3'],
            'feedback' => ['required', 'string', 'min:20'],
        ];
    }

    protected function messages(): array
    {
        return [
            'feedback.required' => 'Veuillez nous expliquer ce qui n\'a pas été.',
            'feedback.min' => 'Veuillez détailler un peu plus votre retour (minimum :min caractères).',
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
     * Submit the negative feedback.
     */
    public function submit(): void
    {
        $this->validate();

        // Check minimum word count
        if (!$this->hasEnoughWords) {
            $this->addError('feedback', 'Veuillez écrire au moins ' . self::MIN_WORDS . ' mots pour nous aider à comprendre.');
            return;
        }

        // Determine recipient email
        $recipientEmail = $this->team->feedback_email
            ?? $this->team->email_public
            ?? $this->team->owner->email;

        // Send the email
        Mail::to($recipientEmail)
            ->send(new NegativeFeedbackReceived(
                team: $this->team,
                rating: $this->rating,
                feedback: $this->feedback,
            ));

        $this->submitted = true;
    }

    public function render()
    {
        return view('livewire.negative-review-form');
    }
}
