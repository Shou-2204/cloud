<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SlackNotificationService
{
    /**
     * Send a notification to the Billing channel.
     */
    public function notifyBilling(string $message): void
    {
        $this->send('billing', $message);
    }

    /**
     * Send a notification to the Users channel (Signups).
     */
    public function notifyUser(string $message): void
    {
        $this->send('users', $message);
    }

    /**
     * Send a notification to the Leads channel.
     */
    public function notifyLead(string $message): void
    {
        $this->send('leads', $message);
    }

    /**
     * Send a notification to the Bugs channel.
     */
    public function notifyBug(string $message): void
    {
        $this->send('bugs', $message);
    }

    /**
     * Generic send method.
     */
    protected function send(string $channel, string $message): void
    {
        $url = config("services.slack.webhooks.{$channel}");

        if (empty($url)) {
            Log::warning("Slack webhook for '{$channel}' is not configured.");
            return;
        }

        try {
            Http::post($url, [
                'text' => $message,
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to send Slack notification to '{$channel}': " . $e->getMessage());
        }
    }
}
