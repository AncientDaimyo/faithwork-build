<?php

use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Types\Types;
use App\Shared\Utility\Migrations\Migration\Migration;

return new class($container, __FILE__) extends Migration
{
    protected $tableName = 'user_tokens';
    protected $columns = [
        'user_id' => [
            'type' => Types::INTEGER,
            'options' => [
                'notnull' => true,
                'autoincrement' => false
            ],
        ],
        'auth_token' => [
            'type' => Types::STRING,
            'options' => [
                'notnull' => false,
                'length' => 255
            ],
        ],
        'refresh_token' => [
            'type' => Types::STRING,
            'options' => [
                'notnull' => false,
                'length' => 255
            ],
        ],
    ];

    public function up(): void
    {
        $table = new Table($this->tableName);

        foreach ($this->columns as $name => $options) {
            $table->addColumn($name, $options['type'], $options['options']);
        }

        $table->setPrimaryKey(['user_id']);

        $this->connection->createSchemaManager()->createTable($table);
    }

    public function down(): void
    {
        $this->connection->createSchemaManager()->dropTable($this->tableName);
    }
};