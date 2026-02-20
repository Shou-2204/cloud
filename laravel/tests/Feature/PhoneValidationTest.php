<?php

namespace Tests\Feature;

use App\Helpers\PhoneHelper;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PhoneValidationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that PhoneHelper normalizes valid French numbers to E.164.
     */
    public function test_phone_helper_normalizes_french_numbers(): void
    {
        // Standard mobile format
        $this->assertEquals('+33612345678', PhoneHelper::toE164('06 12 34 56 78'));
        $this->assertEquals('+33612345678', PhoneHelper::toE164('0612345678'));
        $this->assertEquals('+33612345678', PhoneHelper::toE164('+33 6 12 34 56 78'));
        $this->assertEquals('+33612345678', PhoneHelper::toE164('+33612345678'));

        // Landline
        $this->assertEquals('+33123456789', PhoneHelper::toE164('01 23 45 67 89'));

        // Null and empty
        $this->assertNull(PhoneHelper::toE164(null));
        $this->assertNull(PhoneHelper::toE164(''));
    }

    /**
     * Test that PhoneHelper returns original value for invalid numbers.
     */
    public function test_phone_helper_returns_original_for_invalid(): void
    {
        // Very short number - should be returned as-is
        $result = PhoneHelper::toE164('123');
        $this->assertEquals('123', $result);
    }

    /**
     * Test that phone validation rejects invalid numbers in UpdateUserProfileInformation.
     */
    public function test_user_profile_rejects_invalid_phone(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->put('/user/profile-information', [
            'name' => 'Test User',
            'email' => $user->email,
            'phone' => 'not-a-phone',
        ]);

        // Fortify uses the 'updateProfileInformation' error bag
        $response->assertSessionHasErrors(['phone'], null, 'updateProfileInformation');
    }

    /**
     * Test that phone validation accepts valid French numbers.
     */
    public function test_user_profile_accepts_valid_french_phone(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->put('/user/profile-information', [
            'name' => 'Test User',
            'email' => $user->email,
            'phone' => '06 12 34 56 78',
        ]);

        $response->assertSessionDoesntHaveErrors(['phone']);

        // Verify the phone was normalized to E.164
        $this->assertEquals('+33612345678', $user->fresh()->phone);
    }

    /**
     * Test phone uniqueness on users table.
     */
    public function test_user_phone_must_be_unique(): void
    {
        // Create a user with a normalized E.164 phone
        $existingUser = User::factory()->create(['phone' => '+33612345678']);
        $newUser = User::factory()->create();

        $this->actingAs($newUser);

        $response = $this->put('/user/profile-information', [
            'name' => 'New User',
            'email' => $newUser->email,
            'phone' => '+33612345678', // Exact same E.164 number
        ]);

        // Fortify uses the 'updateProfileInformation' error bag
        $response->assertSessionHasErrors(['phone'], null, 'updateProfileInformation');
    }

    /**
     * Test that null phone is allowed (not unique constraint issue).
     */
    public function test_null_phone_is_allowed(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->put('/user/profile-information', [
            'name' => 'Test User',
            'email' => $user->email,
            'phone' => '',
        ]);

        $response->assertSessionDoesntHaveErrors(['phone']);
    }
}
