<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Team;
use App\Services\ShlinkService;

class GenerateTeamShortUrls extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'teams:generate-short-links {--info-only}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate short URLs for teams that do not have one';

    /**
     * Execute the console command.
     */
    public function handle(ShlinkService $shlinkService): void
    {
        $this->info('Starting short URL generation...');

        $teams = Team::whereNull('short_url')->whereNotNull('public_uuid')->cursor();

        $count = 0;
        $errors = 0;

        foreach ($teams as $team) {
            $this->info("Processing team: {$team->name} ({$team->id})");
            
            if ($this->option('info-only')) {
                 continue;
            }

            $longUrl = route('profile.public', ['team' => $team->public_uuid]);
            $shortUrl = $shlinkService->createShortUrl($longUrl, ['team-' . $team->id]);

            if ($shortUrl) {
                $team->forceFill(['short_url' => $shortUrl])->saveQuietly();
                \App\Jobs\GenerateTeamQrCode::dispatch($team);
                $this->info("Generated: $shortUrl");
                $count++;
            } else {
                $this->error("Failed to generate for team: {$team->id}");
                $errors++;
            }
        }

        $this->info("Completed. Generated: $count. Errors: $errors.");
    }
}
