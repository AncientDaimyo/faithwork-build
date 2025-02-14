<?php

namespace App\Order\Infrastructure\Controller;

use App\Shared\Infrastructure\Controller\Controller;
use App\Order\Application\Boundary\OrderServiceBoundary;
use Slim\Psr7\Response;
use Slim\Psr7\Request;
use Psr\Container\ContainerInterface;
use OpenApi\Attributes as OA;
use App\Auth\Application\Boundary\AuthServiceBoundary;

class OrderController extends Controller
{
    private OrderServiceBoundary $orderService;
    private AuthServiceBoundary $authService;

    public function __construct(
        ContainerInterface $container, 
        OrderServiceBoundary $orderServiceBoundary,
        AuthServiceBoundary $authServiceBoundary
    ){
        parent::__construct($container);
        $this->orderService = $orderServiceBoundary;
        $this->authService = $authServiceBoundary;
    }

    #[OA\Get(path: '/api/order/orders', tags: ['order'])]
    #[OA\Response(response: 200, description: 'Returns a list of orders')]
    #[OA\Response(response: 404, description: 'No orders found')]
    public function getOrders(Request $request, Response $response): Response
    {
        if (!$this->authService->checkRequest($request)) {
            return $response->withStatus(401);
        }

        $orders = $this->orderService->getOrders($request->getParsedBody()['customerId']);
        if (empty($orders)) {
            return $response->withStatus(404);
        }
        $response->getBody()->write(json_encode($orders));
        return $response->withStatus(200);
    }

    #[OA\Get(path: '/api/order/orders/{id}', tags: ['order'])]
    #[OA\Response(response: 200, description: 'Returns a order')]
    #[OA\Response(response: 404, description: 'No order found')]
    public function getOrder(Request $request, Response $response, array $args): Response
    {
        if (!$this->authService->checkRequest($request)) {
            return $response->withStatus(401);
        }
        
        $order = $this->orderService->getOrder($request->getParsedBody()['orderId']);
        if (empty($order)) {
            return $response->withStatus(404);
        }
        $response->getBody()->write(json_encode($order));
        return $response->withStatus(200);
    }

    #[OA\Post(path: '/api/order/orders', tags: ['order'])]
    #[OA\Response(response: 200, description: 'Creates a new order')]
    #[OA\Response(response: 400, description: 'Invalid data')]
    public function createOrder(Request $request, Response $response): Response
    {
        if (!$this->authService->checkRequest($request)) {
            return $response->withStatus(401);
        }

        $data = $request->getParsedBody();
        try {
            $this->orderService->createOrder($data);
        } catch (\InvalidArgumentException $exception) {
            return $response->withStatus(400);
        }
        return $response->withStatus(200);
    }

    #[OA\Put(path: '/api/order/orders', tags: ['order'])]
    #[OA\Response(response: 200, description: 'Updates an order')]
    #[OA\Response(response: 400, description: 'Invalid data')]
    public function updateOrder(Request $request, Response $response, array $args): Response
    {
        if (!$this->authService->checkRequest($request)) {
            return $response->withStatus(401);
        }

        $data = $request->getParsedBody();
        try {
            $this->orderService->updateOrder($data['id'], $data);
        } catch (\InvalidArgumentException $exception) {
            return $response->withStatus(400);
        }
        return $response->withStatus(200);
    }

    #[OA\Delete(path: '/api/order/orders', tags: ['order'])]
    #[OA\Response(response: 200, description: 'Deletes an order')]
    #[OA\Response(response: 400, description: 'Invalid data')]
    public function deleteOrder(Request $request, Response $response, array $args): Response
    {
        if (!$this->authService->checkRequest($request)) {
            return $response->withStatus(401);
        }

        $data = $request->getParsedBody();
        try {
            $this->orderService->deleteOrder($data['id']);
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
