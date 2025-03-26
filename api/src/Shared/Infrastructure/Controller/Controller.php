<?php

namespace App\Shared\Infrastructure\Controller;

use JsonSerializable;
use Slim\Psr7\Response;
use Psr\Container\ContainerInterface;


abstract class Controller
{
    protected ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }


    protected function sendResponse(
        Response $response,
        int $status = 200,
        array|JsonSerializable $data = [],

    ): Response {
        if (!empty($data)) {
            $response->getBody()->write(json_encode($data));
        }

        return $response->withStatus($status);
    }
}
