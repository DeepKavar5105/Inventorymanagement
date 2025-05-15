<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class RoleModel extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'role_id';
    protected $allowedFields = ['name', 'status', 'deleted_by', 'deleted_at'];

    protected $useTimestamps    = true;
    protected $useSoftDeletes   = true;

    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    protected $deletedField     = 'deleted_at';

    public function getroledata()
    {
         return $this->where('deleted_at', null)->findAll();
    }

    public function getcategoryStore()
    {
        return $this->select('categorys.*,s.store_id as store_id, s.name AS store_name')
            ->join('stores s', 's.store_id = categorys.storeId', 'left')
            ->findAll();
    }

    public function deleteAllByRollNos($role_ids)
    {
        return $this->db->table($this->table)->whereIn('role_id', $role_ids)->delete();
    }
}
