<?php

namespace App\Order\Application\Service;

use App\Order\Application\Boundary\OrderServiceBoundary;
use App\Order\Domain\Builder\OrderBuilder;
use App\Order\Infrastructure\Repository\OrderRepository;

class OrderService implements OrderServiceBoundary
{
    protected OrderRepository $orderRepository;

    public function __construct(
        OrderRepository $orderRepository
    ) {
        $this->orderRepository = $orderRepository;
    }

    public function createOrder(array $data): int
    {
        try {
            $order = $this->createOrderBuilder()
                ->build($data);
            return $this->orderRepository->saveOrder($order);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function updateOrder(int $id, array $data): void
    {
        try {
            $order = $this->createOrderBuilder()
                ->build($data);
            $this->orderRepository->updateOrder($order);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function deleteOrder(int $id): void
    {
        try {
            $this->orderRepository->deleteOrder($id);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getOrders(int $customerId): array
    {
        $data = $this->orderRepository->getByCustomerId($customerId);

        if (empty($data)) {
            return [];
        }

        $orderObjects = [];

        foreach ($data as $orderData) {
            $orderObjects[] = $this->createOrderBuilder()
                ->build($orderData);
        }

        $orders = [];

        foreach ($orderObjects as $order) {
            $orders[] = $order->jsonSerialize();
        }

        return $orders;
    }

    public function getOrder(int $id): array
    {
        $data = $this->orderRepository->getById($id);

        if (empty($data)) {
            return [];
        }

        return $this->createOrderBuilder()
            ->build($data)
            ->jsonSerialize();
    }

    protected function validate(array $data): bool
    {
        // TODO: Implement validate() method.
        return false;
    }

    protected function createOrderBuilder(): OrderBuilder
    {
        return new OrderBuilder();
    }
}
