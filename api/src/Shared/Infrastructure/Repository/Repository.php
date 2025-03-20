<?php

namespace App\Shared\Infrastructure\Repository;

use Doctrine\DBAL\Connection;
use InvalidArgumentException;

abstract class Repository implements RepositoryInterface
{
    protected string $table;

    protected Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getById(int $id): array
    {
        $qb = $this->connection->createQueryBuilder();

        return $qb->select('*')
            ->from($this->table)
            ->where('id = :id')
            ->setParameter('id', $id)
            ->fetchAssociative();
    }

    public function getAll(): array
    {
        $qb = $this->connection->createQueryBuilder();

        return $qb->select('*')
            ->from($this->table)
            ->fetchAllAssociative();
    }

    public function insert(array $data): int
    {
        // TODO validate data

        $qb = $this->connection->createQueryBuilder();

        return $qb->insert($this->table)
            ->values($data)
            ->executeQuery()
            ->rowCount();
    }

    public function delete(int $id): int
    {
        $qb = $this->connection->createQueryBuilder();

        return $qb->delete($this->table)
            ->where('id = :id')
            ->setParameter('id', $id)
            ->executeQuery()
            ->rowCount();
    }

    public function update(array $data): int
    {
        if (empty($data) || empty($data['id'])) {
            throw new InvalidArgumentException('Data must contain id');
        }

        // TODO validate data

        $qb = $this->connection->createQueryBuilder();

        $qb->update($this->table)
            ->where('id = :id')
            ->setParameter('id', $data['id']);

        foreach ($data as $column => $value) {
            $qb->set($column, ':' . $column);
            $qb->setParameter($column, $value);
        }

        return $qb->executeQuery()->rowCount();
    }
}
