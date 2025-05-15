<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\PermissionModel;
use App\Models\EmployeeModel; // Added import for EmployeeModel
use App\Models\RoleModel;     // Added import for RoleModel

class PermissionController extends Controller
{
    protected $permissionModel;

    public function __construct()
    {
        $this->permissionModel = new PermissionModel();
    }

    public function permission()
    {
        return view('permission/permission');
    }

    // For showing data in datatable
    public function getPermissioaanData()
    {
        $permissions = new PermissionModel();
        $data = $permissions->getFullPermissionData();
        return $this->response->setJSON($data);
    }
    

    // For showing form 
    public function addPermissionForm()
    {
        $permissionModel = new PermissionModel();
        $employeeModel = new EmployeeModel(); // if you have one
        $roleModel = new RoleModel();         // assuming this exists
    
        $data = [
            'permission' => $employeeModel->findAll(),  // for employee_name dropdown
            'role'       => $roleModel->findAll(),      // for role_name dropdown
        ];
    
        return view('permission/addpermission', $data);
    }
    

    // For inserting data
    public function addPermission()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'employee_name'     => 'required',
            'Role_name'         => 'required',
            'per_Name'          => 'required',
            'per_status'        => 'required',
            'per_addAccess'     => 'required',
            'per_editAccess'    => 'required',
            'per_deleteAccess'  => 'required',
        ]);
        
        if (!$validation->run($this->request->getPost())) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'employeeId'   => $this->request->getPost('employee_name'),
            'roleId'       => $this->request->getPost('Role_name'),
            'moduleName'   => $this->request->getPost('per_Name'),
            'status'       => $this->request->getPost('per_status'), // or modelStatus if your DB uses that
            'addAccess'    => $this->request->getPost('per_addAccess'),
            'editAccess'   => $this->request->getPost('per_editAccess'),
            'deleteAccess' => $this->request->getPost('per_deleteAccess')
        ];
        

        if ($this->permissionModel->insert($data)) {
            return redirect()->to('/permission')->with('success', 'Permission added successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to add permission!');
        }
    }


    // for getting data by id
    public function getPermissionDataById($id)
    {
        $data = $this->permissionModel->find($id);
        return $this->response->setJSON($data);
    }

    //for update data
    public function updatePermission()
    {
        helper(['form']);
        $Rules = [
            'employee_name'     => 'required',
            'Role_name'         => 'required',
            'model_Name'        => 'required',
            'model_status'      => 'required',
            'model_updated_By'  => 'required',
            'model_created_By'  => 'required',
            'model_deleted_by'  => 'required',
        ];
    
        if (!$this->validate($Rules)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'error',
                'errors' => $this->validator->getErrors()
            ]);
        }

    
    
        $id = $this->request->getPost('permission_id');
        $data = [
            'employeeId'   => $this->request->getPost('employee_name'),
            'roleId'       => $this->request->getPost('Role_name'),
            'moduleName'   => $this->request->getPost('model_Name'),
            'addAccess'    => $this->request->getPost('model_status'),
            'editAccess'   => $this->request->getPost('model_updated_By'),
            'deleteAccess' => $this->request->getPost('model_created_By')
        ];
    
        if ($this->permissionModel->update($id, $data)) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Update failed - database issue.'
            ]);
        }
    }


    // for delete one record
    public function deletePermission()
    {
        $id = $this->request->getPost('permission_id');
        if ($this->permissionModel->deletePermission($id)) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error']);
        }
    }

    //for delete multiple records
    public function deleteMultiple()
{
    $permission_ids = $this->request->getPost('permission_ids'); 

    if (!empty($permission_ids)) {
        $this->permissionModel->whereIn('permission_id', $permission_ids)->delete();
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Permissions deleted successfully'
        ]);
    }

    return $this->response->setJSON([
        'status' => 'error',
        'message' => 'No permissions selected'
    ]);
}

    
}
