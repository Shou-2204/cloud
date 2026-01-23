<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default SMS Driver
    |--------------------------------------------------------------------------
    |
    | This option controls the default SMS driver that will be used to send
    | SMS messages to your users. You may set this to any of the connections
    | defined in the "drivers" array below.
    |
    | Supported: "log", "twilio", "ovh"
    |
    */

    'default' => env('SMS_DRIVER', 'log'),

    /*
    |--------------------------------------------------------------------------
    | SMS Drivers
    |--------------------------------------------------------------------------
    |
    | Here you may configure the settings for each SMS driver that is used
    | by your application. You are free to add more drivers as needed.
    |
    */

    'drivers' => [

        'log' => [
            'driver' => 'log',
        ],

        'twilio' => [
            'driver' => 'twilio',
            'sid' => env('TWILIO_SID'),
            'token' => env('TWILIO_TOKEN'),
            'from' => env('TWILIO_FROM'),
        ],

        'ovh' => [
            'driver' => 'ovh',
            'app_key' => env('OVH_APP_KEY'),
            'app_secret' => env('OVH_APP_SECRET'),
            'consumer_key' => env('OVH_CONSUMER_KEY'),
            'endpoint' => env('OVH_ENDPOINT', 'https://eu.api.ovh.com/1.0'),
            'service_name' => env('OVH_SERVICE_NAME'),
        ],

    ],

];
