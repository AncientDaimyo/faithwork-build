<?php

use App\Shared\Utility\Migrations\Migration\Migration;

return new class ($container, __FILE__) extends Migration
{
    public function up(): void
    {
        $sql = <<<SQL
CREATE TABLE `users` (
  `id` INT NOT NULL AUTO_INCREMENT, 
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
SQL;
        $this->connection->executeQuery($sql);
    }

    public function down(): void
    {
        $sql = <<<SQL
DROP TABLE `users`;
SQL;
        $this->connection->executeQuery($sql);  
    }
};
