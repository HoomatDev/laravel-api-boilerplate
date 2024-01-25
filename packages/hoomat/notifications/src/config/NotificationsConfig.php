<?php

return [
    'prefix' => 'api/notifications',

    'middleware' => ['api', 'auth:sanctum'],

    'sms' => [
        'api_key' => env('SMS_API_KEY'),
        'from' => env('SMS_FROM'),
        'lookup_template' => ''
    ],

    'email' => [],

    'status' => [
        'pending'  => 1,
        'canceled' => 2,
        'sent'     => 3,
        'failed'   => 4
    ]
];
