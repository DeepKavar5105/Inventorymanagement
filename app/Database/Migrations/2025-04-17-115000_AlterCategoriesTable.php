<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterCategoriesTable extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('categorys', [
            'deleted_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true, 
            ],
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('categorys', [
            'deleted_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
        ]);
    }
}
