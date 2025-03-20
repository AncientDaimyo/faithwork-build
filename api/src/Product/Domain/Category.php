<?php

namespace App\Product\Domain;

use App\Shared\Domain\Entity\Entity;

class Category extends Entity
{
    protected ?int $id;
    protected ?string $name;
    protected ?Category $parentCategory;

    public function __construct(
        ?int $id,
        ?string $name,
        ?Category $parentCategory
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->parentCategory = $parentCategory;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'parent_category' => !empty($this->parentCategory) ? $this->parentCategory->jsonSerialize() : null
        ];
    }
}
