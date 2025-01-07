<?php

namespace App\Shared\Utility\Migrations\Adapter;

use App\Shared\Utility\Migrations\Migration\Migration;

interface AdapterInterface
{
    /**
     * Get all migrated version numbers
     *
     * @return array
     */
    public function fetchAll();

    /**
     * Up
     *
     * @param Migration $migration
     * @return AdapterInterface
     */
    public function up(Migration $migration);

    /**
     * Down
     *
     * @param Migration $migration
     * @return AdapterInterface
     */
    public function down(Migration $migration);

    /**
     * Is the schema ready? 
     *
     * @return bool
     */
    public function hasSchema();

    /**
     * Create Schema
     *
     * @return AdapterInterface
     */
    public function createSchema();
}



