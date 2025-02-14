<?php

namespace App\Shared\Infrastructure\Controller;

use OpenApi\Attributes as OA;
use Slim\Psr7\Response;

class ServiceController extends Controller
{
    #[OA\Get(path: '/api/health', tags: ['service'])]
    #[OA\Response(response: 200, description: 'Health check')]
    public function health()
    {
        $response = new Response();
        $response->getBody()->write(json_encode(['status' => 'ok']));
        $response = $response->withStatus(200);
        $response = $response->withHeader('Content-Type', 'application/json');

        return $response;
    }
}
