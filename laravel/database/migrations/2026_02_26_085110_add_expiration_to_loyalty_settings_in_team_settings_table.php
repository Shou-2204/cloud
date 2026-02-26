<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('team_settings', function (Blueprint $table) {
            $table->boolean('loyalty_points_expire')->default(false)->after('last_loyalty_scan_at');
            $table->string('loyalty_points_expiration_date', 5)->nullable()->after('loyalty_points_expire'); // MM-DD
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('team_settings', function (Blueprint $table) {
            $table->dropColumn(['loyalty_points_expire', 'loyalty_points_expiration_date']);
        });
    }
};
