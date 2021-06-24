<?php

return [

    'modules_folder' => 'api',

    'extra_routes' => [
        'routes' => [
            'middleware' => [],
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

    'exceptions_formatters' => [
        Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException::class => one2tek\larapi\ExceptionsFormatters\UnprocessableEntityHttpExceptionFormatter::class,
        Throwable::class => one2tek\larapi\ExceptionsFormatters\ExceptionFormatter::class
    ]
    
];
