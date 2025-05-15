<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermissionModel;
use App\Models\RoleModel;
use App\Models\EmployeeModel;
use App\Libraries\CommonService;

class RoleController extends BaseController
{
    protected $roleModel;
    protected $permissionModel;


    public function __construct()
    {
        $this->roleModel = new RoleModel();
        $this->permissionModel = new PermissionModel();
    }

    public function role()
    {
        return view('role/role');
    }

    public function getRoleData()
    {
        $roleModel = new RoleModel();
        $roles = $roleModel->getroledata();
        // foreach ($roles as &$row) {
        //     $row['action'] = $this->Permission($row); 
        // }
        return $this->response->setJSON(['data' => $roles]);
    }



    public function addroleForm()
    {
        $rolemodel = new RoleModel();
        $data["roles"] = $rolemodel->findall();
        return view('role/addrole', $data);
    }


    public function getPermission()
    {
        $permissionModel = new \App\Models\PermissionModel();
        $data = $permissionModel->findAll();

        return $this->response->setJSON([
            'data' => $data
        ]);
    }


    public function delete()
    {
        $roleId = $this->request->getPost('roleid');
        $userId = session()->get('id');

        if (!$roleId) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Role ID is required.'
            ]);
        }
        $service = new CommonService();
        $deleted = $service->softDelete('roles','role_id',$roleId, $userId);

        if (!$deleted) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to delete role.'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Role deleted successfully!'
        ]);
    }


    // public function deleteMultiple()
    // {
    //     $roleIds = $this->request->getPost('roleIds');
    //     if (!empty($roleIds)) {
    //         $this->roleModel->whereIn('role_id', $roleIds)->delete();
    //         return $this->response->setJSON(['status' => 'success', 'message' => 'Roles deleted successfully']);
    //     }
    //     return $this->response->setJSON(['status' => 'error', 'message' => 'No roles selected']);
    // }

    public function getPermissionData()
    {
        helper(['form']);

        $requestData = $this->request->getJSON(true);


        if (
            !isset($requestData['name'], $requestData['status'], $requestData['permissions']) ||
            !is_array($requestData['permissions'])
        ) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'error',
                'message' => 'Invalid input structure.'
            ]);
        }
        $validationRules = [
            'name'   => 'required|is_unique[roles.name]',
            'status' => 'required|in_list[0,1]'
        ];

        if (!$this->validateData($requestData, $validationRules)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'error',
                'errors' => $this->validator->getErrors()
            ]);
        }

        try {

            $roleId = $this->roleModel->insert([
                'name'   => $requestData['name'],
                'status' => $requestData['status']
            ], true);

            if (!$roleId) {
                return $this->response->setStatusCode(500)->setJSON([
                    'status' => 'error',
                    'message' => 'Failed to insert role.'
                ]);
            }


            $permissions = [];
            foreach ($requestData['permissions'] as $perm) {
                $permissions[] = [
                    'roleId'        => $roleId,
                    'moduleName'    => $perm['module'] ?? '',
                    'viewAccess'    => $perm['view'] ?? 0,
                    'addAccess'     => $perm['add'] ?? 0,
                    'editAccess'    => $perm['edit'] ?? 0,
                    'deleteAccess'  => $perm['delete'] ?? 0,
                    'importAccess'  => $perm['importAccess'] ?? 0,
                    'exportAccess'  => $perm['exportAccess'] ?? 0,
                    'created_at'    => date('Y-m-d H:i:s', time()),
                    'updated_at'    => date('Y-m-d H:i:s', time())
                ];
            }


            $db = db_connect();
            $builder = $db->table('permissions');
            $inserted = $builder->insertBatch($permissions);

            if (!$inserted) {
                return $this->response->setStatusCode(500)->setJSON([
                    'status' => 'error',
                    'message' => 'Failed to insert permissions.'
                ]);
            }

            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Role and permissions added successfully.'
            ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'message' => 'An error occurred: ' . $e->getMessage()
            ]);
        }
    }

    public function editRoleForm($id)
    {
        return view('role/editrole', ['roleId' => $id]);
    }

    public function getEditRoleData($id)
    {
        $roleModel = new \App\Models\RoleModel();
        $permissionModel = new \App\Models\PermissionModel();

        $role = $roleModel->find($id);
        $permissions = $permissionModel->getPermissionsByRoleId($id);

        if ($role) {
            return $this->response->setJSON([
                'success' => true,
                'data' => [
                    'name' => $role['name'],
                    'status' => $role['status'],
                    'permissions' => $permissions
                ]
            ]);
        }

        return $this->response->setJSON(['success' => false]);
    }
    public function updatePermissions()
    {
        helper(['form']);

        $roleId = $this->request->getPost('editRoleId');
        $editName = $this->request->getPost('edit_name');
        $editStatus = $this->request->getPost('edit_status');
        $permissions = $this->request->getPost('permissions');

        // Validate role name uniqueness excluding current role ID
        if ($roleId && $editName) {
            $roleModel = new \App\Models\RoleModel();
            $existingRole = $roleModel->where('name', $editName)
                ->where('role_id !=', $roleId)
                ->first();

            if ($existingRole) {
                return $this->response->setJSON([
                    'success' => false,
                    'errors' => ['edit_name' => 'Role name already exists.']
                ]);
            }
        }

        $errors = [];
        if (!$roleId) {
            $errors['editRoleId'] = 'Role ID is required.';
        }
        if (!$editName) {
            $errors['edit_name'] = 'Role name is required.';
        }
        if ($editStatus === null) {
            $errors['edit_status'] = 'Role status is required.';
        }
        if (!$permissions || !is_array($permissions)) {
            $errors['permissions'] = 'Permissions are required.';
        }

        if (!empty($errors)) {
            return $this->response->setJSON([
                'success' => false,
                'errors' => $errors
            ]);
        }

        $this->roleModel->update($roleId, [
            'name'   => $editName,
            'status' => $editStatus
        ]);

        $permissionModel = new \App\Models\PermissionModel();

        foreach ($permissions as $permissionId => $access) {
            $existing = $permissionModel
                ->where('roleId', $roleId)
                ->where('permission_id', $permissionId)
                ->first();

            $data = [
                'roleId'        => $roleId,
                'permission_id' => $permissionId,
                'viewAccess'    => $access['view'] ?? 0,
                'addAccess'     => $access['add'] ?? 0,
                'editAccess'    => $access['update'] ?? 0,
                'deleteAccess'  => $access['delete'] ?? 0,
                'importAccess'  => $access['importAccess'] ?? 0,
                'exportAccess'  => $access['exportAccess'] ?? 0,
            ];

            if ($existing) {
                $permissionModel->update($existing['permission_id'], $data);
            } else {
                $permissionModel->insert($data);
            }
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Permissions updated successfully.'
        ]);
    }



    public function checkRoleName()
    {
        $roleName = $this->request->getPost('name');
        $roleModel = new RoleModel();

        $role = $roleModel->where('name', $roleName)->first();

        if ($role) {
            return $this->response->setJSON(['exists' => true]);
        }

        return $this->response->setJSON(['exists' => false]);
    }
}
