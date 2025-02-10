<?php

namespace App\Order\Domain\Builder;

use App\Order\Domain\Entity\Order;

class OrderBuilder
{
    protected Order $order;

    public function __construct()
    {
        $this->order = new Order();
    }

    public function build(): Order
    {
        return $this->order;
    }
}
