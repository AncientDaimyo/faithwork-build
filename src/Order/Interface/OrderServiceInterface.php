<?php

namespace App\Order\Interface;

use App\Order\DTO\OrderDto;

interface OrderServiceInterface
{
    public function createOrder(OrderDto $order): int;

    public function updateOrder(OrderDto $order): int;

    public function deleteOrder(int $id, int $customerId): void;

    public function getOrders(int $customerId): array;

    public function getOrder(int $id, int $customerId): ?OrderDto;
}
