<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Sushi\Sushi;

class StaticPage extends Model
{
    use Searchable;
    use Sushi;

    // 1. IMPORTANT : On dit à Eloquent que l'ID n'est pas un chiffre auto-incrémenté
    public $incrementing = false;

    protected $keyType = 'string';

    protected $schema = [
        'id' => 'string', // 2. On définit explicitement la colonne ID dans le schéma
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
                // 3. On génère l'ID tout de suite, ici. Plus de magie plus tard.
                'id' => md5('/dashboard'),
                'title' => 'Tableau de bord',
                'url' => '/dashboard',
                'content' => 'Vue d\'ensemble de votre activité, accueil, start, home, dashboard',
                'category' => 'Navigation',
                'permission' => 'public',
            ],
            [
                'id' => md5('/user/profile'),
                'title' => 'Mon Profil',
                'url' => '/user/profile',
                'content' => 'Gérer vos infos, sécurité, mot de passe, 2fa, avatar',
                'category' => 'Paramètres',
                'permission' => 'public',
            ],
            [
                'id' => md5('/myteam'),
                'title' => 'Équipe',
                'url' => '/myteam',
                'content' => 'Gérer les membres de l\'Équipe, invitation, settings, team',
                'category' => 'Paramètres',
                'permission' => 'public',
            ],
            [
                'id' => md5('/mysubscription'),
                'title' => 'Mon offre',
                'url' => '/mysubscription',
                'content' => 'Gérer mon offre, changer de plan, factures, Starter, Smart, Pro, Upgrade, abonnement',
                'category' => 'Facturation',
                'permission' => 'public',
            ],
            [
                'id' => md5('/pricing'),
                'title' => 'Tarifs',
                'url' => '/pricing',
                'content' => 'Abonnements, factures, offres, business, pro, prix',
                'category' => 'Général',
                'permission' => 'public',
            ],
            [
                'id' => md5('/reviews/stats'),
                'title' => 'Mes données',
                'url' => '/reviews/stats',
                'content' => 'Statistiques des avis, graphiques, notes moyennes, évolution, analytics',
                'category' => 'Avis',
                'permission' => 'subscribed',
            ],
            [
                'id' => md5('/reviews/public'),
                'title' => 'Mes avis publics',
                'url' => '/reviews/public',
                'content' => 'Avis Google My Business, avis publics, Google reviews, notation',
                'category' => 'Avis',
                'permission' => 'subscribed',
            ],
            [
                'id' => md5('/reviews/private'),
                'title' => 'Mes feedbacks privés',
                'url' => '/reviews/private',
                'content' => 'Avis négatifs, feedbacks clients, retours privés, commentaires',
                'category' => 'Avis',
                'permission' => 'subscribed',
            ],
        ];
    }

    public function toSearchableArray()
    {
        // 4. C'est maintenant très simple, l'ID existe déjà
        return [
            'id' => $this->id,
            'title' => $this->title,
            'url' => $this->url,
            'content' => $this->content,
            'category' => $this->category,
            'permission' => $this->permission,
        ];
    }

    // 5. On peut supprimer getScoutKey() et getScoutKeyName()
    // car Laravel utilise maintenant l'ID standard du modèle par défaut.
}
