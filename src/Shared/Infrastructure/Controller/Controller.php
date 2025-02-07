<?php

namespace App\Shared\Infrastructure\Controller;

use Psr\Container\ContainerInterface;
use OpenApi\Attributes as OA;

#[OA\Info(title: 'Faithwork API', version: '1.0')]
abstract class Controller
{
    protected ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
}
