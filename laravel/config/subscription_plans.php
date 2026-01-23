<?php

return [
    'starter' => [
        'name' => 'Starter',
        'description' => "L'essentiel pour maîtriser votre e-réputation.",
        'price_monthly' => 29,
        'price_yearly' => 290,
        'stripe_id_monthly' => env('STRIPE_PRICE_ID_STARTER_MONTHLY'),
        'stripe_id_yearly' => env('STRIPE_PRICE_ID_STARTER_YEARLY'),
        'popular' => false,
        'color' => 'gray', // ou 'indigo' etc pour le styling
        'features' => [
            [
                'name' => 'Collecte de Feedback',
                'description' => null,
                'included' => true,
            ],
            [
                'name' => 'Gestion des Avis Google',
                'description' => null,
                'included' => true,
            ],
            [
                'name' => 'Roue de la Fortune (Capture Data)',
                'description' => null,
                'included' => true,
            ],
            [
                'name' => 'Wallet Mobile',
                'description' => null,
                'included' => false,
            ],
            [
                'name' => 'Campagnes SMS',
                'description' => null,
                'included' => false,
            ],
        ],
    ],
    'smart' => [
        'name' => 'Smart',
        'description' => 'Fidélisez votre clientèle avec le Wallet Mobile.',
        'price_monthly' => 79,
        'price_yearly' => 790,
        'stripe_id_monthly' => env('STRIPE_PRICE_ID_SMART_MONTHLY'),
        'stripe_id_yearly' => env('STRIPE_PRICE_ID_SMART_YEARLY'),
        'popular' => true,
        'color' => 'indigo',
        'features' => [
            [
                'name' => 'Tout de Starter',
                'description' => 'Inclus toutes les fonctionnalités du plan Starter',
                'included' => true,
                'highlight' => true, // Pour afficher en gras ou différemment
            ],
            [
                'name' => 'Cartes de Fidélité Wallet (Apple/Google)',
                'description' => null,
                'included' => true,
            ],
            [
                'name' => 'CRM Clé en main',
                'description' => null,
                'included' => true,
            ],
            [
                'name' => 'Notifications Push illimitées',
                'description' => null,
                'included' => true,
            ],
            [
                'name' => 'Automatisation IA',
                'description' => null,
                'included' => false,
            ],
        ],
    ],
    'pro' => [
        'name' => 'Pro',
        'description' => 'Automatisez tout. Dominez votre marché.',
        'price_monthly' => 149,
        'price_yearly' => 1490,
        'stripe_id_monthly' => env('STRIPE_PRICE_ID_PRO_MONTHLY'),
        'stripe_id_yearly' => env('STRIPE_PRICE_ID_PRO_YEARLY'),
        'popular' => false,
        'color' => 'gray',
        'features' => [
            [
                'name' => 'Tout de Smart',
                'description' => 'Inclus toutes les fonctionnalités du plan Smart',
                'included' => true,
                'highlight' => true,
            ],
            [
                'name' => 'Marketing SMS Automatisé',
                'description' => null,
                'included' => true,
            ],
            [
                'name' => 'Réponses Avis Google via IA (SEO)',
                'description' => null,
                'included' => true,
            ],
            [
                'name' => 'Dashboard Analytics Avancé',
                'description' => null,
                'included' => true,
            ],
            [
                'name' => 'Manager de Compte Dédié',
                'description' => null,
                'included' => true,
            ],
        ],
    ],
];
