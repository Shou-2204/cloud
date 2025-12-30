<?php

use App\Models\Team;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // On récupère toutes les équipes qui n'ont pas de code (ou code vide)
        $teams = Team::whereNull('join_code')->orWhere('join_code', '')->get();

        foreach ($teams as $team) {
            // On génère un code manuellement pour chacune
            $team->join_code = strtoupper(Str::random(8));
            
            // On sauvegarde sans déclencher d'événements inutiles
            $team->saveQuietly(); 
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Pas de retour en arrière nécessaire pour de la génération de données
    }
};