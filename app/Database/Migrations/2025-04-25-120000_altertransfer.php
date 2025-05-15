<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTrasferItem extends Migration
{
    public function up()
    {
        $this->forge->addColumn('transfers', [
            'quantity' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
                'default'    => 1,
                'after'      => 'specialNotes' 
            ],
            'productName' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => false,
                'after'      => 'toStoreId' 
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('transfers', 'quantity');
    }
}
