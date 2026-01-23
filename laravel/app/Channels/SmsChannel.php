<?php

namespace App\Channels;

use App\Services\Sms\SmsManager;
use App\Services\Sms\SmsMessage;
use Illuminate\Notifications\Notification;

class SmsChannel
{
    /**
     * The SMS manager instance.
     *
     * @var \App\Services\Sms\SmsManager
     */
    protected $manager;

    /**
     * Create a new SMS channel instance.
     *
     * @param  \App\Services\Sms\SmsManager  $manager
     * @return void
     */
    public function __construct(SmsManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        if (! method_exists($notification, 'toSms')) {
            return;
        }

        $message = $notification->toSms($notifiable);

        if (! $message instanceof SmsMessage) {
            return;
        }

        $to = $notifiable->routeNotificationFor('sms', $notification);

        if (! $to) {
            return;
        }

        $this->manager->driver()->send($to, $message);
    }
}
