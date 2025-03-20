<?php

namespace App\Order\DTO;

use App\Order\Storage\OrderStatusStorage;
use App\Order\Storage\PaymentStatusStorage;
use App\Shared\Domain\Type\Decimal;

class OrderDto implements \JsonSerializable
{
    public int $id;
    public int $customerId;
    public int $orderStatus;
    public int $paymentStatus;
    public Decimal $totalPrice;
    public array $items;

    public function __construct(
        int $customerId,
        array $items,
        int $id = 0,
        ?int $orderStatus,
        ?int $paymentStatus,
        ?Decimal $totalPrice
    ) {
        $this->customerId = $customerId;
        foreach ($items as $item) {
            if (!($item instanceof OrderItemDto)) {
                throw new \InvalidArgumentException('Invalid order item');
            }
        }
        $this->items = $items;

        if ($id === 0) {
            $this->id = 0;
            $this->orderStatus = OrderStatusStorage::STATUS_NEW;
            $this->paymentStatus = PaymentStatusStorage::UNPAID;
            $this->totalPrice = $this->calculateTotal();
        } else {
            $this->id = $id;
            $this->orderStatus = $orderStatus;
            $this->paymentStatus = $paymentStatus;
            $this->totalPrice = $totalPrice;
        }
    }

    protected function calculateTotal(): Decimal
    {
        $total = new Decimal(0.00);
        foreach ($this->items as $orderItem) {
            $total = $total->add($orderItem->calculateTotal());
        }
        return $total;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'customerId' => $this->customerId,
            'status' => $this->orderStatus,
            'paymentStatus' => $this->paymentStatus,
            'totalPrice' => $this->totalPrice,
            'items' => json_encode($this->items),
        ];
    }
}
