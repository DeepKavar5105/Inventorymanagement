<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class transferItems extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'transfer_item_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'transferId' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'productId' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'transferQuantity' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'default'    => 0,
            ],
            'notes' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'receivedMessage' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'status' => [
                'type'       => 'TINYINT',
                'constraint' => '1',
                'default'    => 0,
            ],
            'created_By' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
            ],
            'updated_By' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
            ],
            'deleted_By' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
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
        $this->forge->addKey('transfer_item_id', true);
         $this->forge->addForeignKey('transferId', 'transfers', 'transfers_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('productId', 'products', 'product_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('transfersItems');
    }

    public function down()
    {
        $this->forge->dropTable('transfersItems');
    }
}