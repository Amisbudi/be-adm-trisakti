<?php

return [

    /*
     * A cors profile determines which origins, methods, headers are allowed for
     * a given requests. The `DefaultProfile` reads its configuration from this
     * config file.
     *
     * You can easily create your own cors profile.
     * More info: https://github.com/spatie/laravel-cors/#creating-your-own-cors-profile
     */
    'cors_profile' => Spatie\Cors\CorsProfile\DefaultProfile::class,

    /*
     * This configuration is used by `DefaultProfile`.
     */
    'default_profile' => [

        'allow_credentials' => false,

        'allow_origins' => [
            'https://dev-gateway.telkomuniversity.ac.id',
            'https://gateway.telkomuniversity.ac.id',
            'https://be-trisakti.amisbudi.cloud',
            'https://fe-trisakti.amisbudi.cloud',
            'http://localhost:4200', 
            'https://apibeta.bni-ecollection.com',
            'https://api.bni-ecollection.com',
            'https://admission.amisbudi.cloud'
        ],

        'allow_methods' => [
            'POST',
            'GET',
            // 'OPTIONS',
            'PUT',
            // 'PATCH',
            'DELETE',
        ],

        'allow_headers' => [
            // 'Content-Type',
            // 'X-Auth-Token',
            // 'Origin',
            'Authorization',
        ],

        'expose_headers' => [
            // 'Cache-Control',
            // 'Content-Language',
            // 'Content-Type',
            // 'Expires',
            // 'Last-Modified',
            // 'Pragma',
        ],

        'forbidden_response' => [
            'message' => 'Not Allowed',
            'status' => 403,
        ],

        /*
         * Preflight request will respond with value for the max age header.
         */
        'max_age' => 60 * 5 * 1,
    ],
];
