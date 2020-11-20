<?php

return [
    'extra_routes' => [
        'routes' => [
            'middleware' => ['auth:api'],
            'namespace' => 'Controllers',
            'prefix' => null
        ],
        'routes_public' => [
            'middleware' => [],
            'namespace' => 'Controllers',
            'prefix' => null
        ],
    ],

    'extra_routes_namespaces' => [
        'Api' => base_path() . DIRECTORY_SEPARATOR . 'api',
        'Infrastructure' => base_path() . DIRECTORY_SEPARATOR . 'infrastructure'
    ],

    'slack_formatter' => '\Infrastructure\Formatters\SlackFormatter'
];
