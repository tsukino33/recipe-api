<?php

return [
    'paths' => ['api/*'],

    'allowed_methods' => ['*'],

    // Add your deployed frontend's origin here alongside the Vite dev server.
    'allowed_origins' => [
        'http://localhost:5173',
        'http://127.0.0.1:5173',
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,
];
