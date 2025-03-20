<?php

namespace App\Product\Domain;

use App\Shared\Domain\Entity\Entity;

class Size extends Entity
{
    protected ?int $id;
    protected ?string $size;

    public function __construct(
        ?int $id,
        ?string $size
    ) {
        $this->id = $id;
        $this->size = $size;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'size' => $this->size
        ];
    }
}
