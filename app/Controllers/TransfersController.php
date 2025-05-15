<?php

namespace App\Controllers;

use App\Models\ProductImageModel;
use App\Models\TransfersModel;
use CodeIgniter\CLI\Console;
use CodeIgniter\Validation\StrictRules\Rules;
use App\Libraries\CommonService;

class TransfersController extends BaseController
{
    protected $transfersModel;
    protected $ProductImageModel;
    protected $productModel;

    public function __construct()
    {
        $this->transfersModel = new TransfersModel();
        $this->productModel = new \App\Models\ProductModel();
        $this->transfersModel = new TransfersModel();
        $this->ProductImageModel = new \App\Models\ProductImageModel();
        $this->transfersModel = new TransfersModel();
    }

    public function transfers()
    {
        return view('transfers/transfers');
    }

    public function addTransfersFormOrSearch()
    {
        $fromStoreId = $this->request->getPost('form_store_id');
        $storeModel = new \App\Models\StoreModel();
        $data['stores'] = $storeModel->findAll();
        $productModel = new \App\Models\ProductModel();
        $data['products'] = $productModel->where('storeId', $fromStoreId)->findAll();
        return view('transfers/addtransfers', $data);
    }


    public function checkProductAndQuantity()
    {
        $productId = $this->request->getPost('product_id');
        $fromStoreId = $this->request->getPost('form_store_id');
        $toStoreId = $this->request->getPost('to_store_id');

        if (!$productId || !$fromStoreId || !$toStoreId) {
            return $this->response->setJSON([
                'exists' => false,
                'available_quantity' => 0,
                'error' => 'Missing required parameters.'
            ]);
        }

        $productModel = new \App\Models\ProductModel();
        $match = $productModel->getProductName($productId, $fromStoreId, $toStoreId);
        // print_r($match);die;
        $productName = $match['productName'];
        $exists = $match ? true : false;
        $row = $productModel
            ->where('product_id', $productId)
            ->where('storeId', $fromStoreId)
            ->first();

        $availableQuantity = $row['quantity'] ?? 0;

        return $this->response->setJSON([
            'exists' => $exists,
            'available_quantity' => $availableQuantity,
            'product_id' => $productName
        ]);
    }
    public function getProductsByStore()
    {
        $storeId = $this->request->getPost('store_id');
        $productModel = new \App\Models\ProductModel();

        $products = $productModel->where('storeId', $storeId)->findAll();

        return $this->response->setJSON($products);
    }

    public function getTransfersData()
    {
        helper('access');
        $transfersModel = new TransfersModel();
        $transfer = $transfersModel->getAllTransferWithStore();
        foreach ($transfer as &$row) {
            $row['role_id'] = $row['transfers_id'];
            $row['action'] = get_permission_buttons($row);
        }
        return $this->response->setJSON(['data' => $transfer]);
    }

    public function processTransfer()
    {
        $input = $this->request->getJSON(true);

        $fromStoreId = $input['fromStoreId'] ?? null;
        $toStoreId = $input['toStoreId'] ?? null;
        $status = $input['status'] ?? 'pending';
        $notes = $input['specialNotes'] ?? null;
        $products = $input['products'] ?? [];

        if ($fromStoreId == $toStoreId) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'From Store and To Store cannot be the same.'
            ]);
        }

        if (empty($products)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'No products selected for transfer.'
            ]);
        }

        $transferModel = new \App\Models\TransfersModel();
        $receiveItemsModel = new \App\Models\ReceiveItemModel();
        $db = \Config\Database::connect();

        try {
            $db->transStart(false);
            $transferData = [
                'fromStoreId'   => $fromStoreId,
                'toStoreId'     => $toStoreId,
                'specialNotes'  => $notes,
                'status'        => $status,
                'created_at'    => date('Y-m-d H:i:s', time()),
                'created_By'    => session()->get('id'),
            ];
            $transferId = $transferModel->insert($transferData);

            if (!$transferId) {
                $db->transRollback();
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Failed to insert transfer data.'
                ]);
            }

            $transferItemData = [];
            foreach ($products as $product) {
                $productId = $product['product_id'] ?? null;
                $quantity = $product['quantity'] ?? 0;
                $availableQuantity = $product['availableQuantity'] ?? 0;
                if (!$productId || $quantity <= 0) continue;

                $transferItemData[] = [
                    'transferId'        => $transferId,
                    'productId'         => $productId,
                    'transferQuantity'  => $quantity,
                    'created_at'        => date('Y-m-d H:i:s', time()),
                    'created_By'        => session()->get('id'),
                ];


                $productBuilder = $db->table('products');
                $productRow = $productBuilder->where('product_id', $productId)->get()->getRow();
                if (!$product || $availableQuantity < $quantity) {
                    $db->transRollback();
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'Insufficient stock for product ID: ' . $productId
                    ]);
                }

                $productBuilder->where([
                    'product_id' => $productId
                ])->update([
                    'quantity' =>  $availableQuantity -  $quantity,
                    'blocked_quantity'   => ($productRow->blocked_quantity ?? 0) +  $quantity
                ]);
            }

            if (empty($transferItemData)) {
                $db->transRollback();
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'No valid products to insert.'
                ]);
            }

            $receiveItemsModel->insertBatch($transferItemData);
            $db->transComplete();

            if ($db->transStatus() === false) {
                $db->transRollback();
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Database transaction failed.'
                ]);
            }

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Transfer processed successfully!'
            ]);
        } catch (\Exception $e) {
            $db->transRollback();
            return $this->response->setJSON([
                'status' => 'error',
                'line' => $e->getLine(),
                'message' => $e->getMessage()
            ]);
        }
    }

    //For edit data showing
    public function getTransfersDataById($id)
    {
        $data = $this->transfersModel->find($id);
        return json_encode($data);
    }

     public function deleteTransferProduct()
    {
        $transferId = $this->request->getPost('transfers_id');
        $userId = session()->get('id');

        if (!$transferId) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'transfer ID is required.'
            ]);
        }
        $service = new CommonService();
        $deleted = $service->softDelete('transfers','transfers_id',$transferId, $userId);

        if (!$deleted) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to delete transfer record.'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'transfer record deleted successfully!'
        ]);
    }
}
