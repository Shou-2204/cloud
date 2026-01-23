<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->tinyInteger('rating');           // 1-5 stars
            $table->text('feedback')->nullable();    // Feedback text (for negative reviews)
            $table->string('session_hash')->nullable(); // For anti-spam tracking
            $table->boolean('notified')->default(false); // Included in daily digest?
            $table->timestamps();

            $table->index(['team_id', 'created_at']);
            $table->index(['team_id', 'notified']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_ratings');
    }
};
