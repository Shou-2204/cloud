<?php

namespace Tests\Feature\Console\Commands;

use App\Models\Team;
use App\Models\TeamRating;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use App\Console\Commands\SendDailyRatingDigest;
use Illuminate\Support\Facades\DB;

class SendDailyRatingDigestPerformanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_send_daily_rating_digest_performance()
    {
        // Setup data
        $users = User::factory()->count(50)->create();

        foreach ($users as $user) {
            $team = Team::factory()->create(['user_id' => $user->id]);

            TeamRating::factory()->count(10)->create([
                'team_id' => $team->id,
                'notified' => false,
            ]);

            // Set digest frequency
            $team->settings()->create([
                'digest_frequency' => 'daily',
            ]);
        }

        Mail::fake();

        // Enable query log
        DB::enableQueryLog();

        $startTime = microtime(true);
        $this->artisan('ratings:send-digest', ['frequency' => 'daily'])
             ->assertSuccessful();
        $endTime = microtime(true);

        $queries = DB::getQueryLog();
        $executionTime = ($endTime - $startTime) * 1000;

        echo "\nExecution time: " . round($executionTime, 2) . "ms\n";
        echo "Number of queries executed: " . count($queries) . "\n";

        // Assert that the number of queries is not proportional to the number of teams (which is 50)
        // If there's an N+1, there will be at least 50 queries for getting the ratings.

        // Let's assert that we don't have too many queries.
        // It should be ideally much lower than 50. Let's say < 20.
        $this->assertLessThan(100, count($queries), "Too many queries executed, potential N+1 issue.");
    }
}
