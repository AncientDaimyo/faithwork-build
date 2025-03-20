<?php

namespace App\Order\Service;

use App\Order\Entity\Order;
use App\Order\DTO\OrderDto;
use App\Order\DTO\OrderItemDto;
use App\Order\Repository\OrderRepository;
use App\Order\Interface\OrderServiceInterface;

class OrderService implements OrderServiceInterface
{
    protected OrderRepository $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function createOrder(OrderDto $dto): int
    {
        $id = $this->orderRepository->saveOrder(Order::fromDto($dto));
        if ($id <= 0) {
            return 0;
        }
        return $id;
    }

    public function updateOrder(OrderDto $dto): int
    {
        $id = $this->orderRepository->updateOrder(Order::fromDto($dto));
        if ($id > 0) {
            return $id;
        }
        return 0;
    }

    public function deleteOrder(int $id, int $customerId): void
    {
        $this->orderRepository->deleteOrder($id);
    }

    public function getOrders(int $customerId): array
    {
        $data = $this->orderRepository->getByCustomerId($customerId);
        $orders = [];
        foreach ($data as $order) {
            $orders[] = $this->buildOrderDto($order);
        }
        return $orders;
    }

    public function getOrder(int $id, int $customerId): ?OrderDto
    {
        $data = $this->orderRepository->getByIdForCustomer($id, $customerId);
        if (empty($data)) {
            return null;
        }
        return $this->buildOrderDto($data);
    }

    protected function buildOrderDto(array $orderData): OrderDto
    {
        $items = [];
        foreach ($orderData['items'] as $item) {
            $items[] = new OrderItemDto($item['product_id'], $item['quantity'], $item['price'], $item['size_id']);
        }
        return new OrderDto(
            $orderData['customer_id'],
            $items,
            $orderData['id'],
            $orderData['order_status'],
            $orderData['payment_status'],
            $orderData['total']
        );
    }
}
