<?php

namespace App\Jobs;

use App\Models\Team;
use App\Models\TeamInvoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Laravel\Cashier\Cashier;

class UploadInvoiceToS3 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $invoiceId;

    /**
     * Create a new job instance.
     */
    public function __construct($invoiceId)
    {
        $this->invoiceId = $invoiceId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // 1. Retrieve the Invoice from Stripe
        $stripeInvoice = Cashier::stripe()->invoices->retrieve($this->invoiceId);

        // Ensure the invoice is paid and belongs to a team (customer)
        if ($stripeInvoice->status !== 'paid' || !$stripeInvoice->customer) {
            return;
        }

        // Find the team by stripe_id
        $team = Team::where('stripe_id', $stripeInvoice->customer)->first();

        if (!$team) {
            // Log warning: Team not found for invoice
            return;
        }

        // 2. Download PDF
        if (!empty($stripeInvoice->invoice_pdf)) {
            $pdfContent = file_get_contents($stripeInvoice->invoice_pdf);

            if ($pdfContent) {
                // 3. Upload to S3
                $filename = 'invoices/' . $team->id . '/' . $stripeInvoice->id . '.pdf';
                Storage::disk('s3')->put($filename, $pdfContent);

                // 4. Create/Update record in team_invoices
                TeamInvoice::updateOrCreate(
                    ['stripe_id' => $stripeInvoice->id],
                    [
                        'team_id' => $team->id,
                        'amount' => $stripeInvoice->total, // Amount in cents
                        'currency' => $stripeInvoice->currency,
                        'status' => $stripeInvoice->status,
                        's3_path' => $filename,
                        'issued_at' => \Carbon\Carbon::createFromTimestamp($stripeInvoice->created),
                    ]
                );
            }
        }
    }
}
