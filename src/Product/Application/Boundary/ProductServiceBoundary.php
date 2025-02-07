<?php

namespace App\Product\Application\Boundary;

interface ProductServiceBoundary
{
    public function getProducts(): array;

    public function getProduct(int $id): array;

    public function createProduct(array $data): int;

    public function updateProduct(int $id, array $data): int;  

    public function deleteProduct(int $id): int;
}
