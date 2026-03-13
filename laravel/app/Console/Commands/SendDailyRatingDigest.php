<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Mail\DailyRatingDigest;
use App\Models\Team;
use App\Models\TeamRating;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

/**
 * Send digest emails for teams with new ratings based on their frequency preference.
 */
class SendDailyRatingDigest extends Command
{
    protected $signature = 'ratings:send-digest {frequency=daily : daily|weekly|monthly}';

    protected $description = 'Send rating digest emails to team owners based on frequency';

    public function handle(): int
    {
        $frequency = $this->argument('frequency');
        $this->info("📊 Starting {$frequency} rating digest...");

        // Get teams with unnotified ratings and matching frequency
        $teamIds = TeamRating::unnotified()
            ->distinct()
            ->pluck('team_id');

        if ($teamIds->isEmpty()) {
            $this->info('No new ratings to send.');

            return Command::SUCCESS;
        }

        $sentCount = 0;

        Team::with([
            'owner',
            'settings',
            'profile',
            'ratings' => function ($query) {
                $query->unnotified();
            },
        ])
            ->whereIn('id', $teamIds)
            ->chunk(100, function ($teams) use ($frequency, &$sentCount) {
                $notifiedRatingIds = [];

                foreach ($teams as $team) {
                    // Check if team's digest frequency matches
                    $teamFrequency = $team->settings->digest_frequency ?? 'daily';

                    // Skip if frequency disabled or doesn't match
                    if ($teamFrequency === 'none' || $teamFrequency !== $frequency) {
                        continue;
                    }

                    $ratings = $team->ratings;

                    if ($ratings->isEmpty()) {
                        continue;
                    }

                    // Calculate stats
                    $averageRating = $ratings->avg('rating');
                    $positiveCount = $ratings->where('rating', '>=', 4)->count();
                    $negativeCount = $ratings->where('rating', '<=', 3)->count();
                    $feedbacks = $ratings
                        ->whereNotNull('feedback')
                        ->values();

                    // Determine recipient
                    $recipientEmail = $team->settings->feedback_email
                        ?? $team->profile->email_public
                        ?? $team->owner->email;

                    // Send digest
                    Mail::to($recipientEmail)->send(new DailyRatingDigest(
                        teamName: $team->name,
                        ratings: $ratings,
                        averageRating: $averageRating,
                        positiveCount: $positiveCount,
                        negativeCount: $negativeCount,
                        feedbacks: $feedbacks,
                    ));

                    // Collect rating IDs to mark as notified
                    foreach ($ratings as $rating) {
                        $notifiedRatingIds[] = $rating->id;
                    }

                    $this->info("✅ Digest sent to {$recipientEmail} for {$team->name} ({$ratings->count()} ratings)");
                    $sentCount++;
                }

                // Mark as notified in bulk
                if (! empty($notifiedRatingIds)) {
                    TeamRating::whereIn('id', $notifiedRatingIds)
                        ->update(['notified' => true]);
                }
            });

        $this->info("✅ {$frequency} digest complete! Sent {$sentCount} emails.");

        return Command::SUCCESS;
    }
}
