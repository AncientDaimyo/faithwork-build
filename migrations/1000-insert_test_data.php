<?php

use App\Shared\Utility\Migrations\Migration\Migration;

return new class ($container, __FILE__) extends Migration
{
    public function up(): void
    {
        $this->connection->prepare(
            'INSERT INTO categories (name) VALUES ("Test Category")'
        )->executeStatement();

        $this->connection->prepare(
            'INSERT INTO categories (name, parent_id) VALUES ("Test Subcategory", 1)'
        )->executeStatement();

        $this->connection->prepare(
            'INSERT INTO descriptions (description) VALUES ("Test Description")'
        )->executeStatement();

        $this->connection->prepare(
            'INSERT INTO property_types (name) VALUES ("Test Property Type")'
        )->executeStatement();

        $this->connection->prepare(
            'INSERT INTO products (name, price, category_id, description_id) VALUES ("Test Product", 10.00, 2, 1)'
        )->executeStatement();

        $this->connection->prepare(
            'INSERT INTO property_values (product_id, type_id, value) VALUES (1, 1, "Test Value")'
        )->executeStatement();

        $this->connection->prepare(
            'INSERT INTO sizes (size) VALUES ("Test Size")'
        )->executeStatement();

        $this->connection->prepare(
            'INSERT INTO product_sizes (product_id, size_id) VALUES (1, 1)'
        )->executeStatement();
    }

    public function down(): void
    {
        $this->connection->executeStatement(
            'DELETE FROM products WHERE name = "Test Product"',
        );

        $this->connection->executeStatement(
            'DELETE FROM product_sizes WHERE product_id = 1',
        );

        $this->connection->executeStatement(
            'DELETE FROM categories WHERE name = "Test Category"',
        );

        $this->connection->executeStatement(
            'DELETE FROM descriptions WHERE name = "Test Description"',
        );

        $this->connection->executeStatement(
            'DELETE FROM property_types WHERE name = "Test Property Type"',
        );

        $this->connection->executeStatement(
            'DELETE FROM property_values WHERE product_id = 1',
        );

        $this->connection->executeStatement(
            'DELETE FROM sizes WHERE size = "Test Size"',
        );
    }
};
