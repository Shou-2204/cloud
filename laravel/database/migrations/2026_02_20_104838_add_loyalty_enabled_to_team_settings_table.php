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
            $table->boolean('loyalty_enabled')->default(false)->after('reviews_enabled');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('team_settings', function (Blueprint $table) {
            $table->dropColumn('loyalty_enabled');
        });
    }
};
