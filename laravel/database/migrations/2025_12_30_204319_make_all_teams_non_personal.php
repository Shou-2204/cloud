<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB; // <--- N'oublie pas ça

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // On passe la colonne 'personal_team' à 0 (false) pour TOUTES les équipes
        DB::table('teams')->update(['personal_team' => 0]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Impossible de revenir en arrière automatiquement car on ne sait pas
        // quelles équipes étaient personnelles avant.
    }
};
