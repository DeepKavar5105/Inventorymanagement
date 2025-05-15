<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Libraries\CommonService;
use CodeIgniter\I18n\Time;

class CategoryController extends BaseController
{
    protected $CategoryModel;

    public function __construct()
    {
        $this->CategoryModel = new CategoryModel();
    }
    public function category()
    {
        return view('category/category');
    }

    public function getcategoryData()
    {
        helper('access');
        $CategoryModel = new CategoryModel();
        $category = $CategoryModel->getcategoryStore();
        foreach ($category as &$row) {
            $row['role_id'] = $row['cat_id'];
            $row['action'] = get_permission_buttons($row);
        }
        return $this->response->setJSON(['data' => $category]);
    }

    public function addCategoryForm($id = null)
    {
        $storeModel = new \App\Models\StoreModel();
        $data['store'] = $storeModel->findAll();

        if ($id !== null) {
            $category = $this->CategoryModel->find($id);
            if ($category) {
                $data['category'] = $category;
            } else {
                return redirect()->to('/category')->with('error', 'Category not found.');
            }
        }

        return view('category/addCategory', $data);
    }



    public function addCategoryData()
    {
        helper('form');

        $rules = [
            'storeId' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Please select a store.'
                ]
            ],
            'catName' => [
                'rules' => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required'    => 'Category name is required.',
                    'min_length'  => 'Category name must be at least 3 characters long.',
                    'max_length'  => 'Category name cannot exceed 100 characters.'
                ]
            ],
            'status' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Status is required.'
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        $storeId = $this->request->getPost('storeId');
        $catName = $this->request->getPost('catName');
        $status  = $this->request->getPost('status');

        $existing = $this->CategoryModel
            ->where('storeId', $storeId)
            ->where('catName', $catName)
            ->where('deleted_at', null)
            ->first();

        if ($existing) {
            return $this->response->setJSON([
                'success' => false,
                'errors' => ['catName' => 'This category already exists for the selected store.']
            ]);
        }

        $data = [
            'storeId' => $storeId,
            'catName' => $catName,
            'status'  => $status,
        ];

        $db = \Config\Database::connect();
        $db->transStart();

        $inserted = $this->CategoryModel->insert($data);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Transaction failed. Category not added.'
            ]);
        }

        if ($inserted) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Category added successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to add category.'
            ]);
        }
    }



    public function updateCategoryData()
    {
        helper('form');

        $rules = [
            'catName' => [
                'rules' => 'required|min_length[2]|max_length[100]',
                'errors' => [
                    'required'    => 'Category name is required.',
                    'min_length'  => 'Category name must be at least 2 characters.',
                    'max_length'  => 'Category name cannot exceed 100 characters.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        $categoryId = $this->request->getPost('cat_id');

        if (!$categoryId) {
            return $this->response->setJSON([
                'success' => false,
                'errors' => ['cat_id' => 'Missing category ID.']
            ]);
        }

        $data = [
            'storeId'    => $this->request->getPost('storeId'),
            'catName'    => $this->request->getPost('catName'),
            'status'     => $this->request->getPost('status'),
            'updated_By' => $this->request->getPost('updated_By')
        ];

        if ($this->CategoryModel->update($categoryId, $data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Category updated successfully.'
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'errors' => ['db' => 'Failed to update category.']
        ]);
    }


    public function deleteCategoryData()
    {
        $catId = $this->request->getPost('Category_id');
        $userId = session()->get('id');

        if (!$catId) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Category ID is required.'
            ]);
        }

        $db = \Config\Database::connect();
        $db->transStart();
        $service = new CommonService();
        $updated = $service->softDelete('categorys','cat_id',$catId, $userId);

        $db->transComplete();

        if ($db->transStatus() === false || !$updated) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to delete category.'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Category deleted successfully!'
        ]);
    }


    public function getcategoryDataById($id)
    {
        $category = $this->CategoryModel->find($id);
        return $this->response->setJSON($category);
    }


    // public function deleteMultipleData()
    // {
    //     $category_ids = $this->request->getPost('category_ids');

    //     if (!empty($category_ids) && is_array($category_ids)) {
    //         $model = new \App\Models\CategoryModel();

    //         // Try/catch for better error reporting
    //         try {
    //             $model->deleteAllByCategoryIds($category_ids);
    //             return $this->response->setJSON([
    //                 'status' => 'success',
    //                 'message' => 'Categories deleted successfully.'
    //             ]);
    //         } catch (\Exception $e) {
    //             log_message('error', 'Delete error: ' . $e->getMessage());
    //             return $this->response->setJSON([
    //                 'status' => 'error',
    //                 'message' => 'Deletion failed. Please check server logs.'
    //             ]);
    //         }
    //     }

    //     return $this->response->setJSON([
    //         'status' => 'error',
    //         'message' => 'No valid category IDs received.'
    //     ]);
    // }
}
