<?php

namespace App\Product\Infrastructure\Controller;

use App\Product\Application\Boundary\ProductServiceBoundary;
use App\Shared\Infrastructure\Controller\Controller;
use Psr\Container\ContainerInterface;
use Slim\Psr7\Response;
use Slim\Psr7\Request;

class ProductController extends Controller
{
    protected ProductServiceBoundary $productServiceBoundary;

    public function __construct(ContainerInterface $container, ProductServiceBoundary $productServiceBoundary)
    {
        parent::__construct($container);
        $this->productServiceBoundary = $productServiceBoundary;
    }

    public function getProducts()
    {
        $products = $this->productServiceBoundary->getProducts();
        $response = new Response();
        $response->getBody()->write(json_encode($products));

        return $response;
    }

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
