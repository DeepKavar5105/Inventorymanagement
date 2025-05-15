<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Models\StoreModel;
use CodeIgniter\Controller;
use App\Libraries\CommonService;

class ProductsController extends BaseController
{
    protected $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    public function productView()
    {
        return view('products/products');
    }

    public function getProductData()
    {
        helper('access');
        $productModel = new ProductModel();
        $product = $productModel->getAllProductWithStore();

        foreach ($product as &$row) {
            $row['role_id'] = $row['product_id'];
            $row['action'] = get_permission_buttons($row);
        }

        return $this->response->setJSON(['data' => $product]);
    }


    public function addProductForm($id = null)
    {
        $data = [];

        $storeModel = new StoreModel();
        $categoryModel = new CategoryModel();
        $productModel = new ProductModel();
        $data['stores'] = $storeModel->findAll();
        $data['categories'] = $categoryModel->findAll();
        $data['products'] = $productModel->findAll();

        if ($id !== null) {
            $product = $this->productModel->find($id);
            if ($product) {
                $data['product'] = $product;
            } else {
                return redirect()->to('products')->with('error', 'Product not found.');
            }
        }

        return view('products/addProduct', $data);
    }

    public function addProductData()
    {
        helper('form');

        $rules = [
            'storeId' => [
                'label' => 'Store',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Store selection is required.'
                ]
            ],
            'categoryId' => [
                'label' => 'Category',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Category selection is required.'
                ]
            ],
            'productName' => [
                'label' => 'Product Name',
                'rules' => 'required|max_length[50]',
                'errors' => [
                    'required'    => 'Product name is required.',
                    'max_length'  => 'Product name cannot exceed 50 characters.'
                ]
            ],
            'sku' => [
                'label' => 'SKU',
                'rules' => 'required',
                'errors' => [
                    'required' => 'SKU is required.'
                ]
            ],
            'barcode' => [
                'label' => 'Barcode',
                'rules' => 'required|numeric|min_length[6]|max_length[15]|is_unique[products.barcode]',
                'errors' => [
                    'required'    => 'Barcode is required.',
                    'numeric'     => 'Barcode must be a number.',
                    'min_length'  => 'Barcode must be at least 6 digits.',
                    'max_length'  => 'Barcode cannot exceed 15 digits.',
                    'is_unique'   => 'Barcode must be unique.'
                ]
            ],
            'quantity' => [
                'label' => 'Quantity',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Quantity is required.'
                ]
            ],
            'productImage' => [
                'label' => 'Product Image',
                'rules' => 'uploaded[productImage]|max_size[productImage,2048]|is_image[productImage]|mime_in[productImage,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Product image is required.',
                    'max_size' => 'Product image must not exceed 2MB.',
                    'is_image' => 'Uploaded file must be an image.',
                    'mime_in'  => 'Only JPG, JPEG, or PNG formats are allowed.'
                ]
            ],
            'product_status' => [
                'label' => 'Product Status',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Product status is required.'
                ]
            ]
        ];


        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        $file = $this->request->getFile('productImage');
        $newName = "product.jpg";

        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads/product', $newName);
        }

        $data = [
            'storeId' => $this->request->getPost('storeId'),
            'categoryId' => $this->request->getPost('categoryId'),
            'productName' => $this->request->getPost('productName'),
            'sku' => $this->request->getPost('sku'),
            'barcode' => $this->request->getPost('barcode'),
            'quantity' => $this->request->getPost('quantity'),
            'productImage' => $newName,
            'status' => $this->request->getPost('product_status')
        ];

        $productModel = new ProductModel();
        if ($productModel->insert($data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Product added successfully.',
                'redirect' => base_url('products') // optional
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'errors' => ['db_error' => 'Database error occurred.']
            ]);
        }
    }


    public function getProductDataById($product_id)
    {
        $data = $this->productModel->find($product_id);
        return json_encode($data);
    }

  public function updateProductData($productId)
{
    helper(['form']);

    $rules = [
        'productName' => [
            'label' => 'Product Name',
            'rules' => 'required|max_length[50]',
            'errors' => [
                'required' => 'Product name is required.',
                'max_length' => 'Product name cannot exceed 50 characters.'
            ]
        ],
        'barcode' => [
            'label' => 'Barcode',
            'rules' => 'required|numeric|min_length[6]|max_length[15]',
            'errors' => [
                'required' => 'Barcode is required.',
                'numeric' => 'Barcode must be a number.',
                'min_length' => 'Barcode must be at least 6 digits.',
                'max_length' => 'Barcode cannot exceed 15 digits.'
            ]
        ],
        'productImage' => [
            'label' => 'Product Image',
            'rules' => 'if_exist|max_size[productImage,2048]|is_image[productImage]|mime_in[productImage,image/jpg,image/jpeg,image/png]',
            'errors' => [
                'max_size' => 'Product image must not exceed 2MB.',
                'is_image' => 'Uploaded file must be an image.',
                'mime_in'  => 'Only JPG, JPEG, or PNG formats are allowed.'
            ]
        ]
    ];

    if (!$this->validate($rules)) {
        return $this->response->setJSON([
            'success' => false,
            'errors' => $this->validator->getErrors()
        ]);
    }

    $productModel = new \App\Models\ProductModel();

   
    $productData = $productModel->find($productId);
    if (!$productData) {
        return $this->response->setJSON([
            'success' => false,
            'errors' => ['general' => 'Product not found.']
        ]);
    }

    $barcode = $this->request->getPost('barcode');
    $existingProduct = $productModel
        ->where('barcode', $barcode)
        ->where('product_id !=', $productId)
        ->first();

    if ($existingProduct) {
        return $this->response->setJSON([
            'success' => false,
            'errors' => ['barcode' => 'Barcode must be unique for all other products.']
        ]);
    }

    $productImage = $this->request->getFile('productImage');
    $newName = null;

    if ($productImage && $productImage->isValid() && !$productImage->hasMoved()) {
        $newName = $productImage->getRandomName();
        $productImage->move('uploads/product', $newName);
    }

    $data = [
        'productName' => $this->request->getPost('productName'),
        'sku'         => $this->request->getPost('sku'),
        'barcode'     => $barcode,
        'quantity'    => $this->request->getPost('quantity'),
        'status'      => $this->request->getPost('product_status'),
        'updated_By'  => session()->get('user_id')
    ];

    if ($newName) {
        $data['productImage'] = $newName;
    }

    if ($productModel->update($productId, $data)) {
        return $this->response->setJSON(['success' => true]);
    } else {
        return $this->response->setJSON([
            'success' => false,
            'errors' => ['general' => 'Product update failed.']
        ]);
    }
}


 public function deleteProductData()
    {
        $productId = $this->request->getPost('productId');
        $userId = session()->get('id');

        if (!$productId) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'product ID is required.'
            ]);
        }
        $service = new CommonService();
        $deleted = $service->softDelete('products','product_id',$productId, $userId);

        if (!$deleted) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to delete product.'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'product deleted successfully!'
        ]);
    }

}
