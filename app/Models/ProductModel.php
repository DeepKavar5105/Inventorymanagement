<?php
namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'product_id';
    protected $useSoftDeletes = true; 
    protected $allowedFields = [
        'storeId', 'categoryId', 'productName', 'sku', 'barcode',
        'quantity', 'productImage', 'status',
        'created_By', 'updated_By', 'deleted_by'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at'; 
    protected $returnType = 'array';

    public function getAllProductWithStore()
    {
        return $this->select('products.*, s.name AS name, c.catName AS catName')
            ->join('stores s', 's.store_id = products.storeId', 'left')
            ->join('categorys c', 'c.cat_id = products.categoryId', 'left')
            ->where('products.deleted_at', null)
            ->findAll();
    }

    public function getProductName($fromProductId, $fromStoreId, $toStoreId)
    {
        return $this->select('p.product_id as toProductId, p.productName')
            ->join('products p', 'p.productName = products.productName AND p.storeId = ' . $toStoreId)
            ->where('products.storeId', $fromStoreId)
            ->where('products.product_id', $fromProductId)
            ->first();
    }
}
?>