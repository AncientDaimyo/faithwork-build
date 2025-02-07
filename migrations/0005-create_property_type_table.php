<?php

use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Types\Types;
use App\Shared\Utility\Migrations\Migration\Migration;

return new class ($container, __FILE__) extends Migration
{
    protected $tableName = 'property_types';

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
        $this->connection->createSchemaManager()->dropTable($this->tableName);
    }
};
