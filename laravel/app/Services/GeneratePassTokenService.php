<?php

namespace App\Services;

use App\Models\CrmContact;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;

class GeneratePassTokenService
{
    /**
     * Génère et assigne un token unique pour les pass Apple/Google Wallet.
     * Le format est IZC-XXXXXXX (7 caractères alphanumériques aléatoires).
     *
     * @param CrmContact $customer Le client à mettre à jour
     * @return CrmContact Le client mis à jour avec son nouveau token
     */
    public function assignToken(CrmContact $customer): CrmContact
    {
        $maxRetries = 5;
        $attempts = 0;

        while ($attempts < $maxRetries) {
            // 1. Génération de la chaîne aléatoire de 7 caractères (majuscules/chiffres)
            $randomString = strtoupper(Str::random(7));
            $token = 'IZC-' . $randomString;

            // 2. Vérification d'existence dans la base de données
            if (CrmContact::where('pass_token', $token)->exists()) {
                $attempts++;
                continue;
            }

            try {
                // 3. Mise à jour du client
                $customer->update([
                    'pass_token' => $token
                ]);

                // Si succès, on retourne le client
                return $customer;

            } catch (QueryException $e) {
                // 4. Interception de l'exception de violation d'unicité (SQLSTATE 23000)
                // Cela survient si une race condition parfaite se produit entre le exists() et le update()
                if ($e->getCode() == 23000) {
                    $attempts++;
                    continue;
                }

                // Si c'est une autre erreur DB, on la relance
                throw $e;
            }
        }

        throw new \Exception("Impossible de générer un pass_token unique après {$maxRetries} tentatives.");
    }
}
