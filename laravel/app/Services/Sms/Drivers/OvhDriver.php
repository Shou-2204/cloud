<?php

namespace App\Services\Sms\Drivers;

use App\Contracts\SmsProvider;
use App\Services\Sms\SmsMessage;
use Exception;
use Illuminate\Support\Facades\Http;

class OvhDriver implements SmsProvider
{
    protected $appKey;

    protected $appSecret;

    protected $consumerKey;

    protected $endpoint;

    protected $serviceName;

    public function __construct($appKey, $appSecret, $consumerKey, $endpoint, $serviceName)
    {
        $this->appKey = $appKey;
        $this->appSecret = $appSecret;
        $this->consumerKey = $consumerKey;
        $this->endpoint = rtrim($endpoint, '/');
        $this->serviceName = $serviceName;
    }

    /**
     * Send the given SMS message to the given number.
     *
     * @throws \Exception
     */
    public function send(string $to, SmsMessage $message): void
    {
        $method = 'POST';
        $uri = "/sms/{$this->serviceName}/jobs";
        $url = $this->endpoint.$uri;

        $body = json_encode([
            'message' => $message->content,
            'receivers' => [$to],
            'senderForResponse' => true, // Optional, depends on config
            'noStopClause' => true,     // Optional
            'sender' => $message->from, // Optional if defined
        ]);

        $time = time(); // Use server time, ideally sync with OVH

        // Calculate Signature
        // "$1$" + SHA1_HEX(AS + CK + METHOD + QUERY + BODY + MSTIMESTAMP)
        $toSign = $this->appSecret.'+'.$this->consumerKey.'+'.$method.'+'.$url.'+'.$body.'+'.$time;
        $signature = '$1$'.sha1($toSign);

        $response = Http::withHeaders([
            'X-Ovh-Application' => $this->appKey,
            'X-Ovh-Consumer' => $this->consumerKey,
            'X-Ovh-Signature' => $signature,
            'X-Ovh-Timestamp' => $time,
            'Content-Type' => 'application/json',
        ])->withBody($body, 'application/json')->post($url);

        if (! $response->successful()) {
            throw new Exception('OVH SMS Error: '.$response->body());
        }
    }
}
