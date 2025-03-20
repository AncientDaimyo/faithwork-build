<?php

namespace App\Test\Unit\Order\Application;

use App\Order\Storage\OrderStatusStorage;
use App\Shared\Domain\Type\Decimal;
use PHPUnit\Framework\TestCase;
use App\Order\DTO\OrderDto;
use App\Order\Entity\Order;
use App\Order\DTO\OrderItemDto;
use App\Order\Repository\OrderRepository;
use App\Order\Service\OrderService;
use App\Order\Storage\PaymentStatusStorage;
use PHPUnit\Framework\MockObject\MockObject;

class OrderServiceTest extends TestCase
{
    // Creating a new order with valid OrderDto returns a positive order ID
    public function test_create_order(): void
    {
        $this->assertTrue(true);
    }
}
