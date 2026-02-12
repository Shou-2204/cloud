<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URL'),
        'places_api_key' => env('GOOGLE_PLACES_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
        'webhooks' => [
            'billing' => env('SLACK_WEBHOOK_BILLING', 'https://hooks.slack.com/services/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'),
            'users' => env('SLACK_WEBHOOK_USERS', 'https://hooks.slack.com/services/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'),
            'leads' => env('SLACK_WEBHOOK_LEADS', 'https://hooks.slack.com/services/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'),
            'bugs' => env('SLACK_WEBHOOK_BUGS', 'https://hooks.slack.com/services/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'),
        ],
    ],

    'stripe' => [
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
        // Structure hiérarchique : Plan -> Périodicité
        'plans' => [
            //            'starter' => [
//                'monthly' => env('STRIPE_PRICE_ID_STARTER_MONTHLY'),
//                'yearly' => env('STRIPE_PRICE_ID_STARTER_YEARLY'),
//            ],
            'smart' => [
                'monthly' => env('STRIPE_PRICE_ID_SMART_MONTHLY'),
                'yearly' => env('STRIPE_PRICE_ID_SMART_YEARLY'),
            ],
            //            'pro' => [
//                'monthly' => env('STRIPE_PRICE_ID_PRO_MONTHLY'),
//                'yearly' => env('STRIPE_PRICE_ID_PRO_YEARLY'),
//            ],
        ],
    ],

    'google_analytics' => [
        'id' => env('GOOGLE_ANALYTICS_ID'),
    ],


    'shlink' => [
        'url' => env('SHLINK_SERVER_URL'),
        'api_key' => env('SHLINK_API_KEY'),
    ],

];
