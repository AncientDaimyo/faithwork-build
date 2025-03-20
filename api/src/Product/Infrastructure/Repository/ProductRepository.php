<?php

namespace App\Product\Infrastructure\Repository;

use App\Shared\Infrastructure\Repository\Repository;

class ProductRepository extends Repository
{
    protected string $table = 'products'; 
}

