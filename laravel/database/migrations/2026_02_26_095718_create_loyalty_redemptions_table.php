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
        Schema::create('loyalty_redemptions', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID v7 primary key
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('crm_contact_id')->constrained()->cascadeOnDelete();
            $table->foreignId('loyalty_reward_id')->nullable()->constrained()->nullOnDelete();
            $table->integer('points_spent');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loyalty_redemptions');
    }
};
