<?php

namespace App\Order\Domain\Entity;

use App\Shared\Domain\Entity\Entity;
use OrderStatusStorage;
use PaymentStatusStorage;

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
            'id' => $this->id,
            'customerId' => $this->customerId,
            'orderStatus' => $this->orderStatus,
            'paymentStatus' => $this->paymentStatus,
            'items' => $this->items,
        ];
    }
}
