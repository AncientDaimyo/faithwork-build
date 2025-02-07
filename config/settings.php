<?php

return [
    'database' => [
        'dbname' => $_ENV['DB_NAME'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
        'host' => $_ENV['DB_HOST'],
        'driver' => $_ENV['DB_DRIVER'],
        'port' => $_ENV['DB_PORT']
    ],
    
    'error' => [
        'display_error_details' => true,
        'log_errors' => true,
        'log_error_details' => true
    ],

    'automigration_off' => true
];
