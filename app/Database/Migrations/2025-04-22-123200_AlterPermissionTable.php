<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterPermissionTable extends Migration
{
    public function up()
    {
        $fields = [
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
            ]
        ];
        $this->forge->addColumn('permissions', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('permissions', ['created_By', 'updated_By', 'deleted_By', 'updateAccess']);
    }
}

?>