<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application for file storage.
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Below you may configure as many filesystem disks as necessary, and you
    | may even configure multiple disks for the same driver. Examples for
    | most supported storage drivers are configured here for reference.
    |
    | Supported drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app/private'),
            'serve' => true,
            'throw' => false,
            'report' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
            'report' => false,
        ],

        'minio_public' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => 'shoucloud-public', // Nom du bucket en dur ou via env('AWS_BUCKET_PUBLIC')
            'url' => env('AWS_URL_PUBLIC', 'http://127.0.0.1:9000/shoucloud-public'), // URL spécifique
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => true,
            'visibility' => 'public', // Force la visibilité publique par défaut
            'throw' => false,
            'http' => [
                'verify' => false, // Désactive la vérif SSL pour le local
                'curl' => [
                    CURLOPT_SSL_VERIFYHOST => 0, // Désactive la vérif du nom de domaine
                    CURLOPT_SSL_VERIFYPEER => 0, // Désactive la vérif de l'émetteur
                ],
             ],
        ],

        // 2. Disque Privé (Documents Teams, Factures, Backups)
        // Accessible uniquement via URL signées ou backend.
        'minio_private' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => 'shoucloud-private', // Nom du bucket privé
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => true,
            'visibility' => 'private', // Force la visibilité privée
            'throw' => false,
            'http' => [
                'verify' => false, // Désactive la vérif SSL pour le local
                'curl' => [
                    CURLOPT_SSL_VERIFYHOST => 0, // Désactive la vérif du nom de domaine
                    CURLOPT_SSL_VERIFYPEER => 0, // Désactive la vérif de l'émetteur
                ],
            ],
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
            'report' => false,
            'http' => [              // J'ai aligné ça correctement
                'verify' => false,
                'curl' => [
                    CURLOPT_SSL_VERIFYHOST => 0, // Désactive la vérif du nom de domaine
                    CURLOPT_SSL_VERIFYPEER => 0, // Désactive la vérif de l'émetteur
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
