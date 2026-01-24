<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Create new tables
        Schema::create('team_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();

            $table->string('tagline')->nullable();
            $table->text('bio')->nullable();
            $table->string('logo_path', 2048)->nullable();
            $table->string('cover_image_path', 2048)->nullable();

            // Contact Public
            $table->string('website')->nullable();
            $table->string('email_public')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();

            // Social
            $table->string('social_instagram')->nullable();
            $table->string('social_facebook')->nullable();
            $table->string('social_tiktok')->nullable();
            $table->string('social_linkedin')->nullable();
            $table->string('social_twitter')->nullable();

            $table->unsignedInteger('public_views')->default(0);

            $table->timestamps();
        });

        Schema::create('team_billing_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();

            $table->string('billing_name')->nullable();
            $table->string('billing_address')->nullable();
            $table->string('billing_address_line2')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_state')->nullable();
            $table->string('billing_postal_code')->nullable();
            $table->string('billing_country')->nullable();
            $table->string('vat_id')->nullable();

            $table->timestamps();
        });

        Schema::create('team_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();

            $table->string('digest_frequency')->nullable();
            $table->string('feedback_email')->nullable();

            // Reviews
            $table->boolean('reviews_enabled')->default(false);
            $table->text('review_positive_message')->nullable();
            $table->text('review_negative_message')->nullable();
            $table->string('google_review_url')->nullable();

            // Google Integration (API Key dropped, Place ID moved)
            $table->string('google_place_id')->nullable();
            $table->json('google_business_data')->nullable();

            $table->timestamps();
        });

        // 2. Migrate Data
        // 2. Migrate Data
        // We iterate over teams and insert into new tables.
        // Using raw SQL and cursor for performance/memory safety.

        $teams = DB::table('teams')->cursor();

        foreach ($teams as $team) {
            // Profile
            DB::table('team_profiles')->insert([
                'team_id' => $team->id,
                'tagline' => $team->tagline ?? null,
                'bio' => $team->bio ?? null,
                'logo_path' => $team->logo_path ?? null,
                'cover_image_path' => $team->cover_image_path ?? null,
                'website' => $team->website ?? null,
                'email_public' => $team->email_public ?? null,
                'phone' => $team->phone ?? null,
                'address' => $team->address ?? null,
                'social_instagram' => $team->social_instagram ?? null,
                'social_facebook' => $team->social_facebook ?? null,
                'social_tiktok' => $team->social_tiktok ?? null,
                'social_linkedin' => $team->social_linkedin ?? null,
                'social_twitter' => $team->social_twitter ?? null,
                'public_views' => $team->public_views ?? 0,
                'created_at' => $team->created_at,
                'updated_at' => $team->updated_at,
            ]);

            // Billing
            DB::table('team_billing_details')->insert([
                'team_id' => $team->id,
                'billing_name' => $team->billing_name ?? null,
                'billing_address' => $team->billing_address ?? null,
                'billing_address_line2' => $team->billing_address_line2 ?? null,
                'billing_city' => $team->billing_city ?? null,
                'billing_state' => $team->billing_state ?? null,
                'billing_postal_code' => $team->billing_postal_code ?? null,
                'billing_country' => $team->billing_country ?? null,
                'vat_id' => $team->vat_id ?? null,
                'created_at' => $team->created_at,
                'updated_at' => $team->updated_at,
            ]);

            // Settings
            DB::table('team_settings')->insert([
                'team_id' => $team->id,
                'digest_frequency' => $team->digest_frequency ?? null,
                'feedback_email' => $team->feedback_email ?? null,
                'reviews_enabled' => $team->reviews_enabled ?? 0,
                'review_positive_message' => $team->review_positive_message ?? null,
                'review_negative_message' => $team->review_negative_message ?? null,
                'google_review_url' => $team->google_review_url ?? null,
                'google_place_id' => $team->google_place_id ?? null,
                'google_business_data' => $team->google_business_data ?? null,
                'created_at' => $team->created_at,
                'updated_at' => $team->updated_at,
            ]);
        }

        // 3. Drop Columns from Teams
        Schema::table('teams', function (Blueprint $table) {
            $table->dropColumn([
                // Profile
                'tagline',
                'bio',
                'logo_path',
                'cover_image_path',
                'website',
                'email_public',
                'phone',
                'address',
                'social_instagram',
                'social_facebook',
                'social_tiktok',
                'social_linkedin',
                'social_twitter',
                'public_views',

                // Billing
                'billing_name',
                'billing_address',
                'billing_address_line2',
                'billing_city',
                'billing_state',
                'billing_postal_code',
                'billing_country',
                'vat_id',

                // Settings
                'digest_frequency',
                'feedback_email',
                'reviews_enabled',
                'review_positive_message',
                'review_negative_message',
                'google_review_url',
                'google_place_id',
                'google_business_data',

                // Dropped completely
                'google_api_key',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Add columns back to Teams
        Schema::table('teams', function (Blueprint $table) {
            // Profile
            $table->string('tagline')->nullable();
            $table->text('bio')->nullable();
            $table->string('logo_path', 2048)->nullable();
            $table->string('cover_image_path', 2048)->nullable();
            $table->string('website')->nullable();
            $table->string('email_public')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('social_instagram')->nullable();
            $table->string('social_facebook')->nullable();
            $table->string('social_tiktok')->nullable();
            $table->string('social_linkedin')->nullable();
            $table->string('social_twitter')->nullable();
            $table->unsignedInteger('public_views')->default(0);

            // Billing
            $table->string('billing_name')->nullable();
            $table->string('billing_address')->nullable();
            $table->string('billing_address_line2')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_state')->nullable();
            $table->string('billing_postal_code')->nullable();
            $table->string('billing_country')->nullable();
            $table->string('vat_id')->nullable();

            // Settings
            $table->string('digest_frequency')->nullable();
            $table->string('feedback_email')->nullable();
            $table->boolean('reviews_enabled')->default(false);
            $table->text('review_positive_message')->nullable();
            $table->text('review_negative_message')->nullable();
            $table->string('google_review_url')->nullable();
            $table->string('google_place_id')->nullable();
            $table->json('google_business_data')->nullable();

            // Was dropped completely
            $table->text('google_api_key')->nullable();
        });

        // 2. Restore Data (Reverse)
        $profiles = DB::table('team_profiles')->cursor();
        foreach ($profiles as $profile) {
            DB::table('teams')->where('id', $profile->team_id)->update([
                'tagline' => $profile->tagline,
                'bio' => $profile->bio,
                'logo_path' => $profile->logo_path,
                'cover_image_path' => $profile->cover_image_path,
                'website' => $profile->website,
                'email_public' => $profile->email_public,
                'phone' => $profile->phone,
                'address' => $profile->address,
                'social_instagram' => $profile->social_instagram,
                'social_facebook' => $profile->social_facebook,
                'social_tiktok' => $profile->social_tiktok,
                'social_linkedin' => $profile->social_linkedin,
                'social_twitter' => $profile->social_twitter,
                'public_views' => $profile->public_views,
            ]);
        }

        $billings = DB::table('team_billing_details')->cursor();
        foreach ($billings as $billing) {
            DB::table('teams')->where('id', $billing->team_id)->update([
                'billing_name' => $billing->billing_name,
                'billing_address' => $billing->billing_address,
                'billing_address_line2' => $billing->billing_address_line2,
                'billing_city' => $billing->billing_city,
                'billing_state' => $billing->billing_state,
                'billing_postal_code' => $billing->billing_postal_code,
                'billing_country' => $billing->billing_country,
                'vat_id' => $billing->vat_id,
            ]);
        }

        $settings = DB::table('team_settings')->cursor();
        foreach ($settings as $setting) {
            DB::table('teams')->where('id', $setting->team_id)->update([
                'digest_frequency' => $setting->digest_frequency,
                'feedback_email' => $setting->feedback_email,
                'reviews_enabled' => $setting->reviews_enabled,
                'review_positive_message' => $setting->review_positive_message,
                'review_negative_message' => $setting->review_negative_message,
                'google_review_url' => $setting->google_review_url,
                'google_place_id' => $setting->google_place_id,
                'google_business_data' => $setting->google_business_data,
            ]);
        }

        // 3. Drop Tables
        Schema::dropIfExists('team_profiles');
        Schema::dropIfExists('team_billing_details');
        Schema::dropIfExists('team_settings');
    }
};
