<?php

namespace App\Product\Controller;

use App\Product\Domain\Product;
use App\Product\Repository\ProductRepository;
use App\Shared\Controller\BaseController;
use App\Shared\Repository\RepositoryInterface;
use Psr\Container\ContainerInterface;
use Slim\Psr7\Response;
use OpenApi\Attributes as OA;

class ProductController extends BaseController
{
    public function __construct(ContainerInterface $container, RepositoryInterface $repository)
    {
        parent::__construct($container, $repository);
        $this->repository = $container->get(ProductRepository::class);
    }

    #[OA\Get(path: '/api/product/products')]
    #[OA\Response(response: 200, description: 'Returns a list of products')]
    public function getProducts()
    {
        $products = $this->repository->findAll();
        $response = new Response();
        $response->getBody()->write(json_encode($products));

        return $response;
    }

    #[OA\Get(path: '/api/product/products/{id}')]
    #[OA\Response(response: 200, description: 'Returns a product')]
    public function getProduct($id)
    {
        $product = $this->repository->find($id);
        $response = new Response();
        $response->getBody()->write(json_encode($product));

        return $response;
    }
}
