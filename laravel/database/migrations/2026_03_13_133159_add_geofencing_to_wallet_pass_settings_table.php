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
        Schema::table('wallet_pass_settings', function (Blueprint $table) {
            $table->decimal('latitude', 10, 8)->nullable()->after('campaign_message');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            $table->string('relevant_text')->nullable()->after('longitude');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wallet_pass_settings', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude', 'relevant_text']);
        });
    }
};
