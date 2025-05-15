<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRoleIdToEmployees extends Migration
{
    public function up()
    {
        // Add 'role_id' column
        $this->forge->addColumn('employees', [
            'role_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'emp_id', 
            ],
        ]);

        // Add Foreign Key
        $this->db->query('ALTER TABLE employees ADD CONSTRAINT employees_role_id_foreign FOREIGN KEY (role_id) REFERENCES roles(role_id) ON DELETE CASCADE ON UPDATE CASCADE');
    }

    public function down()
    {
        // First Drop Foreign Key
        $this->db->query('ALTER TABLE employees DROP FOREIGN KEY employees_role_id_foreign');

        // Then Drop Column
        $this->forge->dropColumn('employees', 'role_id');
    }
}
