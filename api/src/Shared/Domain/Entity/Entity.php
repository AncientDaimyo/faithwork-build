<?php

namespace App\Shared\Domain\Entity;

use JsonSerializable;

abstract class Entity implements JsonSerializable
{
    protected ?int $id;

    public function __get($property): mixed
    {
        return $this->$property;
    }

    abstract public function jsonSerialize(): mixed;
}
