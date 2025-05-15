<?php
namespace App\Controllers;

use App\Models\StoreWiseProductModel;

class StoreWiseProductController extends BaseController
{
    protected $StoreWiseProductModel;

    public function __construct()
    {
        $this->StoreWiseProductModel = new StoreWiseProductModel();
    }
    public function storeWiseProduct()
    {
        return view('storeWiseProduct/storeWiseProduct');
    }

    public function addStoreWiseProductForm()
    {
        return view('storeWiseProduct/addStoreWiseProduct');
    }

    public function getStoreWiseProductData()
    {
        $storeproduct = $this->StoreWiseProductModel->getStoreWiseProduct(); // use the join method!
        return $this->response->setJSON(['data' => $storeproduct]);
    }
    
     public function deletestorewiseproduct(){
        $productstoreId = $this->request->getPost('productstoreId');
        if ($this->StoreWiseProductModel->delete($productstoreId)) {
            return $this->response->setJSON(body: ['status' => 'success', 'message' => 'deleted successfully!']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to delete.']);
        }
     }
}
?>