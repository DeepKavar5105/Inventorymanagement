<?php

namespace App\Controllers;

use App\Database\Migrations\transferItems;
use App\Models\ProductModel;
use App\Models\ReceiveItemModel;
use App\Models\StoreModel;
use App\Models\TransfersModel;
use App\Libraries\CommonService;

class ReceiveItemsController extends BaseController
{
    protected $receiveItemModel;

    public function __construct()
    {
        $this->receiveItemModel = new ReceiveItemModel();
    }

    public function receive()
    {
        $transferModel = new TransfersModel();
        $storeModel = new StoreModel();
        $data['stores'] = $storeModel->findAll();
        $data['tranfers'] = $transferModel->getTransferByStoreId();
        return view('receiveitem/receiveItem', $data);
    }

    public function getreceiveItemsData()
    {
        helper('access');
        $receiveItemModel = new ReceiveItemModel();
        $receive = $receiveItemModel->getReceiveItemData();
        foreach ($receive as &$row) {
            $row['role_id'] = $row['transfer_item_id'];
            $row['action'] = get_permission_buttons($row);
        }
        return $this->response->setJSON(['data' => $receive]);
    }


    public function goToStore($storeId)
    {
        $productModel = new ProductModel();
        $transferModel = new TransfersModel();
        $storeModel = new StoreModel();
        $receivemodel = new ReceiveItemModel();
        $data['tranfer'] = $transferModel->where('transfers_id', $storeId)->first();
        $data['stores'] = $storeModel->findAll();
        $data['received'] = $receivemodel->where('transferId', $storeId)->findAll();
        $data['product'] = $productModel->findAll();

        return view('receiveitem/select_store', $data);
    }

    public function addreceiveItemsForm($id = null)
    {
        $data = [];
        $model = new ReceiveItemModel();
        $storemodel = new StoreModel();
        $productmodel = new ProductModel();
        if ($id !== null) {

            $data['receive'] = $model->find($id);
            $data['stores'] =  $storemodel->findAll();
            $data['product'] = $productmodel->findAll();
        }

        return view('receiveitem/addreceiveItems', $data);
    }


    public function store()
    {
        $storeId = $this->request->getPost('store_id');
        $productId = $this->request->getPost('product_id');
        $quantity = $this->request->getPost('quantity');

        $trasferModel = new TransfersModel();

        $existing = $trasferModel->where([
            'store_id' => $storeId,
            'product_id' => $productId
        ])->first();

        if ($existing) {
            $trasferModel->update($existing['transfers_id'], [
                'quantity' => $existing['quantity'] + $quantity
            ]);
        } else {
            $trasferModel->insert([
                'store_id' => $storeId,
                'product_id' => $productId,
                'quantity' => $quantity
            ]);
        }
        return $this->response->setJSON(['status' => 'success']);
    }


    public function update()
    {
        $data = $this->request->getPost();
        $receiveId = (int) $data['receiveId'];
        $rquantity = (int) $data['rquantity'];
        $productId = (int) $data['rproduct'];
        $damage = (int) $data['dquantity'];
        $notes = $data['receiveNotes'];
        $status = (int) $data['status'];

        $db = \Config\Database::connect();
        $receiveModel = new \App\Models\ReceiveItemModel();
        $existing = $receiveModel->find($receiveId);

        if (!$existing) {
            return json_encode(['success' => false, 'errors' => ['receiveId' => 'Transfer item not found.']]);
        }

        if ((int)$existing['status'] === 2) {
            return json_encode(['success' => false, 'errors' => ['status' => 'Item already marked as received.']]);
        }

        $transferRow = $db->table('transfersitems ti')
            ->select('t.fromStoreId, t.toStoreId')
            ->join('transfers t', 't.transfers_id = ti.transferId')
            ->where('ti.transfer_item_id', $receiveId)
            ->get()
            ->getRow();

        if (!$transferRow) {
            return json_encode(['success' => false, 'errors' => ['transfer' => 'Transfer data not found.']]);
        }

        $fromStoreId = $transferRow->fromStoreId;
        $toStoreid = $transferRow->toStoreId;

        $productmodel = new \App\Models\ProductModel();
        $match = $productmodel->getProductName($productId, $fromStoreId, $toStoreid);

        if (!$match || !isset($match['toProductId'])) {
            return json_encode(['success' => false, 'errors' => ['product' => 'Product mapping not found.']]);
        }

        $productid = $match['toProductId'];

        $productBuilder = $db->table('products');
        $fromProduct = $productBuilder->where('product_id', $productId)
            ->where('storeId', $fromStoreId)
            ->get()
            ->getRow();

        if (!$fromProduct) {
            return json_encode(['success' => false, 'errors' => ['product' => 'From store product not found.']]);
        }

        $toProduct = $productBuilder->where('product_id', $productid)
            ->where('storeId', $toStoreid)
            ->get()
            ->getRow();

        if (!$toProduct) {
            return json_encode(['success' => false, 'errors' => ['product' => 'To store product not found.']]);
        }

        $fromBlockedBefore = (int)$fromProduct->blocked_quantity;
        $toQtyBefore = (int)$toProduct->quantity;

        $receiveModel->update($receiveId, [
            'receivedMessage' => $notes,
            'status' => $status,
        ]);

        $productBuilder->where('product_id', $productId)
            ->where('storeId', $fromStoreId)
            ->update([
                'blocked_quantity' => max(0, $fromBlockedBefore - $rquantity),
            ]);

        $productBuilder->where('product_id', $productid)
            ->where('storeId', $toStoreid)
            ->update([
                'quantity' => $toQtyBefore + $rquantity - $damage,
                'damage_quantity'  => $damage,
            ]);

        $logBuilder = $db->table('inventorylog');
        $logBuilder->insert([
            'storeId'              => $toStoreid,
            'productId'            => $productId,
            'message'              => $notes,
            'quantityBeforeChange' => $toQtyBefore,
            'quantityAfterChange'  => $toQtyBefore + $rquantity,
            'actualQuantity'       => $rquantity,
            'created_at'           => date('Y-m-d H:i:s', time()),
        ]);

        return json_encode(['success' => true]);
    }

    public function delete()
    {
        $receiveId = $this->request->getPost('receiveId');
        $userId = session()->get('id');

        if (!$receiveId) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Receive item ID is required.'
            ]);
        }
        $service = new CommonService();
        $deleted = $service->softDelete('transfersitems', 'transfer_item_id', $receiveId, $userId);

        if (!$deleted) { Github5105@Pass
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to delete Receive item.'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Receive item deleted successfully!'
        ]);
    }
}
