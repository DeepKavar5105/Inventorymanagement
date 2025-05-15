<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'username'   => 'admin@gmail.com',
            'password'   => password_hash('admin@123', PASSWORD_DEFAULT),
        ];

        $this->db->table('admins')->insert($data);
    }
}
