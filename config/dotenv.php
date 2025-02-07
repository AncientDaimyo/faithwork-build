<?php

use Dotenv\Dotenv;

return function () {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->safeLoad();
    $dotenv->required(
        [
            'DB_HOST',
            'DB_NAME',
            'DB_USER',
            'DB_PASSWORD',
            'DB_PORT',
            'DB_DRIVER'
        ]
    );
};
