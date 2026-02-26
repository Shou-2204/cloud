<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add 'type' column to loyalty_redemptions for logging expiration events
        Schema::table('loyalty_redemptions', function (Blueprint $table) {
            $table->string('type', 20)->default('consume')->after('id'); // 'consume' or 'expiration'
        });

        // Add 'magic_link_used_at' to crm_contacts for one-time magic link support
        Schema::table('crm_contacts', function (Blueprint $table) {
            $table->timestamp('magic_link_used_at')->nullable()->after('last_scanned_at');
        });

        // Convert loyalty_points_expiration_date from MM-DD string to a proper DATE for robustness
        Schema::table('team_settings', function (Blueprint $table) {
            $table->date('loyalty_points_next_expiration')->nullable()->after('loyalty_points_expiration_date');
        });
    }

    public function down(): void
    {
        Schema::table('loyalty_redemptions', function (Blueprint $table) {
            $table->dropColumn('type');
        });
        Schema::table('crm_contacts', function (Blueprint $table) {
            $table->dropColumn('magic_link_used_at');
        });
        Schema::table('team_settings', function (Blueprint $table) {
            $table->dropColumn('loyalty_points_next_expiration');
        });
    }
};
