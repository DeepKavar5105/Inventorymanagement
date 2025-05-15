<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProductsImages extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'product_image_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'storeId' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'productId' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'availableQuantity' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'default'    => 0,
            ],
            'blockedQuantity' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'default'    => 0,
            ],
            'status' => [
                'type'       => 'TINYINT',
                'constraint' => '1',
                'default'    => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('product_image_id', true);
        $this->forge->addForeignKey('storeId', 'stores', 'store_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('productId', 'products', 'product_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('productsImages');
    }

    public function down()
    {
        $this->forge->dropTable('productsImages');
    }
}