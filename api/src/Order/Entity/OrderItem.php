<?php

namespace App\Order\Entity;

use App\Shared\Domain\Entity\Entity;
use App\Shared\Domain\Type\Decimal;
use App\Order\DTO\OrderItemDto;

class OrderItem extends Entity
{
    protected ?int $id;
    protected ?int $orderId;
    protected ?int $productId;
    protected ?int $quantity;
    protected ?Decimal $price;
    public function __construct(?int $productId, ?int $quantity, ?Decimal $price, ?int $id, ?int $orderId)
    {
        $this->id = $id;
        $this->orderId = $orderId;
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->price = $price;
    }

    public static function fromDto(OrderItemDto $orderItemDto, int $orderId): OrderItem
    {
        return new OrderItem(
            $orderItemDto->productId,
            $orderItemDto->quantity,
            $orderItemDto->price,
            $orderItemDto->id,
            $orderId
        );
    }

    public function calculateTotal(): Decimal
    {
        return $this->price->mul(new Decimal($this->quantity));
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'orderId' => $this->orderId,
            'productId' => $this->productId,
            'quantity' => $this->quantity,
            'price' => $this->price
        ];
    }
}
