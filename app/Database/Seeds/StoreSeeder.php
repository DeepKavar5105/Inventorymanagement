<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class StoreSeeder extends Seeder
{
    public function run()
    {
        $stores = [
            [
                'name'          => 'Moon Computer',
                'contactNumber' => '9876543210',
                'email'         => 'moon@gmail.com',
                'password'      => password_hash('deep@123', PASSWORD_DEFAULT),
                'phone'         => '1234567890',
                'address'       => '123 Silicon Valley',
                'status'        => '0',
            ],
            [
                'name'          => 'Dell Exclusive',
                'contactNumber' => '9876543211',
                'email'         => 'dell@gmaile.com',
                'password'      =>  password_hash('deep@123', PASSWORD_DEFAULT),
                'phone'         => '1234567891',
                'address'       => '456 Library Lane',
                'status'        => '1',
            ],
            [
                'name'          => 'deep computer',
                'contactNumber' => '9876543212',
                'email'         => 'deep@gmail.com',
                'password'      =>  password_hash('deep@123', PASSWORD_DEFAULT),
                'phone'         => '1234567892',
                'address'       => '789 Trendy Street',
                'status'        => '0',
            ],
            [
                'name'          => 'gaurav computer',
                'contactNumber' => '9876543213',
                'email'         => 'gaurav@gmail.com',
                'password'      =>  password_hash('deep@123', PASSWORD_DEFAULT),
                'phone'         => '1234567893',
                'address'       => '321 Fun Avenue',
                'status'        => '1',
            ],
            [
                'name'          => 'Planet computer',
                'contactNumber' => '9876543214',
                'email'         => 'Planet@gmail.com',
                'password'      =>  password_hash('deep@123', PASSWORD_DEFAULT),
                'phone'         => '1234567894',
                'address'       => '654 Cozy Blvd',
                'status'        => '0',
            ],
        ];
        $builder = $this->db->table('stores');

        foreach ($stores as $store) {
            $builder->insert(array_merge($store, [
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
                'deleted_at' => null,
            ]));
        }
    }
}
?>