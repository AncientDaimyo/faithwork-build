<?php

namespace App\Product\Domain\Entity;

class Product
{
    protected int $id;

    protected string $name;

    protected Description $description;

    protected ?ProductImageGallery $productImageGallery;

    protected float $price;

    /** @var string[] */
    protected array $sizes;

    public function __construct(
        int $id,
        string $name,
        Description $description,
        ?ProductImageGallery $productImageGallery,
        float $price,
        array $sizes
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->productImageGallery = $productImageGallery;
        $this->price = $price;
        $this->sizes = $sizes;
    }

    public function __get($property): mixed
    {
        return $this->$property;
    }
}
