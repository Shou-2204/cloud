<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Mockery;
use Tests\TestCase;

class AppleAuthTest extends TestCase
{
    public function test_it_does_not_log_request_data_on_apple_auth_failure()
    {
        // Mock Socialite to throw an exception
        Socialite::shouldReceive('driver')->with('apple')->andReturnSelf();
        Socialite::shouldReceive('user')->andThrow(new \Exception('Apple auth failed'));

        // We expect a single log call, and we want to ensure 'request' is NOT in the context array
        Log::shouldReceive('error')
            ->once()
            ->withArgs(function ($message, $context) {
                return str_contains($message, 'Apple Auth Error') && !array_key_exists('request', $context);
            });

        // Make the request with some dummy sensitive data
        $response = $this->get('/auth/apple/callback?code=sensitive_code&id_token=sensitive_token&state=sensitive_state');

        // Should redirect to login with an error message
        $response->assertRedirect('/login');
        $response->assertSessionHas('error', 'Erreur de connexion Apple.');
    }
}
