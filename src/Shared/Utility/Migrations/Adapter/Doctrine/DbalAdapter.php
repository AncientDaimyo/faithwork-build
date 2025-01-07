<?php

/**
 * @package    Phpmig
 * @subpackage Phpmig\Adapter
 */

namespace App\Shared\Utility\Migrations\Adapter\Doctrine;

use Doctrine\DBAL\Connection;
use App\Shared\Utility\Migrations\Migration\Migration;
use App\Shared\Utility\Migrations\Adapter\AdapterInterface;

class DbalAdapter implements AdapterInterface
{

    protected Connection $connection;

    protected string $tableName;

    protected $schemaManager;

    /**
     * Constructor
     *
     * @param Connection $connection
     * @param string $tableName
     */
    public function __construct(Connection $connection, string $tableName)
    {
        $this->connection = $connection;
        $this->tableName  = $tableName;
        $this->schemaManager = $connection->createSchemaManager();
    }

    /**
     * Fetch all 
     *
     * @return array
     */
    public function fetchAll()
    {
        $tableName = $this->connection->quoteIdentifier($this->tableName);
        $sql = "SELECT version FROM $tableName ORDER BY version ASC";
        $all = $this->connection->fetchAllAssociative($sql);
        return array_map(function ($v) {
            return $v['version'];
        }, $all);
    }

    /**
     * Up
     *
     * @param Migration $migration
     * @return DBAL
     */
    public function up(Migration $migration)
    {
        $migration->up();
        $this->connection->insert($this->tableName, array(
            'version' => $migration->getFilename(),
        ));
        return $this;
    }

    /**
     * Down
     *
     * @param Migration $migration
     * @return DBAL
     */
    public function down(Migration $migration)
    {
        $migration->down();
        $this->connection->delete($this->tableName, array(
            'version' => $migration->getFilename(),
        )); 
        return $this;
    }

    /**
     * Is the schema ready? 
     *
     * @return bool
     */
    public function hasSchema()
    {
        $tables = $this->schemaManager->listTableNames();
        foreach ($tables as $table) {
            if ($table == $this->tableName) {
                return true;
            }
        }
        return false;
    }

    /**
     * Create Schema
     *
     * @return DBAL
     */
    public function createSchema()
    {
        $schema  = new \Doctrine\DBAL\Schema\Schema();
        $table   = $schema->createTable($this->tableName);
        $table->addColumn("version", "string", array("length" => 255));
        $queries = $schema->toSql($this->connection->getDatabasePlatform());
        foreach ($queries as $sql) {
            $this->connection->executeQuery($sql);
        }
        return $this;
    }
}
