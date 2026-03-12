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

    'apple' => [
        'client_id' => trim(env('APPLE_CLIENT_ID', '')),
        'client_secret' => env('APPLE_CLIENT_SECRET'),
        'team_id' => trim(env('APPLE_TEAM_ID', '')),
        'key_id' => trim(env('APPLE_KEY_ID', '')),
        'private_key' => env('APPLE_PRIVATE_KEY') ? file_get_contents(trim(env('APPLE_PRIVATE_KEY'))) : '',
        'redirect' => trim(env('APPLE_REDIRECT_URL', '')),
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
            'default' => env('SLACK_WEBHOOK_URL'),
            'bugs' => env('SLACK_WEBHOOK_URL_BUGS'),
            'leads' => env('SLACK_WEBHOOK_URL_LEADS'),
            'users' => env('SLACK_WEBHOOK_URL_USERS'),
            'subscriptions' => env('SLACK_WEBHOOK_URL_SUBSCRIPTIONS'),
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

    'social' => [
        'youtube' => env('YOUTUBE_URL'),
        'whatsapp' => env('WHATSAPP_URL'),
        'linkedin' => env('LINKEDIN_URL'),
    ],

    'apple_wallet' => [
        'cert_path' => env('APPLE_WALLET_CERT_PATH', 'storage/app/appleCertWallet.p12'),
        'cert_password' => env('APPLE_WALLET_CERT_PASSWORD', ''),
        'pass_type_identifier' => env('APPLE_WALLET_PASS_TYPE_IDENTIFIER', 'pass.cloud.shouphotobooth.web'),
        'team_identifier' => env('APPLE_WALLET_TEAM_IDENTIFIER', '5NZKKW832Q'),
        'push_cert_path' => env('APPLE_WALLET_PUSH_CERT_PATH', 'storage/app/appleCertWallet.pem'),
        'push_key_path' => env('APPLE_WALLET_PUSH_KEY_PATH', 'storage/app/appleCertWallet.key'),
    ],

];
