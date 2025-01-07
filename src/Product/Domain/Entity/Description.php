<?php

namespace App\Product\Domain\Entity;

class Description
{
    protected int $id;

    /** @var string[] */
    protected array $description;

    public function __construct(int $id, array $description)
    {
        $this->id = $id;
        $this->description = $description;
    }

    public  function __get($property)
    {
        return $this->$property;
    }

    public function getDescriptionKeys(): array
    {
        return array_keys($this->description);
    }
}
