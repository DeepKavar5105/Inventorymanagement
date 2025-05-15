<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\CommonService;
use App\Models\StoreModel;
use App\Models\RoleModel;

class StoreController extends BaseController
{
    protected $StoreModel;
    public function __construct()
    {
        $this->StoreModel = new StoreModel();
    }
    public function store()
    {
        return view('store/store');
    }

    public function getStoreData()
    {
        helper('access');
        $row = [];
        $stores = $this->StoreModel->getstoredata();
        foreach ($stores as &$row) {
            $row['role_id'] = $row['store_id'];
            $row['action'] = get_permission_buttons($row);
        }
        return $this->response->setJSON(['data' => $stores]);
    }


    public function addStoreForm($id = null)
    {
        $store = null;
        if ($id) {
            $store = $this->StoreModel->find($id);
        }

        return view('store/addstore', [
            'store' => $store
        ]);
    }

    public function addStore()
    {
        helper(['form']);

        $rules = [
            'name' => [
                'label' => 'Name',
                'rules' => 'required|min_length[3]|max_length[50]',
                'errors' => [
                    'required'    => 'The name field is required.',
                    'min_length'  => 'The name must be at least 3 characters long.',
                    'max_length'  => 'The name cannot exceed 50 characters.'
                ]
            ],
            'contactNumber' => [
                'label' => 'Contact Number',
                'rules' => 'required|min_length[10]|max_length[10]|is_unique[stores.contactNumber]|numeric',
                'errors' => [
                    'required'    => 'Contact number is required.',
                    'min_length'  => 'Contact number must be at least 10 digits.',
                    'max_length'  => 'Contact number cannot exceed 10 digits.',
                    'is_unique'   => 'Contact number already exists.',
                    'numeric'     => 'Contact number must be numeric.',
                ]
            ],
            'email' => [
                'label' => 'Email Address',
                'rules' => 'required|valid_email',
                'errors' => [
                    'required'    => 'Email is required.',
                    'valid_email' => 'Please enter a valid email address.'
                ]
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required|min_length[6]|max_length[20]',
                'errors' => [
                    'required'    => 'Password is required.',
                    'min_length'  => 'Password must be at least 6 characters.',
                    'max_length'  => 'Password cannot exceed 20 characters.'
                ]
            ],
            // 'phone' => [
            //     'label' => 'Phone',
            //     'rules' => 'required|numeric|max_length[10]',
            //     'errors' => [
            //         'required'    => 'Phone number is required.',
            //         'numeric'     => 'Phone number must be numeric.',
            //         'max_length'  => 'Phone number cannot exceed 10 digits.'
            //     ]
            // ],
            'address' => [
                'label' => 'Address',
                'rules' => 'required|min_length[5]|max_length[100]',
                'errors' => [
                    'required'    => 'Address is required.',
                    'min_length'  => 'Address must be at least 5 characters.',
                    'max_length'  => 'Address cannot exceed 100 characters.'
                ]
            ],
            'status' => [
                'label' => 'Status',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Status is required.'
                ]
            ]
        ];


        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        $email = $this->request->getPost('email');
        $contact = $this->request->getPost('contactNumber');

        $data = [
            'name'          => $this->request->getPost('name'),
            'contactNumber' => $contact,
            'email'         => $email,
            'password'      => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            // 'phone'         => $this->request->getPost('phone'),
            'address'       => $this->request->getPost('address'),
            'status'        => $this->request->getPost('status')
        ];
        // print_r($data);die;
        if ($this->StoreModel->insert($data)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Store added successfully!']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to add store.']);
        }
    }


    public function updatestore($id)
    {
        helper(['form']);
        $storeModel = new \App\Models\StoreModel();
        $rules = [
            'name' => [
                'rules'  => 'min_length[3]|max_length[50]',
                'errors' => [
                    'min_length' => 'Name must be at least 3 characters.',
                    'max_length' => 'Name cannot exceed 50 characters.',
                ]
            ],
            'contactNumber' => [
                'rules'  => 'min_length[10]|max_length[15]',
                'errors' => [
                    'min_length' => 'Contact number must be at least 10 digits.',
                    'max_length' => 'Contact number cannot exceed 15 digits.',
                ]
            ],
            'email' => [
                'rules'  => 'valid_email',
                'errors' => [
                    'valid_email' => 'Please enter a valid email address.',
                ]
            ],
            'password' => [
                'rules'  => 'permit_empty|min_length[6]|max_length[20]',
                'errors' => [
                    'min_length' => 'Password must be at least 6 characters.',
                    'max_length' => 'Password cannot exceed 20 characters.',
                ]
            ],
            'address' => [
                'rules'  => 'min_length[5]|max_length[100]',
                'errors' => [
                    'min_length' => 'Address must be at least 5 characters.',
                    'max_length' => 'Address cannot exceed 100 characters.',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors'  => $this->validator->getErrors()
            ]);
        }

        $data = [
            'name'          => $this->request->getPost('name'),
            'contactNumber' => $this->request->getPost('contactNumber'),
            'email'         => $this->request->getPost('email'),
            'address'       => $this->request->getPost('address'),
            'status'        => $this->request->getPost('status')
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_BCRYPT);
        }
      
        if ($storeModel->update($id, $data)) {
            return $this->response->setJSON(['success' => true]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to update store.'
        ]);
    }

    // public function delete()
    // {
    //     $storeId = $this->request->getPost('storeId');
    //     if ($this->StoreModel->delete($storeId)) {
    //         return $this->response->setJSON(['status' => 'success', 'message' => 'Store deleted successfully!']);
    //     } else {
    //         return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to delete store.']);
    //     }
    // }
     public function delete()
    {
        $storeId = $this->request->getPost('storeId');
        $userId = session()->get('id');

        if (!$storeId) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Role ID is required.'
            ]);
        }
        $service = new CommonService();

        $deleted = $service->softDelete('stores','store_id',$storeId, $userId);

        if (!$deleted) {
            return $this->response->setJSON([
                'status' => 'error',        
                'message' => 'Failed to delete store.'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'store deleted successfully!'
        ]);
    }

    public function getStoreDataById($id)
    {
        $data = $this->StoreModel->find($id);
        return json_encode($data);
    }

    // public function deleteMultiple()
    // {
    //     $storeIds = $this->request->getPost('storeIds');
    //     if (!empty($storeIds)) {
    //         $this->StoreModel->whereIn('store_id', $storeIds)->delete(); // Corrected key
    //         return $this->response->setJSON(['status' => 'success', 'message' => 'Stores deleted successfully']);
    //     }
    //     return $this->response->setJSON(['status' => 'error', 'message' => 'No stores selected']);
    // }
}
