<?php

namespace Tests\Feature;

use App\Models\Team;
use App\Models\User;
use App\Models\TeamRating;
use App\Notifications\NewPrivateFeedback;
use App\Livewire\NotificationBell;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class NotificationBellTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_mark_notification_as_read()
    {
        $user = User::factory()->create();
        $team = Team::factory()->create(['user_id' => $user->id, 'personal_team' => true]);

        $user->notifications()->delete();

        $rating = TeamRating::create([
            'team_id' => $team->id,
            'rating' => 2,
            'feedback' => 'Test feedback',
        ]);

        $user->notify(new NewPrivateFeedback($rating));

        $this->assertEquals(1, $user->unreadNotifications()->count());
        $notification = $user->unreadNotifications()->first();

        Livewire::actingAs($user)
            ->test(NotificationBell::class)
            ->call('markAsRead', $notification->id);

        $this->assertEquals(0, $user->fresh()->unreadNotifications()->count());
    }

    public function test_can_mark_all_notifications_as_read()
    {
        $user = User::factory()->create();
        $team = Team::factory()->create(['user_id' => $user->id, 'personal_team' => true]);

        $user->notifications()->delete();

        $rating1 = TeamRating::create(['team_id' => $team->id, 'rating' => 2, 'feedback' => 'Test 1']);
        $rating2 = TeamRating::create(['team_id' => $team->id, 'rating' => 2, 'feedback' => 'Test 2']);

        $user->notify(new NewPrivateFeedback($rating1));
        $user->notify(new NewPrivateFeedback($rating2));

        $this->assertEquals(2, $user->unreadNotifications()->count());

        Livewire::actingAs($user)
            ->test(NotificationBell::class)
            ->call('markAllAsRead');

        $this->assertEquals(0, $user->fresh()->unreadNotifications()->count());
    }
}
