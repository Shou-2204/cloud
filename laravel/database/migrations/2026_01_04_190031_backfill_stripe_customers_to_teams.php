<?php

use App\Models\Team;
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
        // On désactive la protection des timestamps pour ne pas modifier 'updated_at'
        Team::withoutTimestamps(function () {
            
            // On prend toutes les équipes qui n'ont pas encore de compte Stripe
            // On charge le 'owner' car on a besoin de son email
            $teams = Team::whereNull('stripe_id')->with('owner')->cursor();

            foreach ($teams as $team) {
                // Si l'équipe n'a pas de owner (cas rare/bug), on passe
                if (! $team->owner) {
                    continue;
                }

                try {
                    // Création du client chez Stripe
                    $team->createAsStripeCustomer([
                        'email' => $team->owner->email,
                        'name'  => $team->name,
                    ]);
                    
                    // Optionnel : un petit output dans la console pour voir que ça avance
                    // echo "Equipe {$team->name} connectée à Stripe.\n";

                } catch (\Exception $e) {
                    // On log l'erreur mais on ne bloque pas la migration pour les autres
                    // Log::error("Erreur Stripe pour l'équipe {$team->id}: " . $e->getMessage());
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // On ne fait rien au rollback.
        // Supprimer les clients Stripe lors d'un rollback serait dangereux.
    }
};