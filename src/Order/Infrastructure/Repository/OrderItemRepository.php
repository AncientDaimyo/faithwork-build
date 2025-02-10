<?php

namespace App\Order\Infrastructure\Repository;

use App\Shared\Infrastructure\Repository\Repository;

class OrderItemRepository extends Repository
{
    protected $table = 'order_items';
}
