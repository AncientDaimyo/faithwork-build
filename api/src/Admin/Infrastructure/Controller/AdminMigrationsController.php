<?php

namespace App\Admin\Infrastructure\Controller;

use App\Shared\Infrastructure\Controller\Controller;
use App\Shared\Utility\Migrations\Api\MigrationExecutor;
use Slim\Psr7\Response;

class AdminMigrationsController extends Controller
{
    public function up()
    {
        $this->container->get(MigrationExecutor::class)->up();
        $response = new Response();
        return $response->withStatus(302)->withHeader('Location', '/api/doc');
    }

    public function down()
    {
        $this->container->get(MigrationExecutor::class)->down();
        $response = new Response();
        return $response->withStatus(302)->withHeader('Location', '/api/doc');
    }
}
