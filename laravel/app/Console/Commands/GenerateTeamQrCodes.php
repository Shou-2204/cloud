<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Team;

class GenerateTeamQrCodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'teams:generate-qr-codes {--force : Force regeneration for all teams}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate QR codes for teams that do not have one (or all with --force)';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Starting QR code generation...');

        $query = Team::query();

        if (!$this->option('force')) {
            $query->whereNull('qr_code_path');
        }

        // Only process teams that have a short_url, 
        // because the QR code job needs a short_url to encode.
        $query->whereNotNull('short_url');

        $teams = $query->cursor();

        $count = 0;
        $skipped = 0;

        foreach ($teams as $team) {
            $this->info("Processing team: {$team->name} ({$team->id})");

            try {
                \App\Jobs\GenerateTeamQrCode::dispatch($team);
                $this->info("Dispatched generation job for team: {$team->id}");
                $count++;
            } catch (\Exception $e) {
                $this->error("Failed to dispatch for team {$team->id}: " . $e->getMessage());
                $skipped++;
            }
        }

        $this->info("Completed. Dispatched: $count. Skipped/Failed: $skipped.");
        $this->warn("Note: Jobs are dispatched to the queue. Make sure your queue worker is running.");
    }
}
