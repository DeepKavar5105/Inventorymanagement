<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AdminModel;
use App\Models\EmployeeModel;
use App\Models\PermissionModel;
use App\Models\RoleModel;

class Logincontroller extends BaseController
{
    protected $roleModel;

    public function __construct()
    {
        $this->roleModel = new RoleModel();
    }
    // public function index()
    // {
    //     if (!session()->get('logged_in')) {
    //         return redirect()->to('/login');
    //     }

    //     $data = [
    //         'empname'        => session()->get('empname'),
    //         'user_type'      => session()->get('user_type'),
    //         'role_id'        => session()->get('role_id'),
    //         'permissions'    => session()->get('permissions') ?? [],
    //         'showRoleAlert'  => session()->get('user_type') === 'employee' && empty(session()->get('role_id')),
    //     ];

    //     return view('pages/index', $data);
    // }

    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $data = [
            'empname'        => session()->get('empname'),
            'user_type'      => session()->get('user_type'),
            'role_id'        => session()->get('role_id'),
            'permissions'    => session()->get('permissions') ?? [],
            'showRoleAlert'  => session()->get('user_type') === 'employee' && empty(session()->get('role_id')),
        ];

        $db = \Config\Database::connect();

        $totalProducts = $db->table('products')
            ->where('deleted_at', null)
            ->countAllResults();

        $totalStores = $db->table('stores')
            ->where('deleted_at', null)
            ->countAllResults();

        $data['totalProducts'] = $totalProducts;
        $data['totalStores'] = $totalStores;

        return view('pages/index', $data);
    }

    public function login()
    {
        return view('pages/login');
    }

    public function dologin()
    {
        helper(['form']);
        $session = session();
        $adminModel = new AdminModel();
        $employeeModel = new EmployeeModel();
        $permissionModel = new PermissionModel();
        $roleModel = new RoleModel();

        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[3]',
        ];

        if (!$this->validate($rules)) {
            return view('pages/login', [
                'validation' => $this->validator
            ]);
        }

        $email = trim(strtolower($this->request->getPost('email')));
        $password = $this->request->getPost('password');

        $db = \Config\Database::connect();

        // Attempt login as Admin
        $builderAdmin = $db->table('admins');
        $builderAdmin->where('email', $email);
        $admin = $builderAdmin->get()->getRowArray();

        if ($admin) { 
            if (password_verify($password, $admin['password'])) {
                $role_id = $admin['role_id'] ?? null;
                $permissions = [];

                if ($role_id) {
                    $permData = $permissionModel->where('roleId', $role_id)->findAll();
                    foreach ($permData as $perm) {
                        $permissions[$perm['moduleName']] = $perm;
                    }
                }

                $session->set([
                    'id'         => $admin['id'],
                    'username'   => $admin['email'],
                    'logged_in'  => true,
                    'permissions' => $permissions,
                    'user_type'  => 'admin'
                ]);

                return redirect()->to('/index');
            } else {
                $session->setFlashdata('error', 'Invalid password');
                return redirect()->to('/login');
            }
        }

        // Attempt login as Employee
        $builderEmployee = $db->table('employees');
        $builderEmployee->where('LOWER(email)', strtolower($email));
        $employee = $builderEmployee->get()->getRowArray();

        if ($employee) {
            if (password_verify($password, $employee['password'])) {
                $role_id = $employee['role_id'] ?? null;
                $roleName = '';

                if ($role_id) {
                    $roleData = $roleModel->find($role_id);
                    $roleName = $roleData['name'] ?? '';
                }

                $permissions = [];
                if ($role_id) {
                    $permData = $permissionModel->where('roleId', $role_id)->findAll();
                    foreach ($permData as $perm) {
                        $permissions[$perm['moduleName']] = $perm;
                    }
                }

                $session->set([
                    'emp_id'      => $employee['emp_id'],
                    'email'       => $employee['email'],
                    'empname'     => $employee['empname'],
                    'role_id'     => $role_id,
                    'role_name'   => $roleName,
                    'permissions' => $permissions,
                    'logged_in'   => true,
                    'user_type'   => 'employee'
                ]);

                return redirect()->to('/index');
            } else {
                $session->setFlashdata('error', 'Invalid password');
                return redirect()->to('/login');
            }
        }

        // If neither admin nor employee found
        $session->setFlashdata('error', 'Invalid credentials');
        return redirect()->to('/login');
    }

    public function changePasswordForm()
    {
        return view('pages/changePassword');
    }

    public function changePassword()
    {
        $session = session();
        $userId = $session->get('id');
        $oldPassword = $this->request->getPost('old_password');
        $newPassword = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_password');

        $adminmodel = new AdminModel();
        $user = $adminmodel->find($userId);

        if (!$user || !password_verify($oldPassword, $user['password'])) {
            return redirect()->back()->with('error', 'Old password is incorrect.');
        }
        
        // if (!$user || $oldPassword !== $user['password']) {
        //     return redirect()->back()->with('error', 'Old password is incorrect.');
        // }

        if ($newPassword !== $confirmPassword) {
            return redirect()->back()->with('error', 'New passwords do not match.');
        }

        $adminmodel->update($userId, [
            'password' => password_hash($newPassword, PASSWORD_DEFAULT)
        ]);

        // return redirect()->back()->with('success', 'Password changed successfully.');
        return redirect()->to('/')->with('success', 'Password changed successfully.');

    }


    public function register()
    {
        $rolemodel = new RoleModel();
        $data['role'] = $rolemodel->findAll();
        return view('pages/register', $data);
    }

    public function saveRegister()
    {
        helper(['form']);

        $rules = [
            'name' => [
                'label' => 'Name',
                'rules' => 'required|regex_match[/^[A-Za-z\s\-\.]+$/]|min_length[2]|max_length[50]',
                'errors' => [
                    'required' => 'Name is required.',
                    'regex_match' => 'Name can only contain letters, spaces, hyphens, or periods.',
                    'min_length' => 'Name must be at least 2 characters long.',
                    'max_length' => 'Name must not exceed 50 characters.'
                ]
            ],
            'phone' => [
                'label' => 'Phone Number',
                'rules' => 'required|regex_match[/^[0-9]{10}$/]|is_unique[admins.mobile]',
                'errors' => [
                    'required' => 'Phone number is required.',
                    'regex_match' => 'Phone number must be 10 digits.',
                    'is_unique' => 'This number is already registered.'
                ]
            ],
            'email' => [
                'label' => 'Email Address',
                'rules' => 'required|valid_email|is_unique[admins.email]',
                'errors' => [
                    'required' => 'Email is required.',
                    'valid_email' => 'Please enter a valid email address.',
                    'is_unique' => 'This email is already registered.'
                ]
            ],
            'profile' => [
                'label' => 'Profile Image',
                'rules' => 'if_exist|uploaded[profile]|max_size[profile,2048]|is_image[profile]|mime_in[profile,image/png,image/jpg,image/jpeg]',
                'errors' => [
                    'uploaded' => 'Please upload a profile image.',
                    'max_size' => 'Profile image size must not exceed 2MB.',
                    'is_image' => 'Uploaded file must be an image.',
                    'mime_in' => 'Profile image must be PNG, JPG, or JPEG.'
                ]
            ],
            'usertype' => [
                'label' => 'User Type',
                'rules' => 'required',
                'errors' => [
                    'required' => 'User type is required.'
                ]
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required|min_length[6]|max_length[100]',
                'errors' => [
                    'required' => 'Password is required.',
                    'min_length' => 'Password must be at least 6 characters.',
                    'max_length' => 'Password must not exceed 100 characters.'
                ]
            ],
            'confirm_password' => [
                'label' => 'Confirm Password',
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Confirm is required.',
                    'matches' => 'Confirm Password must match the Password.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->validator->getErrors()
            ]);
        }


        $profileImage = $this->request->getFile('profile');
        $newName = 'default.jpg';

        if ($profileImage && $profileImage->isValid() && !$profileImage->hasMoved()) {
            $extension = $profileImage->getExtension();
            $allowedExtensions = ['jpg', 'jpeg', 'png'];

            if (!in_array(strtolower($extension), $allowedExtensions)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'errors' => ['profile' => 'Only JPG, JPEG, or PNG images are allowed.']
                ]);
            }

            $newName = $profileImage->getRandomName();
            $profileImage->move('uploads/userprofile/', $newName);
        }
        $adminModel = new \App\Models\AdminModel();
        $data = [
            'name' => $this->request->getPost('name'),
            'mobile' => $this->request->getPost('phone'),
            'role_id' => $this->request->getPost('usertype'),
            'username' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT)
        ];
        if ($newName) {
            $data['profile'] = $newName;
        }
        $adminModel->insert($data);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Registration successful!'
        ]);
    }


    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
