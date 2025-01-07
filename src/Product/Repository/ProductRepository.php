<?php

namespace App\Product\Repository;

use App\Shared\Repository\BaseRepository;
use Doctrine\DBAL\Connection;
use App\Shared\Repository\RepositoryInterface;
use Psr\Container\ContainerInterface;

class ProductRepository extends BaseRepository
{
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container->get('connection'));
        $this->table = 'product';
    }

    public function find($id)
    {
        return $this->connection->fetchAllAssociative('SELECT * FROM ' . $this->table . ' WHERE id = :id', ['id' => $id]);
    }

    public function findAll()
    {
        return $this->connection->fetchAllAssociative('SELECT * FROM ' . $this->table);
    }

    public function save($entity)
    {
        return $this->connection->insert($this->table, $entity);
    }

    public function update($entity)
    {
        return $this->connection->update($this->table, $entity, ['id' => $entity['id']]);
    }

    public function delete($id)
    {
        return $this->connection->delete($this->table, ['id' => $id]);
    }
}

