<?php

namespace App\Order\Domain\Builder;

use App\Order\Domain\Entity\Order;
use App\Order\Domain\Entity\OrderItem;

class OrderBuilder
{
    protected Order $order;

    public function __construct()
    {
        $this->order = new Order();
    }

    public function build(array $data): Order
    {
        if (!$this->validate($data)) {
            throw new \InvalidArgumentException('Invalid build data');
        }

        if (!empty($data['id'])) {
            $this->order->setId($data['id']);
        }

        $this->order->setItems($this->prepareItems($data['items']));
        $this->order->setCustomerId($data['customerId'] ?? $data['customer_id']);

        if (!empty($data['orderStatus'])) {
            $this->order->setOrderStatus($data['orderStatus']);
        }
        if (!empty($data['paymentStatus'])) {
            $this->order->setPaymentStatus($data['paymentStatus']);
        }

        return $this->order;
    }

    protected function validate(array $data): bool
    {
        // TODO: Implement validate() method.
        return true;
    }

    protected function prepareItems(array $items): array
    {
        $preparedItems = [];
        foreach ($items as $item) {
            $preparedItems[] = new OrderItem(
                $item['productId'] ?? $item['product_id'],
                $item['quantity'],
                $item['price'],
                $item['id'] ?? null,
                $item['orderId'] ?? $item['order_id'] ?? null
            );
        }
        return $preparedItems;
    }
}
