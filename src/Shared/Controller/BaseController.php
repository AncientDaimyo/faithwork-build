<?php

namespace App\Shared\Controller;

use App\Shared\Repository\RepositoryInterface as Repository;
use App\Shared\Repository\RepositoryInterface;
use DI\Container;
use Psr\Container\ContainerInterface;
use OpenApi\Attributes as OA;

#[OA\Info(title: 'Faithwork API', version: '1.0')]
class BaseController
{
    /** @var ContainerInterface */
    protected $container;

    /** @var Repository */
    protected $repository;

    public function __construct(ContainerInterface $container, RepositoryInterface $repository)
    {
        $this->container = $container;
        $this->repository = $repository;
    }
}
