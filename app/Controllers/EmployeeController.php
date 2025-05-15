<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EmployeeModel;
use App\Models\StoreModel;
use App\Models\RoleModel;
use App\Libraries\CommonService;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use CodeIgniter\Database\Database;

class EmployeeController extends BaseController
{
    protected $employeeModel;

    public function __construct()
    {
        $this->employeeModel = new EmployeeModel();
    }

    public function employee()
    {
        return view('employee/employee');
    }

    // public function getEmployeeData()
    // {
    //     helper('permission');
    //     $request = service('request');
    //     $postData = $request->getPost();

    //     $draw = $postData['draw'];
    //     $start = $postData['start'];
    //     $length = $postData['length'];

    //     $name = $postData['empName'] ?? null;
    //     $email = $postData['empEmail'] ?? null;
    //     $mobile = $postData['empMobile'] ?? null;
    //     $status = $postData['status'] ?? null;

    //     $employeeModel = new \App\Models\EmployeeModel();

    //     $data = $employeeModel->getFilteredEmployees($start, $length, $name, $email, $mobile, $status);
    //     $recordsTotal = $employeeModel->countAllEmployees();
    //     $recordsFiltered = $employeeModel->countFilteredEmployees($name, $email, $mobile, $status);

    //     foreach ($data as &$row) {
    //         $row['role_id'] = $row['emp_id'];
    //         $row['action'] = get_permission_buttons($row);
    //     }

    //     return $this->response->setJSON([
    //         'draw' => intval($draw),
    //         'recordsTotal' => $recordsTotal,
    //         'recordsFiltered' => $recordsFiltered,
    //         'data' => $data
    //     ]);
    // }
    public function getEmployeeData()

    {
        helper('access');
        $request = service('request');
        $postData = $request->getPost();

        $draw = $postData['draw'];
        $start = $postData['start'];
        $length = $postData['length'];

        $name = $postData['empName'] ?? null;
        $email = $postData['empEmail'] ?? null;
        $mobile = $postData['empMobile'] ?? null;
        $status = $postData['status'] ?? null;

        $employeeModel = new EmployeeModel();

        $data = $employeeModel->getFilteredEmployees($start, $length, $name, $email, $mobile, $status);
        $recordsTotal = $employeeModel->countAllEmployees();
        $recordsFiltered = $employeeModel->countFilteredEmployees($name, $email, $mobile, $status);
        foreach ($data as &$row) {
            $row['role_id'] = $row['emp_id'];
            $row['action'] = get_permission_buttons($row);
        }

        return $this->response->setJSON([
            'draw' => intval($draw),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data
        ]);
    }

    //add employee form 
    public function addEmployeeForm($id = null)
    {
        $storeModel = new \App\Models\StoreModel();
        $roleModel = new \App\Models\RoleModel();
        $employeeModel = new \App\Models\EmployeeModel();

        $data['stores'] = $storeModel->findAll();
        $data['roles'] = $roleModel->findAll();
        $data['employee'] = $id ? $employeeModel->find($id) : null;
        // print_r($data['employee']);die;

        return view('employee/addemployee', $data);
    }
    public function addMultipalEmployeeForm()
    {
        return view('employee/addmultipalemployee');
    }
    public function getEmployee($id)
    {
        $employeeModel = new \App\Models\EmployeeModel();
        $data = $employeeModel->find($id);

        if ($data) {
            return $this->response->setJSON($data);
        } else {
            return $this->response->setStatusCode(404)->setBody('Employee not found');
        }
    }

    public function editemployeeForm($id)
    {
        return view('employee/addemployee', ['empId' => $id]);
    }
    public function addEmployee()
    {
        helper(['form', 'url']);

        $employeeModel = new \App\Models\EmployeeModel();
        $empId = $this->request->getPost('emp_id');

        $rules = [
            'empname' => [
                'rules' => 'required|min_length[3]|max_length[50]',
                'errors' => [
                    'required'    => 'Employee name is required.',
                    'min_length'  => 'Employee name must be at least 3 characters.',
                    'max_length'  => 'Employee name must not exceed 50 characters.'
                ]
            ],
            'code' => [
                'rules' => 'required|min_length[3]|max_length[5]',
                'errors' => [
                    'required'    => 'Code is required.',
                    'min_length'  => 'Code must be at least 3 characters.',
                    'max_length'  => 'Code must not exceed 5 characters.'
                ]
            ],
            'rolename' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Role name is required.'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email' . ($empId ? '' : '|is_unique[employees.email]'),
                'errors' => [
                    'required'   => 'Email is required.',
                    'valid_email' => 'Please provide a valid email address.',
                    'is_unique'  => 'This email is already in use.'
                ]
            ],
            'mobile' => [
                'rules' => 'required|numeric|min_length[10]|max_length[10]' . ($empId ? '' : '|is_unique[employees.mobile]'),
                'errors' => [
                    'required'   => 'Mobile number is required.',
                    'numeric'    => 'Mobile number must be numeric.',
                    'min_length' => 'Mobile number must be 10 digits.',
                    'max_length' => 'Mobile number must be 10 digits.',
                    'is_unique'  => 'This mobile number is already in use.'
                ]
            ],
            'employee_code' => [
                'rules' => 'is_unique[employees.employee_code]',
                'errors' => [
                    'is_unique' => 'This employee code already exists.'
                ]
            ],
            'status' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Status is required.'
                ]
            ]
        ];

        if (!$empId) {
            $rules['password'] = 'required|min_length[6]|max_length[20]';
            $rules['profile'] = 'permit_empty|max_size[profile,2048]|is_image[profile]|mime_in[profile,image/jpg,image/jpeg,image/png]';
        }

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        // Handle image
        $image = $this->request->getFile('profile');
        $newName = $empId ? null : 'default.jpg';

        if ($image && $image->isValid() && !$image->hasMoved()) {
            $newName = $image->getClientName(); // Save actual file name
            $image->move(ROOTPATH . 'public/uploads/profile', $newName);
        }

        // Prepare data
        $data = [
            'accessStoreId'  => $this->request->getPost('accessStoreId'),
            'role_id'        => $this->request->getPost('rolename'),
            'employee_code'  => $this->request->getPost('code'),
            'empname'        => $this->request->getPost('empname'),
            'email'          => $this->request->getPost('email'),
            'mobile'         => $this->request->getPost('mobile'),
            'status'         => $this->request->getPost('status')
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        if ($newName) {
            $data['profile'] = $newName;
        }

        // Insert into database
        $db = \Config\Database::connect();
        $db->transStart();
        $inserted = $employeeModel->insert($data);
        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Transaction failed. Employee not added.'
            ]);
        }

        if ($inserted) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Employee added successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to add employee.'
            ]);
        }
    }



    public function updateData()
    {
        helper(['form']);
        $employeeModel = new \App\Models\EmployeeModel();
        $empId = $this->request->getPost('editempId');

        // Validation rules
        $rules = [
            'empname' => [
                'rules' => 'min_length[3]|max_length[50]',
                'errors' => [
                    'min_length'  => 'Employee name must be at least 3 characters.',
                    'max_length'  => 'Employee name must not exceed 50 characters.'
                ]
            ],
            'email' => [
                'rules' => 'valid_email' . ($empId ? '' : '|is_unique[employees.email]'),
                'errors' => [
                    'valid_email' => 'Please provide a valid email address.',
                    'is_unique'   => 'This email is already registered.'
                ]
            ],
            'mobile' => [
                'rules' => 'numeric|min_length[10]|max_length[10]' . ($empId ? '' : '|is_unique[employees.mobile]'),
                'errors' => [
                    'numeric'     => 'Mobile number must be numeric.',
                    'min_length'  => 'Mobile number must be exactly 10 digits.',
                    'max_length'  => 'Mobile number must be exactly 10 digits.',
                    'is_unique'   => 'This mobile number is already registered.'
                ]
            ],
            'profile' => [
                'rules' => 'max_size[profile,2048]|is_image[profile]|mime_in[profile,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size'  => 'Profile image size must not exceed 2MB.',
                    'is_image'  => 'Only image files are allowed.',
                    'mime_in'   => 'Only JPG, JPEG, or PNG formats are accepted.',
                ]
            ]
        ];

        // Validate form inputs
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }


        $newName = null;
        $profileImage = $this->request->getFile('profile');
        if ($profileImage && $profileImage->isValid() && !$profileImage->hasMoved()) {
            $newName = $profileImage->getClientName();
            $profileImage->move('uploads/profile/', $newName);
        }

        $data = [
            'employee_code' => $this->request->getPost('code'),
            'empname' => $this->request->getPost('empname'),
            'email'   => $this->request->getPost('email'),
            'mobile'  => $this->request->getPost('mobile'),
            'status'  => $this->request->getPost('status'),
        ];

        if ($newName) {
            $data['profile'] = $newName;
        }

        if ($employeeModel->update($empId, $data)) {
            return $this->response->setJSON(['success' => true]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to update employee.'
        ]);
    }


    // public function delete()
    // {
    //     $empId = $this->request->getPost('empId');

    //     if ($this->employeeModel->delete($empId)) {
    //         return $this->response->setJSON([
    //             'status'  => 'success',
    //             'message' => 'Employee deleted successfully!'
    //         ]);
    //     } else {
    //         return $this->response->setJSON([
    //             'status'  => 'error',
    //             'message' => 'Failed to delete employee.'
    //         ]);
    //     }
    // }

      public function delete()
    {
        $empId = $this->request->getPost('empId');
        $userId = session()->get('id');

        if (!$empId) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Role ID is required.'
            ]);
        }
        $service = new CommonService();
        $deleted = $service->softDelete('employees', 'emp_id', $empId, $userId);

        if (!$deleted) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to delete role.'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Role deleted successfully!'
        ]);
    }



    // public function deleteMultipleData()
    // {
    //     $empIds = $this->request->getPost('empIds');

    //     //  Convert to array if only one ID was sent as string
    //     if (!is_array($empIds)) {
    //         $empIds = [$empIds];
    //     }

    //     if (!empty($empIds)) {
    //         $this->employeeModel->whereIn('emp_id', $empIds)->delete();

    //         return $this->response->setJSON([
    //             'status' => 'success',
    //             'message' => 'Employees deleted successfully'
    //         ]);
    //     }

    //     return $this->response->setJSON([
    //         'status' => 'error',
    //         'message' => 'No employees selected'
    //     ]);
    // }

    public function checkBeforeDownload()
    {
        return $this->response->setJSON(['status' => 'ok']);
    }

    public function downloadCSV()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('employees');
        $results = $builder->get()->getResultArray();

        foreach ($results as &$row) {
            $row['status'] = $row['status'] == 1 ? 'Active' : 'Inactive';
        }

        $filename = 'Employee_' . date('Ymd_His', time()) . '.csv';

        return $this->response
            ->setHeader('Content-Type', 'text/csv')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setBody($this->createCSV($results));
    }


    private function createCSV(array $results): string
    {
        $output = fopen('php://temp', 'r+');
        fputcsv($output, ['employee_code', 'empname', 'email', 'mobile', 'status']); // header 'created_By', 'updated_By', 'deleted_By'

        foreach ($results as $row) {
            fputcsv($output, [$row['employee_code'], $row['empname'], $row['email'], $row['mobile'], $row['status']]);
        }

        rewind($output);
        return stream_get_contents($output);
    }

    public function upload_csv()
    {
        $response = ['success' => false, 'error' => '', 'employees' => [], 'errors' => []];

        try {
            $file = $this->request->getFile('csv_file');

            if (!$file || !$file->isValid()) {
                $response['error'] = 'No valid file uploaded.';
                return $this->response->setJSON($response);
            }

            if ($file->getExtension() !== 'csv') {
                $response['error'] = 'Only CSV files are allowed.';
                return $this->response->setJSON($response);
            }

            if ($file->getSize() > 2 * 1024 * 1024) {
                $response['error'] = 'CSV file is too large (max 2MB).';
                return $this->response->setJSON($response);
            }

            $filePath = $file->getTempName();
            $csvData = [];
            $lineNo = 1;
            $errors = [];

            $expectedHeaders = [
                'accessstorename',
                'role_id',
                'employee_code',
                'empname',
                'email',
                'profile',
                'password',
                'mobile',
            ];

            $employeeModel = new \App\Models\EmployeeModel();
            $storeModel = new \App\Models\StoreModel();

            // Track values to detect duplicates within CSV
            $seenEmployeeCodes = [];
            $seenEmails = [];
            $seenMobiles = [];

            if (($handle = fopen($filePath, 'r')) !== false) {
                $headers = fgetcsv($handle, 1000, ",");
                $lineNo++;

                if (!$headers || count($headers) !== count($expectedHeaders)) {
                    $response['error'] = 'Invalid CSV header format.';
                    return $this->response->setJSON($response);
                }

                $headerMap = array_map('strtolower', $headers);
                foreach ($expectedHeaders as $index => $expectedHeader) {
                    if ($headerMap[$index] !== $expectedHeader) {
                        $response['error'] = "CSV header mismatch at column " . ($index + 1) .
                            ": expected '{$expectedHeader}', found '{$headers[$index]}'";
                        return $this->response->setJSON($response);
                    }
                }

                while (($row = fgetcsv($handle, 1000, ",")) !== false) {
                    $lineNo++;

                    if (count($row) !== 8) {
                        $errors[] = "Row $lineNo: Expected 8 columns, found " . count($row);
                        continue;
                    }

                    list($accessStoreName, $roleId, $employeeCode, $empname, $email, $profile, $password, $mobile) = array_map('trim', $row);
                    $rowErrors = [];

                    $store = $storeModel->where('LOWER(name)', strtolower($accessStoreName))->first();
                    if (!$store) {
                        $rowErrors[] = "Store name '$accessStoreName' not found.";
                    }

                    if (empty($employeeCode)) $rowErrors[] = "Employee code is required.";
                    if (empty($empname)) $rowErrors[] = "Employee name is required.";
                    if (empty($email)) $rowErrors[] = "Email is required.";
                    if (empty($password)) $rowErrors[] = "Password is required.";
                    if (empty($mobile)) $rowErrors[] = "Mobile is required.";

                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $rowErrors[] = "Invalid email format.";
                    }

                    if (!preg_match('/^\d{10}$/', $mobile)) {
                        $rowErrors[] = "Mobile must be 10 digits.";
                    }

                    // Check duplicates in DB
                    if ($employeeModel->where('employee_code', $employeeCode)->countAllResults() > 0) {
                        $rowErrors[] = "Employee code '$employeeCode' already exists.";
                    }

                    if ($employeeModel->where('email', $email)->countAllResults() > 0) {
                        $rowErrors[] = "Email '$email' already exists.";
                    }

                    if ($employeeModel->where('mobile', $mobile)->countAllResults() > 0) {
                        $rowErrors[] = "Mobile number '$mobile' already exists.";
                    }

                    // Check duplicates in CSV itself
                    if (in_array($employeeCode, $seenEmployeeCodes)) {
                        $rowErrors[] = "Duplicate employee code '$employeeCode' found in CSV.";
                    } else {
                        $seenEmployeeCodes[] = $employeeCode;
                    }

                    if (in_array($email, $seenEmails)) {
                        $rowErrors[] = "Duplicate email '$email' found in CSV.";
                    } else {
                        $seenEmails[] = $email;
                    }

                    if (in_array($mobile, $seenMobiles)) {
                        $rowErrors[] = "Duplicate mobile '$mobile' found in CSV.";
                    } else {
                        $seenMobiles[] = $mobile;
                    }

                    // Handle profile path
                    $profilePath = 'default.jpg';
                    if (!empty($profile)) {
                        if (filter_var($profile, FILTER_VALIDATE_URL)) {
                            $profilePath = $profile;
                        } elseif (file_exists(FCPATH . 'uploads/profiles/' . $profile)) {
                            $profilePath = $profile;
                        }
                    }

                    if (!empty($rowErrors)) {
                        $errors[] = "Row $lineNo: " . implode(' ', $rowErrors);
                    } else {
                        $csvData[] = [
                            'accessStoreId'   => $store['store_id'],
                            'role_id'         => $roleId,
                            'employee_code'   => $employeeCode,
                            'empname'         => $empname,
                            'email'           => $email,
                            'profile'         => $profilePath,
                            'password'        => password_hash($password, PASSWORD_DEFAULT),
                            'mobile'          => $mobile,
                        ];
                    }
                }

                fclose($handle);
            }

            if (!empty($errors)) {
                $response['error'] = 'Validation errors found.';
                $response['errors'] = $errors;
                return $this->response->setJSON($response);
            }

            foreach ($csvData as $employee) {
                $employeeModel->insert($employee);
            }

            $response['success'] = true;
            $response['employees'] = $csvData;
            return $this->response->setJSON($response);
        } catch (\Throwable $e) {
            log_message('error', 'CSV Upload Error: ' . $e->getMessage());
            $response['error'] = 'Server Error: ' . $e->getMessage();
            return $this->response->setJSON($response);
        }
    }




    // public function upload_csv()
    // {
    //     $response = ['success' => false, 'error' => '', 'employees' => [], 'errors' => []];

    //     try {
    //         $file = $this->request->getFile('csv_file');

    //         if (!$file || !$file->isValid()) {
    //             $response['error'] = 'No valid file uploaded.';
    //             return $this->response->setJSON($response);
    //         }

    //         if ($file->getExtension() !== 'csv') {
    //             $response['error'] = 'Only CSV files are allowed.';
    //             return $this->response->setJSON($response);
    //         }

    //         if ($file->getSize() > 2 * 1024 * 1024) {
    //             $response['error'] = 'CSV file is too large (max 2MB).';
    //             return $this->response->setJSON($response);
    //         }

    //         $filePath = $file->getTempName();
    //         $csvData = [];
    //         $lineNo = 1;
    //         $errors = [];

    //         $expectedHeaders = [
    //             'accessstorename',
    //             'role_id',
    //             'employee_code',
    //             'empname',
    //             'email',
    //             'profile',
    //             'password',
    //             'mobile',
    //         ];

    //         $employeeModel = new \App\Models\EmployeeModel();
    //         $storeModel = new \App\Models\StoreModel();

    //         if (($handle = fopen($filePath, 'r')) !== false) {
    //             $headers = fgetcsv($handle, 1000, ",");
    //             $lineNo++;

    //             if (!$headers || count($headers) !== count($expectedHeaders)) {
    //                 $response['error'] = 'Invalid CSV header format.';
    //                 return $this->response->setJSON($response);
    //             }

    //             $headerMap = array_map('strtolower', $headers);
    //             foreach ($expectedHeaders as $index => $expectedHeader) {
    //                 if ($headerMap[$index] !== $expectedHeader) {
    //                     $response['error'] = "CSV header mismatch at column " . ($index + 1) .
    //                         ": expected '{$expectedHeader}', found '{$headers[$index]}'";
    //                     return $this->response->setJSON($response);
    //                 }
    //             }

    //             while (($row = fgetcsv($handle, 1000, ",")) !== false) {
    //                 $lineNo++;

    //                 if (count($row) !== 7) {
    //                     $errors[] = "Row $lineNo: Expected 7 columns, found " . count($row);
    //                     continue;
    //                 }

    //                 list($accessStoreName, $roleId, $employeeCode, $empname, $email, $password, $mobile) = array_map('trim', $row);
    //                 $rowErrors = [];

    //                 $store = $storeModel->where('LOWER(name)', strtolower($accessStoreName))->first();
    //                 if (!$store) {
    //                     $rowErrors[] = "Store name '$accessStoreName' not found.";
    //                 }

    //                 if (empty($employeeCode)) $rowErrors[] = "Employee code is required.";
    //                 if (empty($empname)) $rowErrors[] = "Employee name is required.";
    //                 if (empty($email)) $rowErrors[] = "Email is required.";
    //                 if (empty($password)) $rowErrors[] = "Password is required.";
    //                 if (empty($mobile)) $rowErrors[] = "Mobile is required.";  

    //                 if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //                     $rowErrors[] = "Invalid email format.";
    //                 }

    //                 if (!preg_match('/^\d{10}$/', $mobile)) {
    //                     $rowErrors[] = "Mobile must be 10 digits.";
    //                 }

    //                 if ($employeeModel->where('employee_code', $employeeCode)->countAllResults() > 0) {
    //                     $rowErrors[] = "Employee code '$employeeCode' already exists.";
    //                 }

    //                 if ($employeeModel->where('email', $email)->countAllResults() > 0) {
    //                     $rowErrors[] = "Email '$email' already exists.";
    //                 }

    //                 if ($employeeModel->where('mobile', $mobile)->countAllResults() > 0) {
    //                     $rowErrors[] = "Mobile number '$mobile' already exists.";
    //                 }

    //                 if (!empty($rowErrors)) {
    //                     $errors[] = "Row $lineNo: " . implode(' ', $rowErrors);
    //                 } else {
    //                     $csvData[] = [
    //                         'accessStoreId'   => $store['store_id'],
    //                         'role_id'         => $roleId,
    //                         'employee_code'   => $employeeCode,
    //                         'empname'         => $empname,
    //                         'email'           => $email,
    //                         'profile'         => 'default.jpg',
    //                         'password'        => password_hash($password, PASSWORD_DEFAULT),
    //                         'mobile'          => $mobile,
    //                     ];
    //                 }
    //             }

    //             fclose($handle);
    //         }

    //         if (!empty($errors)) {
    //             $response['error'] = 'Validation errors found.';
    //             $response['errors'] = $errors;
    //             return $this->response->setJSON($response);
    //         }

    //         foreach ($csvData as $employee) {
    //             $employeeModel->insert($employee);
    //         }

    //         $response['success'] = true;
    //         $response['employees'] = $csvData;
    //         return $this->response->setJSON($response);
    //     } catch (\Throwable $e) {
    //         log_message('error', 'CSV Upload Error: ' . $e->getMessage());
    //         $response['error'] = 'Server Error: ' . $e->getMessage();
    //         return $this->response->setJSON($response);
    //     }
    // }

    public function generateCsv()
    {
        return $this->response->setJSON(['status' => 'success']);
    }

    public function downloadsampleCsv()
    {
        $data = [
            ['accessStoreName', 'role_Id', 'employee_code', 'empname', 'email', 'profile', 'password', 'mobile'],
            ['deep computer', 'employee', 'EMP001', 'John Doe', 'john@example.com', 'default.jpg', '12345678', '9999999999'],
            ['Dell computer', 'employee', 'EMP002', 'Jane Doe', 'jane@example.com', 'default.jpg', 'abcdefgh', '8888888888'],
        ];

        $filename = 'sample_data_' . date('YmdHis', time()) . '.csv';

        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv");

        $output = fopen('php://output', 'w');
        foreach ($data as $row) {
            fputcsv($output, $row);
        }
        fclose($output);
        exit;
    }
}
