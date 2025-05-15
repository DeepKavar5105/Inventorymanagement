<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTrasferItem extends Migration
{
    public function up()
    {
        // Add new foreign key column 'product_id' to the 'transfers' table
        $this->forge->addColumn('transfers', [
            'product_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
                'after'      => 'toStoreId' // You can change this if you want it after a different column
            ]
        ]);

        // Add foreign key constraint linking 'product_id' to 'products' table
        $this->forge->addForeignKey('product_id', 'products', 'product_id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        // Drop the foreign key constraint and column if rolling back
        $this->forge->dropForeignKey('transfers', 'transfers_product_id_foreign'); // Foreign key name follows 'table_column_foreign'
        $this->forge->dropColumn('transfers', 'product_id');
    }
}
