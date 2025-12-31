<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Meilisearch\Client;

class ShoucloudPageIndexer extends Command
{
    // C'est ici qu'on définit le nom de la commande à taper
    protected $signature = 'shoucloud:index-pages';

    protected $description = 'Indexe les pages de navigation ShouCloud dans Meilisearch';

    public function handle()
    {
        $client = new Client(config('scout.meilisearch.host'), config('scout.meilisearch.key'));
        $index = $client->index('pages');

        $pages = [
            [
                'id' => 'nav_dashboard',
                'title' => 'Tableau de bord',
                'description' => 'Vue d\'ensemble de votre activité',
                'url' => '/dashboard',
                'category' => 'Navigation'
            ],
            [
                'id' => 'nav_profile',
                'title' => 'Mon Profil',
                'description' => 'Gérer vos infos et la sécurité',
                'url' => '/user/profile',
                'category' => 'Paramètres'
            ],
            [
                'id' => 'nav_teams',
                'title' => 'Équipe',
                'description' => 'Gérer les membres de l\'Équipe',
                'url' => '/teams',
                'category' => 'Paramètres'
            ],
        ];

        // On envoie les données à Meilisearch
        $index->addDocuments($pages);

        $this->info('🚀 ShouCloud : Indexation terminée !');
    }
}