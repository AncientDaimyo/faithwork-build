<?php

namespace App\Product\Domain;

use App\Shared\Domain\Entity\Entity;

class Description extends Entity
{
    protected ?int $id;
    protected ?string $description;

    public function __construct(
        ?int $id,
        ?string $description
    ) {
        $this->id = $id;
        $this->description = $description;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'description' => $this->description
        ];
    }
}
