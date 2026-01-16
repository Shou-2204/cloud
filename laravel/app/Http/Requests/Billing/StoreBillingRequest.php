<?php

declare(strict_types=1);

namespace App\Http\Requests\Billing;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validates billing information for checkout and billing updates.
 */
class StoreBillingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'billing_name' => 'required|string|max:255',
            'billing_address' => 'required|string|max:255',
            'billing_address_line2' => 'nullable|string|max:255',
            'billing_city' => 'required|string|max:255',
            'billing_state' => 'nullable|string|max:255',
            'billing_postal_code' => 'required|string|max:20',
            'billing_country' => 'required|string|max:2',
            'vat_id' => 'nullable|string|max:50',
            'price' => 'nullable|string', // Only required for checkout, not billing update
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'billing_name.required' => 'Le nom de facturation est requis.',
            'billing_address.required' => 'L\'adresse de facturation est requise.',
            'billing_city.required' => 'La ville est requise.',
            'billing_postal_code.required' => 'Le code postal est requis.',
            'billing_country.required' => 'Le pays est requis.',
        ];
    }
}
