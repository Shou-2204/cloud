<?php

namespace App\Contracts;

use App\Services\Sms\SmsMessage;

interface SmsProvider
{
    /**
     * Send the given SMS message to the given number.
     */
    public function send(string $to, SmsMessage $message): void;
}
