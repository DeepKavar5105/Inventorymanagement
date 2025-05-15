<?php

namespace App\Models;
use CodeIgniter\Model;

class storeWiseProductModel extends Model
{
    protected $table = 'productsimages';
    protected $primaryKey = 'product_image_id';
    protected $allowedFields = ['storeId','productId','availableQuantity','blockedQuantity','status'];
    protected $returnType = 'array';


    public function getStoreWiseProduct(){
        return $this->select('s.store_id, s.name, p.product_id, p.productName, productsimages.*')
        ->join('stores s', 'productsimages.storeId  = s.store_id')
        ->join('products p', 'productsimages.productId = p.product_id')
        ->findAll();
    }
}
?>
