<?php

namespace App\Livewire;

use Livewire\Component;
use Meilisearch\Client;

class GlobalSearch extends Component
{
    public $query = ''; // Doit être public
    public $results = []; // Doit être public

    // Dans Livewire 3, updatedQuery() est appelé automatiquement quand $query change
    public function updatedQuery()
    {
        if (strlen($this->query) < 2) {
            $this->results = [];
            return;
        }

        try {
            $client = new Client(config('scout.meilisearch.host'), config('scout.meilisearch.key'));
            $index = $client->index('pages');
            
            $searchResponse = $index->search($this->query, ['limit' => 5]);
            $this->results = $searchResponse->getHits();
        } catch (\Exception $e) {
            // Log l'erreur pour voir si c'est un problème de connexion Meilisearch
            \Log::error("Erreur Meilisearch: " . $e->getMessage());
            $this->results = [];
        }
    }

    public function render()
    {
        return view('livewire.global-search');
    }
}