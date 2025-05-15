<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        // Step 1: Create roles
        $roles = [
            ['name' => 'Admin', 'status' => 1],
            ['name' => 'Manager', 'status' => 1],
            ['name' => 'Staff', 'status' => 1],
        ];

        $roleIds = [];
        foreach ($roles as $role) {
            $db->table('roles')->insert($role);
            $roleIds[] = $db->insertID();
        }

        // Step 2: Create employees
        $employees = [
            [
                'activeStoreId' => 1,
                'accessStoreId' => 1,
                'empname'       => 'John Doe',
                'email'         => 'john@example.com',
                'password'      => password_hash('123456', PASSWORD_DEFAULT),
                'mobile'        => '1234567890',
                'status'        => 1,
                'created_By'    => 1,
                'updated_By'    => 1,
                'deleted_By'    => 0,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'activeStoreId' => 1,
                'accessStoreId' => 1,
                'empname'       => 'Jane Smith',
                'email'         => 'jane@example.com',
                'password'      => password_hash('123456', PASSWORD_DEFAULT),
                'mobile'        => '9876543210',
                'status'        => 1,
                'created_By'    => 1,
                'updated_By'    => 1,
                'deleted_By'    => 0,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
        ];

        $employeeIds = [];
        foreach ($employees as $emp) {
            $db->table('employees')->insert($emp);
            $employeeIds[] = $db->insertID();
        }

        // Step 3: Define modules
        $modules = [
            'Role',
            'Store',
            'Permission',
            'Employee',
            'Category',
            'Product',
            'StorewideProduct',
            'Transfer',
            'TransferItem',
            'InventoryLog',
        ];

        // Step 4: Assign permissions
        foreach ($employeeIds as $employeeId) {
            foreach ($roleIds as $roleId) {
                foreach ($modules as $module) {
                    $db->table('permissions')->insert([
                        'employeeId'   => $employeeId,
                        'roleId'       => $roleId,
                        'moduleName'   => $module,
                        'addAccess'    => rand(0, 1),
                        'editAccess'   => rand(0, 1),
                        'deleteAccess' => rand(0, 1),
                        'created_at'   => date('Y-m-d H:i:s'),
                        'updated_at'   => date('Y-m-d H:i:s'),
                    ]);
                }
            }
        }
    }
}
