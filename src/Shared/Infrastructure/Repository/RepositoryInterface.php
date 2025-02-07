<?php

namespace App\Shared\Infrastructure\Repository;

interface RepositoryInterface
{
    public function getById(int $id): array;

    public function getAll(): array;

    public function insert(array $data): int;

    public function delete(int $id): int;

    public function update(array $data): int;
}
