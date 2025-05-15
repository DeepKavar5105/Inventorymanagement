<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class CategoryModel extends Model
{
    protected $table            = 'categorys';
    protected $primaryKey       = 'cat_id';
    
    protected $allowedFields    = [
        'storeId', 'catName', 'status', 'created_By', 'updated_By', 'deleted_by', 'deleted_at'
    ];

    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    public function getcategoryStore()
    {
        return $this->select('categorys.*, s.store_id as store_id, s.name AS store_name')
            ->join('stores s', 's.store_id = categorys.storeId', 'left')
            ->where('categorys.deleted_at', null) 
            ->findAll();
    }

   

    // public function deleteAllByCategoryIds($category_ids)
    // {
    //     return $this->whereIn('cat_id', $category_ids)->delete(); 
    // }
}
