<?php

namespace App\Order\Infrastructure\Controller;

use App\Shared\Infrastructure\Controller\Controller;
use App\Order\Application\Boundary\OrderServiceBoundary;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;

class OrderController extends Controller
{
    private OrderServiceBoundary $orderServiceBoundary;

    public function __construct(ContainerInterface $container, OrderServiceBoundary $orderServiceBoundary)
    {
        parent::__construct($container);
        $this->orderServiceBoundary = $orderServiceBoundary;
    }

    public function getOrders(Request $request, Response $response): Response
    {
        $orders = $this->orderServiceBoundary->getOrders();
        if (empty($orders)) {
            return $response->withStatus(404);
        }
        $response->getBody()->write(json_encode($orders));
        return $response->withStatus(200);
    }

    public function getOrder(Request $request, Response $response, array $args): Response
    {
        $order = $this->orderServiceBoundary->getOrder($args['id']);
        if (empty($order)) {
            return $response->withStatus(404);
        }
        $response->getBody()->write(json_encode($order));
        return $response->withStatus(200);
    }

    public function createOrder(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        try {
            $this->orderServiceBoundary->createOrder($data);
        } catch (\InvalidArgumentException $exception) {
            return $response->withStatus(400);
        }
        return $response->withStatus(200);
    }

    public function updateOrder(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        try {
            $this->orderServiceBoundary->updateOrder($args['id'], $data);
        } catch (\InvalidArgumentException $exception) {
            return $response->withStatus(400);
        }
        return $response->withStatus(200);
    }

    public function deleteOrder(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        try {
            $this->orderServiceBoundary->deleteOrder($data['id']);
        } catch (\InvalidArgumentException $exception) {
            return $response->withStatus(400);
        }
        return $response->withStatus(200);
    }

    protected function validateResponseData(array $data): void
    {
        // TODO: Implement validateResponseData() method.
    }
}
