<?php

namespace App\Listeners;

use App\Jobs\UploadInvoiceToS3;
use Laravel\Cashier\Events\WebhookReceived;

class StripeInvoicePaidListener
{
    /**
     * Handle the event.
     */
    public function handle(WebhookReceived $event): void
    {
        if ($event->payload['type'] === 'invoice.payment_succeeded') {
            $invoice = $event->payload['data']['object'];

            // Dispatch job to upload to S3
            UploadInvoiceToS3::dispatch($invoice['id']);
        }
    }
}
