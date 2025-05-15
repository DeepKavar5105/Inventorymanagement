<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DefaultSeeder extends Seeder
{
    public function run()
    {
        // Insert default user

        $data = [
            [
                'name' => 'deep',
                'email' => 'deep@gmail.com',
                'password' => password_hash('deep@123', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s', time()),
            ],
            [
                'name' => 'gaurav',
                'email'    => 'gaurav@gmail.com',
                'password' => password_hash('gaurav@123', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s', time()),
            ],
            [
                'name' => 'admin',
                'email'    => 'admin@gmail.com',
                'password' => password_hash('admin@123', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s', time()),
            ],  
        ];
        $this->db->table('user')->insertBatch($data);
    }
}
