<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class StoreModel extends Model
{
    protected $table = 'stores';
    protected $primaryKey = 'store_id';
    protected $allowedFields = [
        'name', 'contactNumber', 'email', 'password',  
        'address', 'status','deleted_by', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

     public function getstoredata()
    {
         return $this->where('deleted_at', null)->findAll();
    }

    public function getAllStoreNames()
    {
        return $this->select('store_id, name')->findAll();
    }

    public function deleteMultipleStores(array $store_ids)
    {
        return $this->whereIn('store_id', $store_ids)->delete();
    }
}
