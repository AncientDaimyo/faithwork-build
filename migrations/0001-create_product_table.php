<?php

use App\Shared\Utility\Migrations\Migration\Migration;
use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Types\Types;

return new class($container, __FILE__) extends Migration
{
    protected $tableName = 'products';

    protected $columns = [
        'id' => [
            'type' => Types::INTEGER,
            'options' => [
                'unsigned' => true,
                'autoincrement' => true,
                'notnull' => true,
            ],
        ],
        'name' => [
            'type' => Types::STRING,
            'options' => [
                'length' => 255,
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
        'category_id' => [
            'type' => Types::INTEGER,
            'options' => [
                'notnull' => true,
            ],
        ],
        'description_id' => [
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

        $this->connection->createSchemaManager()->createTable($table);
    }

    public function down(): void
    {
        // $this->connection->createSchemaManager()->dropTable($this->tableName);
    }
};

