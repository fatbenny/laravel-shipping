<?php

return [
    'default' => env('SHIPPING_DEFAULT_DRIVER', 'ups'),

    'ups' => [
        'client_id' => env('UPS_CLIENT_ID'),
        'client_secret' => env('UPS_CLIENT_SECRET'),
        'base_uri' => env('UPS_BASE_URI', 'https://onlinetools.ups.com/rest/'),
        'account_number' => env('UPS_ACCOUNT_NUMBER'),
    ],

    'fedex' => [
        'base_uri' => env('FEDEX_BASE_URI', 'https://apis-sandbox.fedex.com/'),
        'account_number' => env('FEDEX_ACCOUNT_NUMBER'),
        'client_id' => env('FEDEX_CLIENT_ID'),
        'client_secret' => env('FEDEX_CLIENT_SECRET'),
    ],
];