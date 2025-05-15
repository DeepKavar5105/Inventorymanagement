<?php

namespace App\Models;

use CodeIgniter\Model;

class PermissionModel extends Model
{
    protected $table = 'permissions';
    protected $primaryKey = 'permission_id';
    protected $allowedFields = [
        'roleId',
        'moduleName',
        'viewAccess',
        'addAccess',
        'editAccess',
        'deleteAccess',
        'importAccess',
        'exportAccess',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    

    // Remove employee join since you removed that field
    public function getFullPermissionData()
    {
        return $this->select('permissions.*, r.name as role_name')
            ->join('roles r', 'r.role_id = permissions.roleId', 'left')
            ->findAll();
    }

    public function getPermissionsByRoleId($roleId)
    {
        return $this->db->table('permissions')
        ->select('permission_id, moduleName, viewAccess, addAccess, editAccess, deleteAccess, importAccess, exportAccess')
        ->where('roleId', $roleId)
        ->get()
        ->getResultArray();
    
    }

    public function getPermissionsWithRole()
    {
        return $this->select('r.role_id, r.name, permissions.*')
            ->join('roles r', 'permissions.roleId = r.role_id')
            ->findAll();    
    }

    // Delete single
    public function deletePermission($permission_id)
    {
        return $this->where('permission_id', $permission_id)->delete();
    }

    // Delete multiple
    public function deletePermissions($permission_ids)
    {
        return $this->whereIn('permission_id', $permission_ids)->delete();
    }
}








