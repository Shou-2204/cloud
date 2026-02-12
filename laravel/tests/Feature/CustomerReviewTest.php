<?php

namespace Tests\Feature;

use App\Livewire\NegativeReviewForm;
use App\Livewire\PositiveRatingRecorder;
use App\Models\Team;
use App\Models\User;
use App\Notifications\NewPrivateFeedback;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
use Tests\TestCase;

class CustomerReviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_positive_review_shows_google_link()
    {
        $user = User::factory()->withPersonalTeam()->create();
        $team = $user->currentTeam;

        // Configure Google URL
        $googleUrl = 'https://g.page/r/test/review';
        $team->settings()->updateOrCreate([], ['google_review_url' => $googleUrl]);
        $team->refresh();

        Livewire::test(PositiveRatingRecorder::class, ['team' => $team])
            ->call('record', 5)
            ->assertSet('showFeedbackForm', true)
            ->assertSee($googleUrl);
    }

    public function test_positive_review_can_leave_message()
    {
        Notification::fake();

        $user = User::factory()->withPersonalTeam()->create();
        $team = $user->currentTeam;

        Livewire::test(PositiveRatingRecorder::class, ['team' => $team])
            ->call('record', 5)
            ->set('feedback', 'Great job!')
            ->call('submitFeedback');

        Notification::assertSentTo(
            [$user],
            NewPrivateFeedback::class,
            function ($notification, $channels) {
                return $notification->rating->rating === 5;
            }
        );
    }

    public function test_negative_review_triggers_notification()
    {
        Notification::fake();
        // Mock Slack to avoid real calls even if notification sends to Slack
        $this->mockSlack();

        $user = User::factory()->withPersonalTeam()->create();
        $team = $user->currentTeam;

        Livewire::test(NegativeReviewForm::class, ['team' => $team])
            ->set('rating', 1)
            ->set('feedback', 'Terrible service. This is really bad. I am not happy.')
            ->call('submit');

        Notification::assertSentTo(
            [$user],
            NewPrivateFeedback::class,
            function ($notification, $channels) {
                return $notification->rating->rating === 1;
            }
        );
    }
}
