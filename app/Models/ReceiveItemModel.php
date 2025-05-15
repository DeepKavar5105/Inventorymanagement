<?php

namespace App\Models;

use CodeIgniter\Model;

class ReceiveItemModel extends Model
{
    protected $table = 'transfersitems';
    protected $primaryKey = 'transfer_item_id';

    protected $useSoftDeletes = true;
    protected $deletedField  = 'deleted_at';

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $allowedFields = [
        'transfer_item_id',
        'transferId',
        'productId',
        'transferQuantity',
        'notes',
        'receivedMessage',
        'status',
        'created_By',
        'updated_By',
        'deleted_By'
    ];

    protected $returnType = 'array';

    public function getReceiveItemData()
    {
        return $this->select('transfersitems.*, p.productName as productName, t.specialNotes as note')
            ->join('products p', 'p.product_id = transfersitems.productId')
            ->join('transfers t', 't.transfers_id = transfersitems.transferId')
            ->where('transfersitems.deleted_at', null) 
            ->findAll();
    }

  
    public function getTransferByStoreId()
    {
        return $this->db->table('transfers')
            ->select('transfers.*, CONCAT("Transfer #", transfers_id) as transfer_label')
            ->where('deleted_at', null) 
            ->get()
            ->getResultArray();
    }

   
    public function markAsReceived($transferItemId)
    {
        return $this->where('transfer_item_id', $transferItemId)
            ->set([
                'status' => 'received',
                'updated_at' => date('Y-m-d H:i:s',time())
            ])
            ->update();
    }
}
