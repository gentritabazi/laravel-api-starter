<?php

return [
    'namespaces' => [
        'Api' => base_path() . DIRECTORY_SEPARATOR . 'api',
        'Infrastructure' => base_path() . DIRECTORY_SEPARATOR . 'infrastructure'
    ],

    'protection_middleware' => [
        'auth:api'
    ],

    'slack_formatter' => '\Infrastructure\Formatters\SlackFormatter'
];
