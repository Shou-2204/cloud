<?php

return [
    //    'starter' => [
//        'name' => 'Starter',
//        'description' => "L'essentiel pour maîtriser votre e-réputation.",
//        'price_monthly' => 29,
//        'price_yearly' => 290,
//        'stripe_id_monthly' => env('STRIPE_PRICE_ID_STARTER_MONTHLY'),
//        'stripe_id_yearly' => env('STRIPE_PRICE_ID_STARTER_YEARLY'),
//        'popular' => false,
//        'color' => 'gray', // ou 'indigo' etc pour le styling
//        'features' => [
//            [
//                'name' => 'Collecte de Feedback',
//                'description' => null,
//                'included' => true,
//            ],
//            [
//                'name' => 'Gestion des Avis Google',
//                'description' => null,
//                'included' => true,
//            ],
//            [
//                'name' => 'Roue de la Fortune (Capture Data)',
//                'description' => null,
//                'included' => true,
//            ],
//            [
//                'name' => 'Wallet Mobile',
//                'description' => null,
//                'included' => false,
//            ],
//            [
//                'name' => 'Campagnes SMS',
//                'description' => null,
//                'included' => false,
//            ],
//        ],
//    ],
    'smart' => [
        'name' => 'Offre Complète',
        'description' => 'Tout ce dont vous avez besoin pour exploser votre CA.',
        'price_monthly' => 49,
        'price_yearly' => 520,
        'stripe_id_monthly' => env('STRIPE_PRICE_ID_SMART_MONTHLY'),
        'stripe_id_yearly' => env('STRIPE_PRICE_ID_SMART_YEARLY'),
        'popular' => true,
        'color' => 'indigo',
        'features' => [
            [
                'name' => 'Avis Google Illimités',
                'description' => null,
                'included' => true,
            ],
            [
                'name' => 'Cartes de Fidélité Wallet (Apple/Google)',
                'description' => null,
                'included' => true,
            ],
            [
                'name' => 'CRM et Base Client',
                'description' => null,
                'included' => true,
            ],
            [
                'name' => 'Notifications Push & SMS',
                'description' => null,
                'included' => true,
            ],
            [
                'name' => 'Réponses Avis par IA (SEO)',
                'description' => null,
                'included' => true,
            ],
            [
                'name' => 'Support Prioritaire',
                'description' => null,
                'included' => true,
            ],
        ],
    ],
    //    'pro' => [
//        'name' => 'Pro',
//        'description' => 'Automatisez tout. Dominez votre marché.',
//        'price_monthly' => 149,
//        'price_yearly' => 1490,
//        'stripe_id_monthly' => env('STRIPE_PRICE_ID_PRO_MONTHLY'),
//        'stripe_id_yearly' => env('STRIPE_PRICE_ID_PRO_YEARLY'),
//        'popular' => false,
//        'color' => 'gray',
//        'features' => [
//            [
//                'name' => 'Tout de Smart',
//                'description' => 'Inclus toutes les fonctionnalités du plan Smart',
//                'included' => true,
//                'highlight' => true,
//            ],
//            [
//                'name' => 'Marketing SMS Automatisé',
//                'description' => null,
//                'included' => true,
//            ],
//            [
//                'name' => 'Réponses Avis Google via IA (SEO)',
//                'description' => null,
//                'included' => true,
//            ],
//            [
//                'name' => 'Dashboard Analytics Avancé',
//                'description' => null,
//                'included' => true,
//            ],
//            [
//                'name' => 'Manager de Compte Dédié',
//                'description' => null,
//                'included' => true,
//            ],
//        ],
//    ],
];
