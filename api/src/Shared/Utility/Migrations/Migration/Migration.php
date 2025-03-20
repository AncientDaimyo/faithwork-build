<?php

namespace App\Shared\Utility\Migrations\Migration;

use Psr\Container\ContainerInterface;
use Doctrine\DBAL\Connection as DbalConnection;


class Migration
{
    protected ContainerInterface $container;

    protected DbalConnection $connection;

    private string $filename;

    final public function __construct(ContainerInterface $container, string $filename)
    {
        $this->container = $container;
        $this->connection = $container->get('connection');
        $this->filename = $filename;
        $this->init();
    }

    public function init(): void
    {
        return;
    }

    public function up(): void
    {
        return;
    }

    public function down(): void
    {
        return;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function getFilename(): string
    {
        $path = explode(
            DIRECTORY_SEPARATOR,
            $this->filename
        );
        return array_pop($path);
    }
}
