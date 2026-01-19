<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            // Public Profile Identity
            $table->uuid('public_uuid')->unique()->nullable()->after('id');

            // Branding & Content
            $table->string('tagline')->nullable()->after('name');
            $table->text('bio')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('cover_image_path')->nullable();

            // Contact Information
            $table->string('phone')->nullable();
            $table->string('email_public')->nullable();
            $table->string('website')->nullable();
            $table->string('address')->nullable()->after('billing_address'); // Public address might differ from billing

            // Social Media Links
            $table->string('social_instagram')->nullable();
            $table->string('social_facebook')->nullable();
            $table->string('social_tiktok')->nullable();
            $table->string('social_linkedin')->nullable();
            $table->string('social_twitter')->nullable();

            // Google Business & Analytics
            $table->string('google_place_id')->nullable();
            $table->json('google_business_data')->nullable();
            $table->unsignedBigInteger('public_views')->default(0);

            // Review Gating Settings
            $table->boolean('reviews_enabled')->default(true);
            $table->string('google_review_url')->nullable(); // Direct link to G-Business review form
            $table->text('review_positive_message')->nullable(); // "Thanks! Post on Google?"
            $table->text('review_negative_message')->nullable(); // "Sorry! Tell us why."
        });

        // Backfill UUIDs for existing teams
        DB::table('teams')->cursor()->each(function ($team) {
            DB::table('teams')
                ->where('id', $team->id)
                ->update(['public_uuid' => (string) Str::uuid()]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropColumn([
                'public_uuid',
                'tagline',
                'bio',
                'logo_path',
                'cover_image_path',
                'phone',
                'email_public',
                'website',
                'address',
                'social_instagram',
                'social_facebook',
                'social_tiktok',
                'social_linkedin',
                'social_twitter',
                'google_place_id',
                'google_business_data',
                'public_views',
                'reviews_enabled',
                'google_review_url',
                'review_positive_message',
                'review_negative_message',
            ]);
        });
    }
};
