<?php

namespace Tests\Feature;

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class ApplicationAvailabilityTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that all Blade files compile without errors.
     */
    public function test_all_blade_files_compile()
    {
        $viewPaths = [resource_path('views')];
        $exclude = ['vendor']; 
        
        $files = File::allFiles($viewPaths[0]);

        $compiler = app('view')->getEngineResolver()->resolve('blade')->getCompiler();

        foreach ($files as $file) {
            if ($file->getExtension() !== 'php') {
                continue;
            }
            
            if (str_contains($file->getRelativePath(), 'vendor')) {
                continue;
            }
            
            $content = File::get($file->getRealPath());
            
            try {
                $compiler->compileString($content);
                $this->assertTrue(true);
            } catch (\Throwable $e) {
                $this->fail("Blade compilation failed for file: " . $file->getRelativePathname() . "\nError: " . $e->getMessage());
            }
        }
    }

    /**
     * Test basic public routes accessibility.
     */
    public function test_public_routes_are_accessible()
    {
        $routes = [
            '/',
            '/features',
            '/about',
            '/contact',
            '/pricing',
        ];

        foreach ($routes as $route) {
            $response = $this->get($route);
            
            if ($response->status() !== 200) {
                 if (in_array($response->status(), [301, 302])) {
                     $this->assertTrue(true, "Route $route redirected, which is acceptable.");
                 } else {
                     $this->fail("Route $route returned status " . $response->status());
                 }
            } else {
                $response->assertStatus(200);
            }
        }
    }

    /**
     * Test authenticated routes/pages are accessible.
     */
    public function test_authenticated_pages_are_accessible()
    {
        $user = User::factory()->create();
        $team = Team::factory()->create([
            'user_id' => $user->id,
            'personal_team' => true,
            'name' => 'My Team',
        ]);
        
        $user->current_team_id = $team->id;
        $user->save();

        // Authenticate as the user
        $this->actingAs($user);

        // Dashboard
        $response = $this->get(route('dashboard'));
        $response->assertStatus(200);

        // Onboarding
        $response = $this->get(route('onboarding'));
        $response->assertStatus(200);

        // Team Settings (General)
        // Note: Using the route name 'teams.settings' with params
        $response = $this->get(route('teams.settings', ['team' => $team, 'tab' => 'general']));
        $response->assertStatus(200);
    }

    /**
     * Test the team public profile page.
     */
    public function test_public_profile_is_accessible()
    {
        $user = User::factory()->create();
        $team = Team::factory()->create([
            'user_id' => $user->id,
            'personal_team' => true,
            'name' => 'Test Company',
        ]);
        
        // Ensure profile settings exist
        $team->profile()->create([
            'tagline' => 'Best company',
            'bio' => 'We do great things',
        ]);

        // Create a fake active subscription to bypass the policy
        $team->subscriptions()->create([
            'type' => 'default',
            'stripe_id' => 'sub_fake123',
            'stripe_status' => 'active',
            'stripe_price' => 'price_fake123',
            'quantity' => 1,
            'trial_ends_at' => null,
            'ends_at' => null,
        ]);

        $response = $this->get(route('profile.public', $team->public_uuid));

        $response->assertStatus(200);
        $response->assertSee('Test Company');
        $response->assertSee('Best company');
    }
}
