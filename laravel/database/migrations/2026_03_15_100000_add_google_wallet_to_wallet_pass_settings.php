<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('wallet_pass_settings', function (Blueprint $table) {
            $table->string('google_wallet_class_id')->nullable()->after('relevant_text');
            $table->timestamp('google_class_synced_at')->nullable()->after('google_wallet_class_id');
        });
    }

    public function down(): void
    {
        Schema::table('wallet_pass_settings', function (Blueprint $table) {
            $table->dropColumn(['google_wallet_class_id', 'google_class_synced_at']);
        });
    }
};
