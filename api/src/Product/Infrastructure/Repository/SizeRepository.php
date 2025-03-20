<?php

namespace App\Product\Infrastructure\Repository;

use App\Shared\Infrastructure\Repository\Repository;

class SizeRepository extends Repository
{
    protected string $table = 'sizes';
    protected string $productSizesTable = 'product_sizes';

    public function getSizesByProductId(int $id): array
    {
        $qb = $this->connection->createQueryBuilder();

        return $qb->select('*')
            ->from($this->productSizesTable, 'ps')
            ->leftJoin('ps', 'sizes', 'sz', 'sz.id = ps.size_id')
            ->where('ps.product_id = :id')
            ->setParameter('id', $id)
            ->fetchAllAssociative();
    }
}
