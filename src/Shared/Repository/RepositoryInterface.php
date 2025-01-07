<?php

namespace App\Shared\Repository;

interface RepositoryInterface
{
    public function find($id);

    public function findAll();

    public function save($entity);

    public function delete($entity);

    public function update($entity);
}
