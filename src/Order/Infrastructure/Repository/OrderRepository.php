<?php

namespace App\Order\Infrastructure\Repository;

use App\Shared\Infrastructure\Repository\Repository;

class OrderRepository extends Repository
{
    protected $table = 'orders';
}
