<?php

namespace App\Order\Application\Boundary;

interface OrderServiceBoundary
{
    public function createOrder(array $data): int;

    public function updateOrder(int $id, array $data): void;

    public function deleteOrder(int $id): void;

    public function getOrders(int $customerId): array;

    public function getOrder(int $id): array;
}
