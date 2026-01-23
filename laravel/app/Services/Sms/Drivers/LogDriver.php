<?php

namespace App\Services\Sms\Drivers;

use App\Contracts\SmsProvider;
use App\Services\Sms\SmsMessage;
use Illuminate\Support\Facades\Log;

class LogDriver implements SmsProvider
{
    /**
     * Send the given SMS message to the given number.
     *
     * @param  string  $to
     * @param  \App\Services\Sms\SmsMessage  $message
     * @return void
     */
    public function send(string $to, SmsMessage $message): void
    {
        Log::info("SMS Sent to {$to}", [
            'content' => $message->content,
            'from' => $message->from,
        ]);
    }
}
