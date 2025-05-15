<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InventoryLog extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'inventory_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'storeId' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'productId' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'message' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'quantityBeforeChange' => [
                'type'     => 'INT',
                'null'     => false,
                'default'  => 0,
            ],
            'quantityAfterChange' => [
                'type'     => 'INT',
                'null'     => false,
                'default'  => 0,
            ],
            'actualQuantity' => [
                'type'     => 'INT',
                'null'     => false,
                'default'  => 0,
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
        $this->forge->addKey('inventory_id', true); 
        $this->forge->addForeignKey('storeId', 'stores', 'store_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('productId', 'products', 'product_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('inventoryLog');
    }

    public function down()
    {
        $this->forge->dropTable('inventoryLog');
    }
}