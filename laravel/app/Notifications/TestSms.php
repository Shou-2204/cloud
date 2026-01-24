<?php

namespace App\Notifications;

use App\Channels\SmsChannel;
use App\Services\Sms\SmsMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class TestSms extends Notification implements ShouldQueue
{
    use Queueable;

    protected $content;

    /**
     * Create a new notification instance.
     */
    public function __construct($content = 'Hello from Laravel SMS!')
    {
        $this->content = $content;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [SmsChannel::class];
    }

    /**
     * Get the SMS representation of the notification.
     */
    public function toSms(object $notifiable): SmsMessage
    {
        return (new SmsMessage)
            ->content($this->content)
            ->from('System');
    }
}
