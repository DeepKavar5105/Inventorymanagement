<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class EmployeeModel extends Model
{
    protected $table            = 'employees';
    protected $primaryKey       = 'emp_id';
    
    protected $allowedFields    = [
        'employee_code',
        'role_id',
        'activeStoreId',
        'accessStoreId',    
        'empname',
        'email',
        'password',
        'mobile',
        'profile',
        'status',
        'created_By',
        'updated_By',
        'deleted_By',
        'deleted_at' 
    ];

    protected $useTimestamps    = true;
    protected $useSoftDeletes   = true;

    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    protected $deletedField     = 'deleted_at';

    public function getFilteredEmployees($start, $length, $name = null, $email = null, $mobile = null, $status = null)
    {
        $builder = $this->builder()
            ->select('employees.*, s.name AS store_name')
            ->join('stores s', 's.store_id = employees.accessStoreId', 'left');

        if (!empty($name)) {
            $builder->like('employees.empname', $name);
        }

        if (!empty($email)) {
            $builder->like('employees.email', $email);
        }

        if (!empty($mobile)) {
            $builder->like('employees.mobile', $mobile);
        }

        if ($status !== null && $status !== '') {
            $builder->where('employees.status', $status);
        }

        $builder->where('employees.deleted_at', null); 
        $builder->limit($length, $start);

        return $builder->get()->getResultArray();
    }

    public function countAllEmployees()
    {
        return $this->where('deleted_at', null)->countAllResults();
    }

   
    public function countFilteredEmployees($name = null, $email = null, $mobile = null, $status = null)
    {
        $builder = $this->builder()
            ->join('stores s', 's.store_id = employees.accessStoreId', 'left');

        if (!empty($name)) {
            $builder->like('employees.empname', $name);
        }

        if (!empty($email)) {
            $builder->like('employees.email', $email);
        }

        if (!empty($mobile)) {
            $builder->like('employees.mobile', $mobile);
        }

        if ($status !== null && $status !== '') {
            $builder->where('employees.status', $status);
        }

        $builder->where('employees.deleted_at', null); //
        return $builder->countAllResults(false);
    }

    public function getAllEmployeesWithStore()
    {
        return $this->select('employees.*, s.name AS name')
            ->join('stores s', 's.store_id = employees.accessStoreId', 'left')
            ->where('employees.deleted_at', null)
            ->findAll();
    }

    // public function deleteAllByEmployeeIds($empIds)
    // {
    //     return $this->whereIn('emp_id', $empIds)->delete();
    // }
}
