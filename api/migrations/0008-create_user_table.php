<?php

use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Types\Types;
use App\Shared\Utility\Migrations\Migration\Migration;

return new class($container, __FILE__) extends Migration
{
    protected $tableName = 'users';

    protected $columns = [
        'id' => [
            'type' => Types::INTEGER,
            'options' => [
                'autoincrement' => true,
                'notnull' => true
            ]
        ],
        'email' => [
            'type' => Types::STRING,
            'options' => [
                'notnull' => true,
                'length' => 255
            ],
        ],
        'password' => [
            'type' => Types::STRING,
            'options' => [
                'notnull' => true,
                'length' => 255
            ],
        ],
        'role' => [
            'type' => Types::STRING,
            'options' => [
                'notnull' => true,
                'length' => 255
            ]
        ],
        'activated' => [
            'type' => Types::BOOLEAN,
            'options' => [
                'notnull' => true,
            ]
        ],
        'activation_code' => [
            'type' => Types::STRING,
            'options' => [
                'length' => 255,
                'notnull' => false
            ]
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
