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
    public function __construct()
    {
        $this->id = null;
        $this->orderId = null;
        $this->productId = null;
        $this->quantity = 1;
        $this->price = null;
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
