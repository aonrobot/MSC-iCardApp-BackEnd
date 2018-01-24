<?php

return [
    'default' => 'MSCMain',
    'connections' => [
        'MSCMain' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST'),
            'database' => env('DB_DATABASE'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ],
        'iCard' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST'),
            'database' => env('ICARD_DB_DATABASE'),
            'username' => env('ICARD_DB_USERNAME'),
            'password' => env('ICARD_DB_PASSWORD'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ],
    ]
];