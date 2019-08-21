<?php
return [
    'read' => [
        'dsn'      => 'mysql:dbname=' . env('DB_DATABASE') . ';host=' . env('DB_HOST_READ', env('DB_HOST')),
        'username' => env('DB_USERNAME'),
        'password' => env('DB_PASSWORD'),
    ],
    'write' => [
        'dsn'      => 'mysql:dbname=' . env('DB_DATABASE') . ';host=' . env('DB_HOST_WRITE', env('DB_HOST')),
        'username' => env('DB_USERNAME'),
        'password' => env('DB_PASSWORD'),
    ],
];