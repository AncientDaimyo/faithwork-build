<?php

namespace App\Order\Domain\Entity;

use App\Shared\Domain\Entity\Entity;
use App\Order\Domain\Storage\OrderStatusStorage;
use App\Order\Domain\Storage\PaymentStatusStorage;

class Order extends Entity
{
    protected ?int $id;
    protected ?int $customerId;
    protected ?int $orderStatus;
    protected ?int $paymentStatus;
    
    protected array $items;

    public function __construct()
    {
        $this->items = [];
        $this->customerId = null;
        $this->orderStatus = OrderStatusStorage::STATUS_NEW;
        $this->paymentStatus = PaymentStatusStorage::UNPAID;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    public function setCustomerId(?int $customerId): void
    {
        $this->customerId = $customerId;
    }

    public function setOrderStatus(?int $orderStatus): void
    {
        $this->orderStatus = $orderStatus;
    }

    public function setPaymentStatus(?int $paymentStatus): void
    {
        $this->paymentStatus = $paymentStatus;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id ?? null,
            'customerId' => $this->customerId,
            'orderStatus' => $this->orderStatus,
            'paymentStatus' => $this->paymentStatus,
            'items' => $this->serializeItems(),
            'total' => $this->calculateTotal(),
        ];
    }

    protected function serializeItems(): array
    {
        $items = [];
        foreach ($this->items as $item) {
            $items[] = $item->jsonSerialize();
        }
        return $items;
    }

    public function calculateTotal(): float
    {
        $total = 0.0;
        foreach ($this->items as $item) {
            $total += $item->price * $item->quantity;
        }
        return $total;
    }
}
