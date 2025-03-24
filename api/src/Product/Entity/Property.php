<?php

namespace App\Product\Entity;

use App\Shared\Domain\Entity\Entity;

class Property extends Entity
{
    protected ?int $id;
    protected ?string $name;
    protected ?string $value;

    public function __construct(
        ?int $id,
        ?string $name,
        ?string $value
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->value = $value;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'value' => $this->value
        ];
    }
}
