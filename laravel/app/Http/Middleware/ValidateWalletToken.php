<?php

namespace App\Http\Middleware;

use App\Models\CrmContact;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateWalletToken
{
    /**
     * Validate the Apple Wallet authentication token.
     *
     * Apple Wallet sends: Authorization: ApplePass <token>
     * We compare against the CrmContact's wallet_auth_token for the given serialNumber.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authHeader = $request->header('Authorization', '');

        // Extract token from "ApplePass <token>" format
        if (!str_starts_with($authHeader, 'ApplePass ')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $token = substr($authHeader, strlen('ApplePass '));

        if (empty($token)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // The serialNumber is the CrmContact UUID — resolve from route parameter
        $serialNumber = $request->route('serialNumber');

        if (!$serialNumber) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $contact = CrmContact::where('id', $serialNumber)->first();

        if (!$contact || !$contact->wallet_auth_token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if (!hash_equals($contact->wallet_auth_token, $token)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Store the contact on the request for use in controllers
        $request->attributes->set('wallet_contact', $contact);

        return $next($request);
    }
}
