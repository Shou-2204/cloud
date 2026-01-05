<?php

/*
 * Modèle virtuel pour l'indexation des pages statiques et de navigation via Sushi.
 * Remplace l'ancienne commande manuelle ShoucloudPageIndexer.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Sushi\Sushi;

class StaticPage extends Model
{
    use Sushi;
    use Searchable;

    protected $schema = [
        'title' => 'string',
        'url' => 'string',
        'content' => 'text',
        'category' => 'string',
        'permission' => 'string',
    ];

    public function getRows()
    {
        return [
            [
                'title' => 'Tableau de bord',
                'url' => '/dashboard',
                'content' => 'Vue d\'ensemble de votre activité, accueil, start, home',
                'category' => 'Navigation',
                'permission' => null,
            ],
            [
                'title' => 'Mon Profil',
                'url' => '/user/profile',
                'content' => 'Gérer vos infos, sécurité, mot de passe, 2fa, avatar',
                'category' => 'Paramètres',
                'permission' => null,
            ],
            [
                'title' => 'Équipe',
                'url' => '/myteams', 
                'content' => 'Gérer les membres de l\'Équipe, invitation, settings',
                'category' => 'Paramètres',
                'permission' => null, 
            ],
            [
                'title' => 'Tarifs',
                'url' => '/pricing',
                'content' => 'Abonnements, factures, offres, business, pro',
                'category' => 'Général',
                'permission' => null,
            ]
        ];
    }

    public function toSearchableArray()
    {
        return [
            'id' => md5($this->url), 
            'title' => $this->title,
            'url' => $this->url,
            'content' => $this->content, 
            'category' => $this->category,
            'permission' => $this->permission,
        ];
    }
    
    public function getScoutKey()
    {
        return md5($this->url);
    }

    public function getScoutKeyName()
    {
        return 'id';
    }
}
