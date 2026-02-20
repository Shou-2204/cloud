<?php

namespace App\Helpers;

use Propaganistas\LaravelPhone\PhoneNumber;

class PhoneHelper
{
    /**
     * Normalize a phone number to E.164 format.
     *
     * @param  string|null  $phone  The raw phone input
     * @param  string  $country  Default country code (ISO 3166-1 alpha-2)
     * @return string|null  The E.164 formatted number, or null if empty/invalid
     */
    public static function toE164(?string $phone, string $country = 'FR'): ?string
    {
        if (empty($phone)) {
            return null;
        }

        try {
            return (new PhoneNumber($phone, $country))->formatE164();
        } catch (\Exception $e) {
            // If parsing fails, return the original value
            // This ensures existing data isn't lost during migration
            return $phone;
        }
    }
}
