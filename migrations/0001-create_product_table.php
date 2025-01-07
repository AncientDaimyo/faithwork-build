<?php

use App\Shared\Utility\Migrations\Migration\Migration;

return new class ($container, __FILE__) extends Migration
{
    public function up(): void
    {
        $sql = <<<SQL
CREATE TABLE `products` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `description` TEXT NOT NULL,
    `price` DECIMAL(10, 2) NOT NULL,
    `image_url` VARCHAR(255) NOT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
SQL;
        $this->connection->executeQuery($sql);
    }   

    public function down(): void
    {
        $sql = <<<SQL
DROP TABLE `products`;
SQL;
    $this->connection->executeQuery($sql);
    }
};
