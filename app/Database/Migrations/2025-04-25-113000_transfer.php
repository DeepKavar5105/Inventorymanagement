<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Transfers extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'transfers_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'fromStoreId' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'toStoreId' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'specialNotes' => [
                'type' => 'TEXT',
                'null' => true,
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
                'null'       => true,
            ],
            'updated_By' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
                'null'       => true,
            ],
            'deleted_By' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
                'null'       => true,
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

        $this->forge->addKey('transfers_id', true);

        // Add foreign keys for fromStoreId and toStoreId
        $this->forge->addForeignKey('fromStoreId', 'stores', 'store_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('toStoreId', 'stores', 'store_id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('transfers');
    }

    public function down()
    {
        $this->forge->dropTable('transfers');
    }
}
