<?php

namespace App\Order\Entity;

use App\Shared\Domain\Entity\Entity;
use App\Order\Storage\OrderStatusStorage;
use App\Order\Storage\PaymentStatusStorage;
use App\Order\DTO\OrderDto;
use App\Order\DTO\OrderItemDto;
use App\Shared\Domain\Type\Decimal;

class Order extends Entity
{
    protected ?int $id;
    protected ?int $customerId;
    protected ?int $orderStatus;
    protected ?int $paymentStatus;
    protected Decimal $totalPrice;

    protected array $items;

    public function __construct()
    {
        $this->items = [];
        $this->customerId = null;
        $this->orderStatus = OrderStatusStorage::STATUS_NEW;
        $this->paymentStatus = PaymentStatusStorage::UNPAID;
    }

    public static function fromDto(OrderDto $orderDto): Order
    {
        $order = new Order();
        $order->setCustomerId($orderDto->customerId);
        $order->setOrderStatus($orderDto->orderStatus);
        $order->setPaymentStatus($orderDto->paymentStatus);
        foreach ($orderDto->items as $item) {
            $order->setItemFromDto($item, $orderDto->id);
        }
        $order->setId($orderDto->id);
        $order->setTotalPrice($orderDto->totalPrice);
        return $order;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    protected function setItemFromDto(OrderItemDto $orderItem): void
    {
        $this->items[] = $orderItem;
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

    public function setTotalPrice(Decimal $totalPrice): void
    {
        $this->totalPrice = $totalPrice;
    }

    public function calculateTotal(): Decimal
    {
        $total = new Decimal('0.00');
        foreach ($this->items as $item) {
            $total = $total->add($item->calculateTotal());
        }
        return $total;
    }
}
