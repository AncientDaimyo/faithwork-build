<?php

namespace App\Order\Domain\Entity;

use App\Shared\Domain\Entity\Entity;

class OrderItem extends Entity
{
    protected ?int $id;
    protected ?int $orderId;
    protected ?int $productId;
    protected int $quantity;
    protected $price;
    public function __construct(int $productId, int $quantity, $price, ?int $id, ?int $orderId)
    {
        $this->id = $id;
        $this->orderId = $orderId;
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->price = $price;
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
