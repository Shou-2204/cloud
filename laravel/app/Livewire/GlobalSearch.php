<?php

/*
 * Composant de recherche globale.
 * Utilise Laravel Scout et le modèle virtuel StaticPage.
 * Intègre le filtrage par permissions Jetstream.
 */

namespace App\Livewire;

use Livewire\Component;
use App\Models\StaticPage;
use Illuminate\Support\Facades\Auth;

class GlobalSearch extends Component
{
    public $query = ''; 
    public $results = []; 

    public function updatedQuery()
    {
        // Nettoyage si la requête est trop courte
        if (strlen($this->query) < 2) {
            $this->results = [];
            return;
        }

        // Récupération des permissions de l'utilisateur connecté
        $user = Auth::user();
        $permissions = [];

        if ($user && $user->currentTeam) {
            // Si propriétaire, on donne accès à tout, sinon on liste les droits
            if ($user->ownsTeam($user->currentTeam)) {
                $permissions = ['*']; 
            } else {
                $permissions = $user->teamPermissions($user->currentTeam);
            }
        }

        // Lancement de la recherche via Scout (plus de Client manuel)
        $this->results = StaticPage::search($this->query, function ($meilisearch, $query, $options) use ($permissions) {
            
            // Construction du filtre de sécurité
            $filter = 'permission IS NULL';

            if (!empty($permissions)) {
                // Si l'user est admin (*), on ne filtre pas plus.
                // Sinon, on ajoute ses permissions explicites.
                if (!in_array('*', $permissions)) {
                    $permsString = collect($permissions)
                        ->map(fn($p) => "permission = '$p'")
                        ->join(' OR ');
                    $filter = "($filter) OR ($permsString)";
                } else {
                    // L'utilisateur a tous les droits, on annule le filtre restrictif
                    $filter = null;
                }
            }

            if ($filter) {
                $options['filter'] = $filter;
            }
            
            $options['limit'] = 5;

            return $meilisearch->search($query, $options);
        })->get();
    }

    public function render()
    {
        return view('livewire.global-search');
    }
}