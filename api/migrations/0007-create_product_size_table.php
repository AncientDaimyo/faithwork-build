<?php

use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Types\Types;
use App\Shared\Utility\Migrations\Migration\Migration;

return new class ($container, __FILE__) extends Migration
{
    protected $tableName = 'product_sizes';
    protected $columns = [
        'id' => [
            'type' => Types::INTEGER,
            'options' => [
                'autoincrement' => true,
                'notnull' => true
            ]
        ],
        'product_id' => [
            'type' => Types::INTEGER,
            'options' => [
                'notnull' => true,
            ],
        ],
        'size_id' => [
            'type' => Types::INTEGER,
            'options' => [
                'notnull' => true,
            ],
        ]
    ];

    public function up(): void
    {
        $table = new Table($this->tableName);

        foreach ($this->columns as $name => $options) {
            $table->addColumn($name, $options['type'], $options['options']);
        }

        $table->setPrimaryKey(['id']);

        $table->addUniqueIndex(['product_id', 'size_id'], 'unique_product_size');

        $this->connection->createSchemaManager()->createTable($table);
    }

    public function down(): void
    {
        // $this->connection->createSchemaManager()->dropTable($this->tableName);
    }
};
