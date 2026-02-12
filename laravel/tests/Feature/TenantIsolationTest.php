<?php

namespace Tests\Feature;

use App\Models\Team;
use App\Models\TeamRating;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TenantIsolationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_access_other_team_settings()
    {
        $userA = User::factory()->withPersonalTeam()->create();
        $teamA = $userA->currentTeam;

        $userB = User::factory()->withPersonalTeam()->create();
        $teamB = $userB->currentTeam;

        // User A tries to access Team B settings
        $response = $this->actingAs($userA)
            ->get(route('teams.settings', $teamB));

        $response->assertStatus(403);
    }

    public function test_user_cannot_see_other_team_reviews()
    {
        $userA = User::factory()->withPersonalTeam()->create();
        $teamA = $userA->currentTeam;

        $userB = User::factory()->withPersonalTeam()->create();
        $teamB = $userB->currentTeam;

        // Create review for Team B
        TeamRating::create([
            'team_id' => $teamB->id,
            'rating' => 1,
            'feedback' => 'Secret feedback for Team B',
        ]);

        // User A tries to access private reviews (which defaults to current team)
        // So we must switch User A's current team to Team B if possible?
        // But User A is not member of Team B.
        // If User A switches context to Team B, Jetstream should forbid it.

        $response = $this->actingAs($userA)
            ->get(route('reviews.private')); // This uses $user->currentTeam

        // User A's current team is Team A.
        // It should NOT show Team B's feedback.
        $response->assertStatus(200);
        $response->assertDontSee('Secret feedback for Team B');
    }

    public function test_user_cannot_switch_to_unauthorized_team()
    {
        $userA = User::factory()->withPersonalTeam()->create();
        $teamB = Team::factory()->create(); // Team B owned by someone else

        $response = $this->actingAs($userA)
            ->put(route('current-team.update'), [
                'team_id' => $teamB->id,
            ]);

        // Should fail validation or forbidden
        $response->assertStatus(403);

        $this->assertNotEquals($teamB->id, $userA->fresh()->current_team_id);
    }
}
