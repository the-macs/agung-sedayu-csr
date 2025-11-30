<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Custom config for SSO Authentication
    |--------------------------------------------------------------------------
    |
    */

    'auth_sso_endpoint' => env('AUTH_SSO_ENDPOINT', 'http://localhost:3000'),
    'auth_sso_client_id' => env('AUTH_SSO_CLIENT_ID', ''),
    'auth_sso_client_secret' => env('AUTH_SSO_CLIENT_SECRET', ''),
    'auth_sso_client_id' => env('AUTH_SSO_CLIENT_ID', ''),

    /*
    |--------------------------------------------------------------------------
    | Custom config for SSO Authentication
    |--------------------------------------------------------------------------
    |
    */
    'staffing_endpoint' => env('STAFFING_ENDPOINT', 'http://localhost:3001')
];
