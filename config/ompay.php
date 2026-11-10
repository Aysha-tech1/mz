<?php

return [

    /*
    | Bank-hosted checkout: the card never touches this server.
    | Keys stay in .env only. Sandbox and live credentials are different.
    */
    'base_url' => env(
        'OMPAY_BASE_URL',
        env('APP_ENV') === 'production'
            ? 'https://api.truepay.ompay.om'
            : 'https://api.sandbox.truepay.ompay.om'
    ),

    'key' => env('OMPAY_API_KEY'),

    'secret' => env('OMPAY_API_SECRET'),

    'currency' => env('OMPAY_CURRENCY', 'OMR'),

    'timeout' => 30,

    // Local only. Never enable on the live site.
    'test_mode' => env('APP_ENV') === 'local' && (bool) env('OMPAY_TEST_MODE', false),

];
