<?php

namespace App\Test\Unit\Order\Application;

use App\Order\Application\Boundary\OrderServiceBoundary;
use App\Order\Application\Service\OrderService;
use App\Order\Domain\Entity\Order;
use App\Order\Infrastructure\Repository\OrderRepository;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use App\Order\Domain\Storage\OrderStatusStorage;
use App\Order\Domain\Storage\PaymentStatusStorage;
use App\Order\Domain\Entity\OrderItem;

class OrderServiceTest extends TestCase
{
    protected OrderServiceBoundary $orderService;
    protected $orderItemsDB = [
        [
            'id' => 1,
            'order_id' => 1,
            'product_id' => 1,
            'quantity' => 1,
            'price' => 100,
        ],
        [
            'id' => 2,
            'order_id' => 1,
            'product_id' => 2,
            'quantity' => 1,
            'price' => 100,
        ],
        [
            'id' => 3,
            'order_id' => 1,
            'product_id' => 3,
            'quantity' => 1,
            'price' => 100,
        ],
        [
            'id' => 4,
            'order_id' => 2,
            'product_id' => 1,
            'quantity' => 1,
            'price' => 100,
        ],
        [
            'id' => 5,
            'order_id' => 2,
            'product_id' => 2,
            'quantity' => 1,
            'price' => 100,
        ],
        [
            'id' => 6,
            'order_id' => 2,
            'product_id' => 3,
            'quantity' => 1,
            'price' => 100,
        ],
    ];
    
    protected $ordersDB = [
        [
            'id' => 1,
            'customer_id' => 1,
            'status' => 0,
            'total_price' => 300,
            'payment_status' => 0,
            'items' => [
                [
                    'id' => 1,
                    'order_id' => 1,
                    'product_id' => 1,
                    'quantity' => 1,
                    'price' => 100,
                ],
                [
                    'id' => 2,
                    'order_id' => 1,
                    'product_id' => 2,
                    'quantity' => 1,
                    'price' => 100,
                ],
                [
                    'id' => 3,
                    'order_id' => 1,
                    'product_id' => 3,
                    'quantity' => 1,
                    'price' => 100,
                ],
            ],
        ],
        [
            'id' => 2,
            'customer_id' => 2,
            'status' => 0,
            'total_price' => 300,
            'payment_status' => 0,
            'items' => [
                [
                    'id' => 4,
                    'order_id' => 2,
                    'product_id' => 1,
                    'quantity' => 1,
                    'price' => 100,
                ],
                [
                    'id' => 5,
                    'order_id' => 2,
                    'product_id' => 2,
                    'quantity' => 1,
                    'price' => 100,
                ],
                [
                    'id' => 6,
                    'order_id' => 2,
                    'product_id' => 3,
                    'quantity' => 1,
                    'price' => 100,
                ],
            ],
        ],
    ];

    protected $expectedOrders = [
        [
            'id' => 1,
            'customerId' => 1,
            'orderStatus' => OrderStatusStorage::STATUS_NEW,
            'paymentStatus' => PaymentStatusStorage::UNPAID,
            'total' => 300.0,
            'items' => [
                [
                    'id' => 1,
                    'orderId' => 1,
                    'productId' => 1,
                    'quantity' => 1,
                    'price' => 100,
                ],
                [
                    'id' => 2,
                    'orderId' => 1,
                    'productId' => 2,
                    'quantity' => 1,
                    'price' => 100,
                ],
                [
                    'id' => 3,
                    'orderId' => 1,
                    'productId' => 3,
                    'quantity' => 1,
                    'price' => 100,
                ],
            ],
        ],
        [
            'id' => 2,
            'customerId' => 1,
            'orderStatus' => OrderStatusStorage::STATUS_NEW,
            'paymentStatus' => PaymentStatusStorage::UNPAID,
            'total' => 300.0,
            'items' => [
                [
                    'id' => 4,
                    'orderId' => 2,
                    'productId' => 4,
                    'quantity' => 1,
                    'price' => 100,
                ],
                [
                    'id' => 5,
                    'orderId' => 2,
                    'productId' => 5,
                    'quantity' => 1,
                    'price' => 100,
                ],
                [
                    'id' => 6,
                    'orderId' => 2,
                    'productId' => 6,
                    'quantity' => 1,
                    'price' => 100,
                ],
            ],
        ],
    ];



    protected OrderRepository $orderRepository;

    protected function setUp(): void
    {
        parent::setUp();

        /**
         * @var OrderRepository & MockObject
         */
        $this->orderRepository = $this->createMock(OrderRepository::class);
        $this->orderRepository->expects($this->any())->method('getByCustomerId')->willReturnCallback(function ($customerId) {
            switch ($customerId) {
                case 1:
                    $orders = [];
                    foreach ($this->ordersDB as $order) {
                        if ($order['customer_id'] === $customerId) {
                            $orders[] = $order;
                        }
                    }
                    foreach ($orders as &$order) {
                        $items = [];
                        foreach ($this->orderItemsDB as $item) {
                            if ($item['order_id'] === $order['id']) {
                                $items[] = $item;
                            }
                        }
                        $order['items'] = $items;
                    }
                    return $orders;
                default:
                    return [];
            }
        });

        $this->orderRepository->expects($this->any())->method('getById')->willReturnCallback(function ($orderId) {
            switch ($orderId) {
                case 1:
                    $response = $this->ordersDB[0];
                    $items = [];
                    foreach ($this->orderItemsDB as $orderItem) {
                        if ($orderItem['order_id'] === $orderId) {
                            $items[] = $orderItem;
                        }
                    }
                    $response['items'] = $items;
                    return $response;
                default:
                    return [];
            }
        });

        $this->orderRepository->expects($this->any())->method('saveOrder')->willReturnCallback(function (Order $order) {
            if (!empty($this->validateOrder($order))) {
                throw new \InvalidArgumentException('Invalid test save Order data: '
                . $this->validateOrder($order)
                . ' '
                . json_encode($order->jsonSerialize()));
            }
            return 1;
        });

        $this->orderRepository->expects($this->any())->method('updateOrder')->willReturnCallback(function (Order $order) {
            if (!empty($this->validateOrder($order, true))) {
                throw new \InvalidArgumentException('Invalid test update Order data');
            }
            return 1;
        });

        $this->orderRepository->expects($this->any())->method('deleteOrder')->willReturnCallback(function ($orderId) {
            switch ($orderId) {
                case 1:
                    return 1;
                default:
                    throw new \InvalidArgumentException('Invalid order id');
            }
        });

        $this->orderService = new OrderService($this->orderRepository);
    }

    protected function validateOrder(Order $order, bool $isUpdate = false): string
    {
        if (!empty($order->id)) {
            return 'Invalid id';
        }

        if (!$isUpdate) {
            foreach ($order->items as $orderItem) {
                if (!$this->validateOrderItem($orderItem)) {
                    return 'Invalid order item';
                }
            }
        }


        if ($order->customerId !== 1) {
            return 'Invalid customer id';
        }

        if ($order->orderStatus !== OrderStatusStorage::STATUS_NEW) {
            return 'Invalid order status';
        }

        if ($order->paymentStatus !== PaymentStatusStorage::UNPAID) {
            return 'Invalid payment status';
        }

        return '';
    }

    protected function validateOrderItem(OrderItem $orderItem): bool
    {
        if ($orderItem->id !== null) {
            throw new \InvalidArgumentException('Invalid order item id');
        }

        if ($orderItem->orderId !== null) {
            throw new \InvalidArgumentException('Invalid order item order id');
        }

        if ($orderItem->productId < 1) {
            throw new \InvalidArgumentException('Invalid order item product id');
        }

        return true;
    }

    public function testTrue(): void
    {
        $this->assertTrue(true);
    }

    public function testCreateOrder(): void
    {
        $data = [
            'customerId' => 1,
            'items' => [
                ['productId' => 1, 'quantity' => 1, 'price' => 100],
                ['productId' => 2, 'quantity' => 1, 'price' => 100],
                ['productId' => 3, 'quantity' => 1, 'price' => 100],
            ],
        ];

        try {
            $this->orderService->createOrder($data);
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function testGetOrder(): void
    {
        $orderId = 1;
        $response = $this->orderService->getOrder($orderId);
        $this->assertEquals($this->expectedOrders[0], $response);
    }

    public function testGetOrders(): void
    {
        $customerId = 1;
        $response = $this->orderService->getOrders($customerId);
        $this->assertEquals($this->expectedOrders[0], $response[0]);
    }

    public function testUpdateOrder(): void
    {
        $orderId = 1;
        $data = [
            'customerId' => 1,
            'items' => [
                ['orderId' => 1, 'productId' => 1, 'quantity' => 1, 'price' => 100],
                ['orderId' => 1, 'productId' => 2, 'quantity' => 1, 'price' => 100],
                ['orderId' => 1, 'productId' => 3, 'quantity' => 1, 'price' => 100],
            ],
        ];

        try {
            $this->orderService->updateOrder($orderId, $data);
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function testDeleteOrder(): void
    {
        $orderId = 1;
        try {
            $this->orderService->deleteOrder($orderId);
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }

        $this->assertTrue(true);
    }
}
