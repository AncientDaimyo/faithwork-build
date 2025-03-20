<?php

namespace App\Product\Domain;

use App\Shared\Domain\Entity\Entity;
use App\Product\Domain\Description;

class Product extends Entity
{
    protected ?int $id;
    protected ?string $name;
    protected ?string $price;
    protected ?Description $description;
    protected ?array $sizes = [];
    protected ?array $properties = [];
    protected ?Category $category;

    public function __construct(
        ?int $id,
        ?string $name,
        ?string $price,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
    }

    public function setProperties(array $properties): void
    {
        $this->properties = $properties;
    }    

    public function setSizes(array $sizes): void
    {
        $this->sizes = $sizes;
    }

    public function setCategory(?Category $category): void
    {
        $this->category = $category;
    }

    public function setDescription(?Description $description): void
    {
        $this->description = $description;
    }

    protected function serializeProperties(): array
    {
        $properties = [];
        foreach ($this->properties as $property) {
            $properties[] = $property->jsonSerialize();
        }
        return $properties;
    }

    public function serializeSizes(): array
    {
        $sizes = [];
        foreach ($this->sizes as $size) {
            $sizes[] = $size->jsonSerialize();
        }
        return $sizes;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description->jsonSerialize(),
            'sizes' => $this->serializeSizes(),
            'properties' => $this->serializeProperties(),
            'category' => $this->category->jsonSerialize()
        ];
    }
}
