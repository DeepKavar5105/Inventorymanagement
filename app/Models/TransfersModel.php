<?php

namespace App\Models;

use CodeIgniter\Model;

class TransfersModel extends Model
{
    protected $table = 'transfers';
    protected $primaryKey = 'transfers_id';
    protected $allowedFields = ['fromStoreId', 'toStoreId','specialNotes', 'productName',  'quantity', 'status', 'created_By', 'updated_By', 'deleted_By'];
    protected $returnType = 'array';

    public function getAllTransferWithStore()
    {
        return $this->select('transfers.*, s1.store_id AS store_id, s1.name AS from_store_name, s2.name AS to_store_name')
            ->join('stores s1', 's1.store_id = transfers.fromStoreId', 'left')
            ->join('stores s2', 's2.store_id = transfers.toStoreId', 'left')
            ->where('transfers.deleted_By', null)
            ->findAll();
    }
  
    public function getTransferByStoreId() {
        return $this->select('transfers.transfers_id, transfers.toStoreId, s.name as name, ti.status as status')
        ->join('stores s', 's.store_id = transfers.toStoreId', 'left')
        ->join('transfersitems ti', 'ti.transferId = transfers.transfers_id', 'left')
        ->findAll();
    }
}