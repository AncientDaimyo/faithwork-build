<?php

namespace App\Shared\Infrastructure\Controller;

use OpenApi\Attributes as OA;
use Slim\Psr7\Response;

class ServiceController extends Controller
{
    public function health()
    {
        $response = new Response();
        // $response->getBody()->write(json_encode(['status' => 'ok']));
        $response->getBody()->write(json_encode(['status' => getenv('APP_ENV')]));
        $response = $response->withStatus(200);
        $response = $response->withHeader('Content-Type', 'application/json');

        return $response;
    }
}
