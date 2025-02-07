<?php

namespace App\Product\Infrastructure\Controller;

use App\Product\Application\Boundary\ProductServiceBoundary;
use App\Shared\Infrastructure\Controller\Controller;
use Psr\Container\ContainerInterface;
use Slim\Psr7\Response;
use OpenApi\Attributes as OA;
use Slim\Psr7\Request;

class ProductController extends Controller
{
    protected ProductServiceBoundary $productServiceBoundary;

    public function __construct(ContainerInterface $container, ProductServiceBoundary $productServiceBoundary)
    {
        parent::__construct($container);
        $this->productServiceBoundary = $productServiceBoundary;
    }

    #[OA\Get(path: '/api/product/products')]
    #[OA\Response(response: 200, description: 'Returns a list of products')]
    public function getProducts()
    {
        $products = $this->productServiceBoundary->getProducts();
        $response = new Response();
        $response->getBody()->write(json_encode($products));

        return $response;
    }

    #[OA\Get(path: '/api/product/products/{id}')]
    #[OA\Response(response: 200, description: 'Returns a product')]
    public function getProduct(Request $request)
    {
        $id = $request->getAttribute('id');
        $product = $this->productServiceBoundary->getProduct($id);
        if (empty($product)) {
            return (new Response())->withStatus(404);
        }
        $response = new Response();
        $response->getBody()->write(json_encode($product));

        return $response;
    }
}
