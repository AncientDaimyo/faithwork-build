<?php

namespace App\Order\Controller;

use App\Auth\Interface\AuthServiceInterface;
use App\Order\Interface\OrderServiceInterface;
use App\Shared\Infrastructure\Controller\Controller;
use Psr\Container\ContainerInterface;
use App\Order\DTO\OrderDto;
use App\Order\DTO\OrderItemDto;
use App\Shared\Domain\Type\Decimal;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class OrderController extends Controller
{
    private OrderServiceInterface $orderService;
    private AuthServiceInterface $authService;

    public function __construct(
        ContainerInterface $container,
        OrderServiceInterface $orderService,
        AuthServiceInterface $authService
    ) {
        parent::__construct($container);
        $this->orderService = $orderService;
        $this->authService = $authService;
    }

    public function getOrders(Request $request, Response $response): Response
    {
        $user = $this->authService->auth($request);

        if (empty($user)) {
            return $response->withStatus(401);
        }

        $orders = $this->orderService->getOrders($user->id);
        if (empty($orders)) {
            return $response->withStatus(404);
        }
        $response->getBody()->write(json_encode($orders));
        return $response->withStatus(200);
    }

    public function getOrder(Request $request, Response $response, array $args): Response
    {
        $user = $this->authService->auth($request);

        if (empty($user)) {
            return $response->withStatus(401);
        }

        $orderId = $request->getParsedBody()['id'] ?? null;

        if (empty($orderId)) {
            return $response->withStatus(400);
        }

        $order = $this->orderService->getOrder($orderId, $user->id);

        if (empty($order)) {
            return $response->withStatus(404);
        }

        $response->getBody()->write(json_encode($order));

        return $response->withStatus(200);
    }

    public function createOrder(Request $request, Response $response): Response
    {
        $user = $this->authService->auth($request);

        if (empty($user)) {
            return $response->withStatus(401);
        }

        try {
            $dto = $this->buildDto($request->getParsedBody(), $user->id);
        } catch (\InvalidArgumentException $exception) {
            return $response->withStatus(400);
        }

        if ($this->orderService->createOrder($dto) === 0) {
            return $response->withStatus(400);
        }

        return $response->withStatus(200);
    }

    public function updateOrder(Request $request, Response $response, array $args): Response
    {
        $user = $this->authService->auth($request);

        if (empty($user)) {
            return $response->withStatus(401);
        }

        try {
            $dto = $this->buildDto($request->getParsedBody(), $user->id);
        } catch (\InvalidArgumentException $exception) {
            return $response->withStatus(400);
        }

        if ($this->orderService->updateOrder($dto) === 0) {
            return $response->withStatus(400);
        }

        return $response->withStatus(200);
    }

    public function deleteOrder(Request $request, Response $response, array $args): Response
    {
        $user = $this->authService->auth($request);

        if (empty($user)) {
            return $response->withStatus(401);
        }

        $orderId = $request->getParsedBody()['id'] ?? null;

        if (empty($orderId)) {
            return $response->withStatus(400);
        }

        $this->orderService->deleteOrder($orderId, $user->id);

        return $response->withStatus(200);
    }

    protected function buildDto(array $data, int $customerId): OrderDto
    {
        if (empty($data['items'])) {
            throw new \InvalidArgumentException('Items are required');
        }

        $items = [];
        foreach ($data['items'] as $item) {
            if (empty($item['productId']) || empty($item['quantity']) || empty($item['price']) || empty($item['sizeId'])) {
                throw new \InvalidArgumentException('Invalid order item');
            }
            $items[] = new OrderItemDto(
                $item['productId'],
                $item['quantity'],
                new Decimal((string)$item['price']),
                $item['sizeId'],
            );
        }

        if (empty($data['id'])) {
            return new OrderDto($customerId, $items, 0, null, null, null);
        }

        if (
            !empty($data['id'])
            && $data['id'] > 0
            && empty($data['orderStatus'])
            && empty($data['paymentStatus'])
            && empty($data['totalPrice'])
        ) {
            throw new \InvalidArgumentException('Order status, payment status and total price are required');
        }

        return new OrderDto(
            $customerId,
            $items,
            $data['id'],
            $data['orderStatus'],
            $data['paymentStatus'],
            new Decimal($data['totalPrice'])
        );
    }
}
