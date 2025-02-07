<?php

namespace App\Shared\Infrastructure\Controller;

use App\Shared\Utility\Migrations\Api\MigrationExecutor;


// TODO remove this controller after development admin panel
class AdminController extends Controller
{
    public function upMigrations(): void
    {
        $this->container->get(MigrationExecutor::class)->up();
    }

    public function downMigrations(): void
    {
        $this->container->get(MigrationExecutor::class)->down();
    }
}
