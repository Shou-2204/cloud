<?php

namespace Tests\Feature;

use App\Models\Team;
use App\Models\User;
use App\Notifications\NewPrivateFeedback;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
use Tests\TestCase;
use App\Livewire\NegativeReviewForm;

class PrivateFeedbackNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_negative_feedback_triggers_notification()
    {
        Notification::fake();

        $user = User::factory()->create();
        $team = Team::factory()->create([
            'user_id' => $user->id,
            'personal_team' => true,
        ]);

        // Ensure user is associated with team properly if needed, but owner usually is.
        // If strict Jetstream, we might need to check.

        $user->notifications()->delete();

        Livewire::test(NegativeReviewForm::class, ['team' => $team])
            ->set('rating', 2)
            ->set('feedback', 'This is a very bad experience with enough words.')
            ->call('submit');

        Notification::assertSentTo(
            [$user],
            NewPrivateFeedback::class
        );
    }

    public function test_notification_appears_in_database()
    {
        $user = User::factory()->create();
        $team = Team::factory()->create(['user_id' => $user->id, 'personal_team' => true]);

        $user->notifications()->delete();

        Livewire::test(NegativeReviewForm::class, ['team' => $team])
            ->set('rating', 2)
            ->set('feedback', 'This is a very bad experience with enough words.')
            ->call('submit');

        $this->assertEquals(1, $user->fresh()->unreadNotifications->count());
        $notification = $user->unreadNotifications->first();
        $this->assertEquals('Nouveau feedback privé reçu (2/5)', $notification->data['message']);
        $this->assertTrue(isset($notification->data['url']));
        $this->assertEquals(route('reviews.private'), $notification->data['url']);
    }

    public function test_visiting_private_feedbacks_clears_notifications()
    {
        $user = User::factory()->create();
        $team = Team::factory()->create(['user_id' => $user->id, 'personal_team' => true]);

        // Mock subscription so the controller enters the block
        // $team->trial_ends_at = now()->addDays(10);
        // $team->save();

        $team->subscriptions()->create([
            'type' => 'default',
            'stripe_id' => 'sub_test',
            'stripe_status' => 'active',
        ]);

        $user->notifications()->delete();

        Livewire::test(NegativeReviewForm::class, ['team' => $team])
            ->set('rating', 2)
            ->set('feedback', 'This is a very bad experience with enough words.')
            ->call('submit');

        $this->assertEquals(1, $user->fresh()->unreadNotifications->count());

        $this->actingAs($user)
             ->get(route('reviews.private'));

        $this->assertEquals(0, $user->fresh()->unreadNotifications->count());
    }
}
