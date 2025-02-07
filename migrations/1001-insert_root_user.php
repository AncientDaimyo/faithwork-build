<?php

use App\Shared\Utility\Migrations\Migration\Migration;

return new class ($container, __FILE__) extends Migration
{
    public function up(): void
    {
        $this->connection->insert('users', [
            'email' => 'root@localhost',
            'password' => password_hash('root', PASSWORD_DEFAULT),
            'role' => 'admin',
            'activated' => true,
            'activation_code' => null
        ]);
    }

    public function down(): void
    {

    }
};
