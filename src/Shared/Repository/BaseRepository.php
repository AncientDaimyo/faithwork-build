<?php

namespace App\Shared\Repository;

use Doctrine\DBAL\Connection;

class BaseRepository implements RepositoryInterface
{
    /**
     * Table name
     *
     * @var string
     */
    protected ?string $table;

    /**
     * Connection
     *
     * @var Connection
     */
    protected $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function find($id)
    {
        return $this->connection->fetchAssociative('SELECT * FROM ' . $this->table . ' WHERE id = :id', ['id' => $id]);
    }

    public function findAll()
    {
        return $this->connection->fetchAllAssociative('SELECT * FROM ' . $this->table);
    }

    public function save($entity)
    {
        return $this->connection->insert($this->table, $entity);
    }

    public function delete($id)
    {
        return $this->connection->delete($this->table, ['id' => $id]);
    }

    public function update($entity)
    {
        return $this->connection->update($this->table, $entity, ['id' => $entity['id']]);
    }

    public function setTable($table)
    {
        $this->table = $table;
    }
}

