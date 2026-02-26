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
            $table->enum('loyalty_program_type', ['visits', 'points'])->nullable()->after('loyalty_enabled');
            $table->timestamp('last_loyalty_scan_at')->nullable()->after('loyalty_program_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('team_settings', function (Blueprint $table) {
            $table->dropColumn(['loyalty_program_type', 'last_loyalty_scan_at']);
        });
    }
};
