<?php

namespace App\Shared\Infrastructure\Controller;

use Psr\Container\ContainerInterface;


abstract class Controller
{
    protected ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
}
