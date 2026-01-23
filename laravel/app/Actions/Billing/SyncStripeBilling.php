<?php

declare(strict_types=1);

namespace App\Actions\Billing;

use App\Models\Team;
use Exception;

/**
 * Synchronizes team billing information with Stripe.
 * Handles customer details sync and Tax ID management.
 */
class SyncStripeBilling
{
    /**
     * Execute the action.
     */
    public function execute(Team $team): void
    {
        if (! $team->hasStripeId()) {
            return;
        }

        // Sync Customer Details (Name & Address)
        $team->syncStripeCustomerDetails();

        // Manage Tax IDs
        $this->syncTaxIds($team);
    }

    /**
     * Sync Tax IDs with Stripe.
     */
    protected function syncTaxIds(Team $team): void
    {
        $existingTaxIds = $team->taxIds();
        $vatId = $team->vat_id;

        // If no VAT ID provided, remove all existing ones
        if (empty($vatId)) {
            foreach ($existingTaxIds as $taxId) {
                $team->deleteTaxId($taxId->id);
            }

            return;
        }

        $type = $this->determineTaxIdType($vatId);

        // Check if we already have this Tax ID
        $hasTaxId = $existingTaxIds->contains(function ($t) use ($vatId, $type): bool {
            return $t->value === $vatId && $t->type === $type;
        });

        if ($hasTaxId) {
            return;
        }

        // Remove old Tax IDs
        foreach ($existingTaxIds as $taxId) {
            $team->deleteTaxId($taxId->id);
        }

        // Create new Tax ID
        try {
            $team->createTaxId($type, $vatId);
        } catch (Exception $e) {
            // Ignore invalid tax ID errors from Stripe
            report($e);
        }
    }

    /**
     * Determine the Stripe Tax ID type based on the VAT ID format.
     */
    protected function determineTaxIdType(string $vatId): string
    {
        $vatId = strtoupper(trim($vatId));

        if (str_starts_with($vatId, 'GB')) {
            return 'gb_vat';
        }

        if (str_starts_with($vatId, 'CH')) {
            return 'ch_vat';
        }

        // Default to EU VAT
        return 'eu_vat';
    }
}
