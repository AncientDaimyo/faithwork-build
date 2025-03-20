<?php

use App\Shared\Utility\Migrations\Api\MigrationExecutor;

return function ($container) {
    if ($container->get('settings')['automigration_off']) {
        return;
    }
    $container->get(MigrationExecutor::class)->up();
};
