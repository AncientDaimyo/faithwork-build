<?php

namespace App\Product\Infrastructure\Repository;

use App\Shared\Infrastructure\Repository\Repository;

class PropertyRepository extends Repository
{
    protected string $table = 'property_values';

    public function getPropertiesByProductId(int $id): array
    {
        return $this->connection->createQueryBuilder()
            ->select('*')
            ->from($this->table, 'p')
            ->leftJoin('p', 'property_types', 'prop', 'prop.id = p.type_id')
            ->where('p.product_id = :id')
            ->setParameter('id', $id)
            ->fetchAllAssociative();
    }
}
