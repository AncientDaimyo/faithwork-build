<?php

namespace App\Order\Infrastructure\Repository;

use App\Order\Domain\Entity\Order;
use App\Shared\Infrastructure\Repository\Repository;

class OrderRepository extends Repository
{
    protected string $table = 'orders';
    protected string $orderItemTable = 'order_items';

    public function getById(int $id): array
    {
        $qb = $this->connection->createQueryBuilder()
        ->select('*')
        ->from($this->table, 'o')
        ->leftJoin('o', $this->orderItemTable, 'oi', 'oi.order_id = o.id')
        ->where('o.id = :id')
        ->setParameter('id', $id);

        return $qb->fetchAllAssociative();
    }

    public function getByCustomerId(int $customerId): array
    {
        $qb = $this->connection->createQueryBuilder()
        ->select('*')
        ->from($this->table)
        ->where('customer_id = :customerId')
        ->setParameter('customerId', $customerId);

        return $qb->fetchAllAssociative();
    }

    public function saveOrder(Order $order): int
    {
        $sql = <<<SQL
INSERT INTO orders (customer_id, total) VALUES (:customer_id, :total)
SQL;

        $this->connection->executeStatement($sql, [
            'customer_id' => $order->customerId,
            'total' => $order->calculateTotal(),
        ]);

        $orderId = $this->connection->lastInsertId();

        $sql = <<<SQL
INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)
SQL;

        foreach ($order->items as $item) {
            $this->connection->executeStatement($sql, [
                'order_id' => $orderId,
                'product_id' => $item['productId'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        return $orderId;
    }

    public function updateOrder(Order $order): void
    {
        $this->connection->createQueryBuilder()
        ->update($this->table)
        ->where('id = :id')
        ->setParameter('id', $order->id)
        ->set('customer_id', $order->customerId)
        ->set('total', $order->calculateTotal())
        ->executeQuery();

        $this->connection->createQueryBuilder()
        ->delete($this->orderItemTable)
        ->where('order_id = :orderId')
        ->setParameter('orderId', $order->id)
        ->executeQuery();

        $sql = <<<SQL
INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)
SQL;

        foreach ($order->items as $item) {
            $this->connection->executeStatement($sql, [
                'order_id' => $order->id,
                'product_id' => $item['productId'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }
    }

    public function deleteOrder(int $orderId): void
    {
        $this->connection->createQueryBuilder()
        ->delete($this->table)
        ->where('id = :id')
        ->setParameter('id', $orderId)
        ->executeQuery();

        $this->connection->createQueryBuilder()
        ->delete($this->orderItemTable)
        ->where('order_id = :orderId')
        ->setParameter('orderId', $orderId)
        ->executeQuery();
    }
}
