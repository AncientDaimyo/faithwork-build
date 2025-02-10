<?php

namespace App\Order\Application\Boundary;

interface OrderServiceBoundary
{
    public function createOrder(array $data): int;

    public function updateOrder(int $id, array $data): bool;

    public function deleteOrder(int $id): bool;

    public function getOrders(): array;

    public function getOrder(int $id): array;
}
