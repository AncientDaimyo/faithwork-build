<?php

use App\Shared\Utility\Migrations\Api\MigrationExecutor;

return function ($container) {
    $migrationExecutor = new MigrationExecutor(
        $container->get('adapter'),
        $container->get('migrations_path'),
        $container
    );

    $migrationExecutor->up();
};
