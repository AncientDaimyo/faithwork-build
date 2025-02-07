<?php

namespace App\Shared\Utility\Migrations\Api;

use App\Shared\Utility\Migrations\Adapter\AdapterInterface;
use Psr\Container\ContainerInterface;
use App\Shared\Utility\Migrations\Migration\Migration;

class MigrationExecutor
{
    protected array $migrations;

    protected AdapterInterface $adapter;

    protected ContainerInterface $container;

    public function __construct(AdapterInterface $adapter, string $migrationsPath, ContainerInterface $container)
    {
        $this->container = $container;

        $migrationsPath = realpath($migrationsPath);

        $this->adapter = $adapter;

        $this->migrations = [];

        if (!empty($migrationsPath)) {
            $this->migrations = array_merge($this->migrations, glob($migrationsPath . DIRECTORY_SEPARATOR . '*.php'));
        }

        $this->migrations = array_unique($this->migrations);
    }


    public function up(): void
    {
        if (!$this->adapter->hasSchema()) {
            $this->adapter->createSchema();
        }

        foreach ($this->getMigrations($this->getVersion()) as $migration) {
            $this->adapter->up($migration);
        }
    }

    public function down(): void
    {
        foreach ($this->getMigrations($this->getVersion(), false) as $migration) {
            $this->adapter->down($migration);
        }
    }

    public function getMigrations(int $version, bool $up = true)
    {
        $migrations = [];

        foreach ($this->migrations as $path) {
            $migrationNumber = $this->getMigrationNumberFromPath($path);
            if ($up) {
                if ($migrationNumber <= $version) {
                    continue;
                }
            } else {
                if ($migrationNumber > $version) {
                    continue;
                }
            }

            $migrations[] = $path;
        }

        return $this->loadMigrations($migrations);
    }

    protected function getMigrationNumberFromPath(string $path)
    {
        $parts = explode(DIRECTORY_SEPARATOR, $path);
        return (int) substr(end($parts), 0, 4);
    }

    protected function loadMigrations(array $migrationsPaths): array
    {
        $migrations = [];
        foreach ($migrationsPaths as $migration) {
            $migrations[] =  $this->createMigrationObject($migration);
        }

        return $migrations;
    }

    public function getVersion()
    {
        $versions = $this->adapter->fetchAll();
        $sortedVersions = [];

        foreach ($versions as $version) {
            $sortedVersions[] = $this->getMigrationNumberFromPath($version);
        }

        sort($sortedVersions);

        if (!empty($versions)) {
            return end($sortedVersions);
        }

        return 0;
    }

    protected function createMigrationObject(string $path): Migration
    {
        $container = $this->container;
        return require $path;
    }
}
