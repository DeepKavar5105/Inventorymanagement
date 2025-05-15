<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductImageModel extends Model
{
    protected $table = 'productsImages';
    protected $primaryKey = 'product_image_id';
    protected $allowedFields = [
        'storeId', 'productId', 'availableQuantity', 'blockedQuantity',
        'status', 'created_at', 'updated_at', 'deleted_at'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    public function getAvailableStock($storeId, $productId)
    {
        return $this->where([
            'storeId'   => $storeId,
            'productId' => $productId,
        ])->first();
    }

    public function updateStock($storeId, $productId, $quantity)
    {
        $stock = $this->getAvailableStock($storeId, $productId);
        if ($stock) {
            $stock['availableQuantity'] -= $quantity;
            return $this->update($stock['product_image_id'], $stock);
        }
        return false;
    }
}
