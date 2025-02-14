<?php

namespace App\Shared\Infrastructure\Controller;

use App\Shared\Utility\Migrations\Api\MigrationExecutor;
use OpenApi\Attributes as OA;
use Slim\Psr7\Response;


// TODO remove this controller after development admin panel
class AdminController extends Controller
{
    #[OA\Get(path: '/api/admin/migrations/up', tags: ['admin'])]
    #[OA\Response(response: 200, description: 'Migrations up')]
    public function upMigrations(): void
    {
        $this->container->get(MigrationExecutor::class)->up();
    }

    #[OA\Get(path: '/api/admin/migrations/down', tags: ['admin'])]
    #[OA\Response(response: 200, description: 'Migrations down')]
    public function downMigrations(): void
    {
        $this->container->get(MigrationExecutor::class)->down();
    }
}
