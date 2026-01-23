<?php

namespace App\Services\Sms\Drivers;

use App\Contracts\SmsProvider;
use App\Services\Sms\SmsMessage;
use Illuminate\Support\Facades\Http;
use Exception;

class TwilioDriver implements SmsProvider
{
    protected $sid;
    protected $token;
    protected $from;

    public function __construct($sid, $token, $from)
    {
        $this->sid = $sid;
        $this->token = $token;
        $this->from = $from;
    }

    /**
     * Send the given SMS message to the given number.
     *
     * @param  string  $to
     * @param  \App\Services\Sms\SmsMessage  $message
     * @return void
     * @throws \Exception
     */
    public function send(string $to, SmsMessage $message): void
    {
        $url = "https://api.twilio.com/2010-04-01/Accounts/{$this->sid}/Messages.json";

        $payload = [
            'To' => $to,
            'From' => $message->from ?: $this->from,
            'Body' => $message->content,
        ];

        $response = Http::withBasicAuth($this->sid, $this->token)
            ->asForm()
            ->post($url, $payload);

        if (! $response->successful()) {
            throw new Exception("Twilio SMS Error: " . $response->body());
        }
    }
}
