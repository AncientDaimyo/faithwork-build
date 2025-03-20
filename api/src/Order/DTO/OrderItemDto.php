<?php

namespace App\Order\DTO;

use App\Shared\Domain\Type\Decimal;

class OrderItemDto implements \JsonSerializable
{
    public int $id;
    public int $productId;
    public int $quantity;
    public Decimal $price;
    public int $sizeId;

    public function __construct(
        int $productId,
        int $quantity,
        Decimal $price,
        int $sizeId,
        int $id = 0
    ) {
        $this->id = $id;
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->sizeId = $sizeId;
    }

    public function calculateTotal(): Decimal
    {
        return $this->price->mul(new Decimal($this->quantity));
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'productId' => $this->productId,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'sizeId' => $this->sizeId,
        ];
    }
}
