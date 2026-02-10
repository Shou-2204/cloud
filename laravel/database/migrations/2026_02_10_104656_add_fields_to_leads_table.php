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
        Schema::table('leads', function (Blueprint $table) {
            $table->string('name')->nullable()->after('email');
            $table->string('phone')->nullable()->after('name');
            $table->string('status')->default('new')->after('phone');
            $table->integer('follow_up_step')->default(0)->after('status');
            $table->timestamp('last_contacted_at')->nullable()->after('follow_up_step');
            $table->timestamp('next_follow_up_at')->nullable()->after('last_contacted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn([
                'name',
                'phone',
                'status',
                'follow_up_step',
                'last_contacted_at',
                'next_follow_up_at',
            ]);
        });
    }
};
