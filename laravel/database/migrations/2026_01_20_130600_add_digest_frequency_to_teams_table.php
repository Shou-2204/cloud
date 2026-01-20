<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->string('digest_frequency')->default('daily')->after('feedback_email');
            // daily = every day at 8h
            // weekly = every Monday at 8h
            // monthly = 1st of month at 8h
            // none = disabled
        });
    }

    public function down(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropColumn('digest_frequency');
        });
    }
};
