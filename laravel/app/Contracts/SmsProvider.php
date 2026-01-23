<?php

namespace App\Contracts;

use App\Services\Sms\SmsMessage;

interface SmsProvider
{
    /**
     * Send the given SMS message to the given number.
     *
     * @param  string  $to
     * @param  \App\Services\Sms\SmsMessage  $message
     * @return void
     */
    public function send(string $to, SmsMessage $message): void;
}
