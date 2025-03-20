<?php

declare(strict_types=1);

namespace App\Order\Migrations;

use App\Shared\Utility\Migrations\Migration\Migration;
use Doctrine\DBAL\Types\Types;
use Doctrine\DBAL\Schema\Table;

return new class($container, __FILE__) extends Migration
{
    protected string $orderTableName = 'orders';
    protected string $orderItemsTableName = 'order_items';

    protected array $orderTableColumns = [
        'id' => [
            'type' => Types::INTEGER,
            'options' => [
                'notnull' => true,
                'autoincrement' => true,
            ],
        ],
        'customer_id' => [
            'type' => Types::INTEGER,
            'options' => [
                'notnull' => true,
            ],
        ],
        'total' => [
            'type' => Types::DECIMAL,
            'options' => [
                'precision' => 10,
                'scale' => 2,
                'notnull' => true,
            ],
        ],
        'order_status' => [
            'type' => Types::STRING,
            'options' => [
                'notnull' => true,
            ],
        ],
        'payment_status' => [
            'type' => Types::INTEGER,
            'options' => [
                'notnull' => true,
            ],
        ],
        'order_status' => [
            'type' => Types::INTEGER,
            'options' => [
                'notnull' => true,
            ],
        ],
    ];

    protected array $orderItemTableColumns = [
        'id' => [
            'type' => Types::INTEGER,
            'options' => [
                'notnull' => true,
                'autoincrement' => true,
            ],
        ],
        'order_id' => [
            'type' => Types::INTEGER,
            'options' => [
                'notnull' => true,
            ],
        ],
        'product_id' => [
            'type' => Types::INTEGER,
            'options' => [
                'notnull' => true,
            ],
        ],
        'quantity' => [
            'type' => Types::INTEGER,
            'options' => [
                'notnull' => true,
            ],
        ],
        'price' => [
            'type' => Types::DECIMAL,
            'options' => [
                'precision' => 10,
                'scale' => 2,
                'notnull' => true,
            ],
        ],
    ];

    public function up(): void
    {
        $this->createOrderTable();
        $this->createOrderItemTable();
    }

    protected function createOrderTable(): void
    {
        $table = new Table($this->orderTableName);

        foreach ($this->orderTableColumns as $name => $options) {
            $table->addColumn($name, $options['type'], $options['options']);
        }

        $table->setPrimaryKey(['id']);
        $this->connection->createSchemaManager()->createTable($table);
    }

    protected function createOrderItemTable(): void
    {
        $table = new Table($this->orderItemsTableName);

        foreach ($this->orderItemTableColumns as $name => $options) {
            $table->addColumn($name, $options['type'], $options['options']);
        }

        $table->setPrimaryKey(['id']);
        $this->connection->createSchemaManager()->createTable($table);
    }

    protected function dropOrderTable(): void
    {
        $this->connection->createSchemaManager()->dropTable($this->orderTableName);
    }

    protected function dropOrderItemTable(): void
    {
        $this->connection->createSchemaManager()->dropTable($this->orderItemsTableName);
    }

    public function down(): void
    {
        $this->dropOrderTable();
        $this->dropOrderItemTable();
    }
};
