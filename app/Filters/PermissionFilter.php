<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\PermissionModel;
use App\Models\RoleModel;

class PermissionFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $employeeId = $session->get('emp_id');
        $roleId = $session->get('role_id');
        $module = $arguments[0] ?? null;
        $action = $arguments[1] ?? null;

        if (!$module || !$action) {
            return redirect()->to('/unauthorized');
        }

        // Get role name
        $roleModel = new RoleModel();
        $role = $roleModel->find($roleId);
        $roleName = $role['name'] ?? null;

        if (!$roleName) {
            return redirect()->to('/unauthorized');
        }

        // Define access matrix
        $accessMatrix = [
            'add' => ['User', 'Manager', 'Admin'],
            'edit' => ['User', 'Manager', 'Admin'],
            'delete' => ['Admin'],
            'multiDelete' => ['Admin'],
            // Add 'view' or other actions if needed
        ];

        // Check permission against role
        if (isset($accessMatrix[$action]) && !in_array($roleName, $accessMatrix[$action])) {
            return redirect()->to('/unauthorized');
        }

        // Optionally check in permissions table if you want granular control
        $permissionModel = new PermissionModel();
        $permission = $permissionModel
            ->where('employeeId', $employeeId)
            ->where('roleId', $roleId)
            ->where('moduleName', $module)
            ->first();

        if (!$permission || !isset($permission[$action . 'Access']) || $permission[$action . 'Access'] != 1) {
            return redirect()->to('/unauthorized');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nothing after
    }
}
