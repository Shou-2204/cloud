<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Mail\DailyRatingDigest;
use App\Models\Team;
use App\Models\TeamRating;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

/**
 * Send daily digest emails for teams with new ratings.
 */
class SendDailyRatingDigest extends Command
{
    protected $signature = 'ratings:send-digest';

    protected $description = 'Send daily rating digest emails to team owners';

    public function handle(): int
    {
        $this->info('📊 Starting daily rating digest...');

        // Get teams with unnotified ratings
        $teamIds = TeamRating::unnotified()
            ->distinct()
            ->pluck('team_id');

        if ($teamIds->isEmpty()) {
            $this->info('No new ratings to send.');
            return Command::SUCCESS;
        }

        $this->info("Found {$teamIds->count()} teams with new ratings.");

        foreach ($teamIds as $teamId) {
            $team = Team::with('owner')->find($teamId);

            if (!$team) {
                continue;
            }

            $ratings = TeamRating::where('team_id', $teamId)
                ->unnotified()
                ->get();

            if ($ratings->isEmpty()) {
                continue;
            }

            // Calculate stats
            $averageRating = $ratings->avg('rating');
            $positiveCount = $ratings->where('rating', '>=', 4)->count();
            $negativeCount = $ratings->where('rating', '<=', 3)->count();
            $negativeFeedbacks = $ratings
                ->where('rating', '<=', 3)
                ->whereNotNull('feedback')
                ->values();

            // Determine recipient
            $recipientEmail = $team->feedback_email
                ?? $team->email_public
                ?? $team->owner->email;

            // Send digest
            Mail::to($recipientEmail)->send(new DailyRatingDigest(
                teamName: $team->name,
                ratings: $ratings,
                averageRating: $averageRating,
                positiveCount: $positiveCount,
                negativeCount: $negativeCount,
                negativeFeedbacks: $negativeFeedbacks,
            ));

            // Mark as notified
            TeamRating::where('team_id', $teamId)
                ->unnotified()
                ->update(['notified' => true]);

            $this->info("✅ Digest sent to {$recipientEmail} for {$team->name} ({$ratings->count()} ratings)");
        }

        $this->info('✅ Daily digest complete!');

        return Command::SUCCESS;
    }
}
