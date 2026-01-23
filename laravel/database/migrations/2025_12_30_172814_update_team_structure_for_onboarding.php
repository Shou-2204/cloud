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
        Schema::table('users', function (Blueprint $table) {
            // L'utilisateur n'a pas d'équipe à l'inscription
            // On rend la colonne nullable
            $table->foreignId('current_team_id')->nullable()->change();
        });

        Schema::table('teams', function (Blueprint $table) {
            // Code unique pour rejoindre (ex: "X8J2P")
            $table->string('join_code', 10)->unique()->nullable()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Attention au rollback : si des users n'ont pas de team, ça peut planter ici
            $table->foreignId('current_team_id')->nullable(false)->change();
        });

        Schema::table('teams', function (Blueprint $table) {
            $table->dropColumn('join_code');
        });
    }
};
