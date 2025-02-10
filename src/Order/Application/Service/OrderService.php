<?php

namespace App\Order\Application\Service;

use App\Order\Application\Boundary\OrderServiceBoundary;

class OrderService implements OrderServiceBoundary
{
    public function createOrder(array $data): int
    {
        // TODO: Implement createOrder() method.
        return 0;
    }

    public function updateOrder(int $id, array $data): bool
    {
        // TODO: Implement updateOrder() method.
        return false;
    }

    public function deleteOrder(int $id): bool
    {
        // TODO: Implement deleteOrder() method.
        return false;
    }

    public function getOrders(): array
    {
        // TODO: Implement getOrders() method.
        return [];
    }

    public function getOrder(int $id): array
    {
        // TODO: Implement getOrder() method.
        return [];
    }

}
