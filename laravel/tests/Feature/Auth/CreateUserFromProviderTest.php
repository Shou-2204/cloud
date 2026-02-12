<?php

namespace Tests\Feature\Auth;

use App\Actions\Auth\CreateUserFromProvider;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Two\User as SocialiteUser;
use Tests\TestCase;

class CreateUserFromProviderTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_a_new_user_if_not_exists()
    {
        $action = app(CreateUserFromProvider::class);

        $socialiteUser = new SocialiteUser;
        $socialiteUser->map([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $user = $action->execute('google', $socialiteUser);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('john@example.com', $user->email);
        $this->assertEquals('John Doe', $user->name);
        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
    }

    public function test_it_retrieves_existing_user()
    {
        $existingUser = User::factory()->create([
            'email' => 'jane@example.com',
            'name' => 'Jane Doe',
        ]);

        $action = app(CreateUserFromProvider::class);

        $socialiteUser = new SocialiteUser;
        $socialiteUser->map([
            'name' => 'Jane Google', // Name might be different on Google
            'email' => 'jane@example.com',
        ]);

        $user = $action->execute('google', $socialiteUser);

        $this->assertEquals($existingUser->id, $user->id);
        $this->assertEquals('Jane Doe', $user->name); // Should keep original name logic (or update it? logic says retrieve only)
        $this->assertEquals(1, User::count());
    }
}
