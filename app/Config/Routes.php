<?php

use CodeIgniter\Router\RouteCollection;
$routes->get('/', 'Logincontroller::login');
$routes->get('login', 'Logincontroller::login'); // Show login form
$routes->get('register', 'Logincontroller::register'); // Show register form
$routes->post('register/save', 'Logincontroller::saveRegister'); 
$routes->post('dologin', 'Logincontroller::dologin'); // Submit login
$routes->get('logout', 'Logincontroller::logout'); // Logout user
$routes->get('index', 'Logincontroller::index', ['filter' => 'auth']); // Protected dashboard
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('changePassword', 'Logincontroller::changePasswordForm');
$routes->post('changePassword', 'Logincontroller::changePassword');


// role module
$routes->get('role', 'RoleController::role'); // for view 
$routes->get('role/data', 'RoleController::getRoleData'); // ajax call
$routes->match(['get', 'post'], 'role/permission', 'RoleController::getPermission');
$routes->get('addrole', 'RoleController::addRoleForm');
$routes->get('role/edit/(:num)', 'RoleController::editRoleForm/$1');
$routes->get('role/getEditRoleData/(:num)', 'RoleController::getEditRoleData/$1');
$routes->post('role/permissions', 'RoleController::getPermissionData');
$routes->post('role/updatePermissions', 'RoleController::updatePermissions');
$routes->post('update', 'RoleController::update'); // for update
$routes->post('role/delete', 'RoleController::delete'); // for delete
$routes->post('role/deleteMultiple', 'RoleController::deleteMultiple'); // for delete 
$routes->post('role/checkRoleName', 'RoleController::checkRoleName');


// store module 
$routes->get('store', 'StoreController::store');
$routes->get('store/data', 'StoreController::getStoreData'); // ajax call
$routes->post('store/update/(:num)', 'StoreController::updatestore/$1');
$routes->get('store/addstore', 'StoreController::addStoreForm');
$routes->post('store/addstore', 'StoreController::addStore');
$routes->get('store/addstore/(:num)', 'StoreController::addStoreForm/$1');
$routes->get('getstoredata/(:num)', 'StoreController::getStoreDataById/$1'); // model view
$routes->post('store/delete', 'StoreController::delete');
$routes->post('store/deleteMultiple', 'StoreController::deleteMultiple');

// Employee module 
$routes->get('employee', 'EmployeeController::employee');
$routes->post('employee/data', 'EmployeeController::getEmployeeData');
$routes->get('employee/addemployee', 'EmployeeController::addEmployeeForm');
$routes->post('employee/addemployee', 'EmployeeController::addEmployee');
$routes->get('employee/addemployee/(:num)', 'EmployeeController::addEmployeeForm/$1');
$routes->get('getemployeedata/(:num)', 'EmployeeController::getEmployee/$1');
$routes->post('employee/updatedata/(:num)', 'EmployeeController::updateData/$1');
$routes->post('employee/delete', 'EmployeeController::delete');
$routes->post('employee/deleteMultiple', 'EmployeeController::deleteMultipleData');
$routes->get('csv-view', 'EmployeeController::view');
$routes->post('check-before-download', 'EmployeeController::checkBeforeDownload');
$routes->get('download-csv', 'EmployeeController::downloadCSV');
$routes->post('employee/upload_csv', 'EmployeeController::upload_csv');
$routes->get('sample/generate-csv', 'EmployeeController::generateCsv');
$routes->get('sample/download-csv', 'EmployeeController::downloadsampleCsv');
$routes->get('employee/addmultipalemployee', 'EmployeeController::addMultipalEmployeeForm');


// category module
$routes->get('category', 'CategoryController::category');
$routes->get('category/data', 'CategoryController::getcategoryData'); // ajax call
$routes->get('category/addcategory', 'CategoryController::addCategoryForm');
$routes->post('category/addcategory', 'CategoryController::addCategoryData');
$routes->get('category/addcategory/(:num)', 'CategoryController::addCategoryForm/$1');
// $routes->post('category/add', 'CategoryController::addCategoryData');

$routes->post('category/update/(:num)', 'CategoryController::updateCategoryData/$1');

$routes->get('getcategorydata/(:num)', 'CategoryController::getcategoryDataById/$1'); // model view
$routes->post('category/delete', 'CategoryController::deleteCategoryData'); // for delete


// product module
$routes->get('products', 'ProductsController::productView');
$routes->get('products/data', 'ProductsController::getProductData'); // ajax call
$routes->get('products/addproduct', 'ProductsController::addProductForm');
$routes->post('products/addproduct', 'ProductsController::addProductData');
$routes->get('products/addproduct/(:num)', 'ProductsController::addProductForm/$1');
// $routes->post('products/add', 'ProductsController::addProductData');
$routes->post('products/update/(:num)', 'ProductsController::updateProductData/$1 ');
$routes->get('getproductdata/(:num)', 'ProductsController::getProductDataById/$1'); // model view
$routes->post('products/update', 'ProductsController::updateProductData'); // for update
$routes->post('products/delete', 'ProductsController::deleteProductData');


// transfers module
$routes->get('transfers', 'TransfersController::transfers');
$routes->get('transfers/data', 'TransfersController::getTransfersData'); // ajax call
$routes->get('addtransfers', 'TransfersController::addTransfersFormOrSearch'); // for view

$routes->post('addtransfers', 'TransfersController::addProductData'); // for insert
$routes->get('gettransferdata/(:num)', 'TransfersController::getTransfersDataById/$1'); // model view
$routes->post('transfer/update', 'TransfersController::updateTransferProduct'); // for update
$routes->post('transfer/delete', 'TransfersController::deleteTransferProduct');
$routes->get('/transfers', 'TransfersController::getTransfersData');
$routes->get('products/search', 'TransfersController::searchdata');

$routes->post('transfer/getProductQuantity', 'TransfersController::getProductQuantity');
$routes->post('transfer/processTransfer', 'TransfersController::processTransfer');

$routes->post('transfer/checkProductInStore', 'TransfersController::checkProductAndQuantity');

$routes->post('transfer/getProductsByStore', 'TransfersController::getProductsByStore');

// receive items module
$routes->get('receiveItems', 'ReceiveItemsController::receive');
$routes->get('receiveItems/data', 'ReceiveItemsController::getreceiveItemsData'); // ajax call

$routes->get('receiveItems/addreceiveItems/(:num)', 'ReceiveItemsController::addreceiveItemsForm/$1'); // for view

$routes->get('getreceiveItemsdata/(:num)', 'ReceiveItemsController::getreceiveItemsDataById/$1'); // model view
$routes->post('receiveItems/update', 'ReceiveItemsController::update'); // for update
$routes->post('receiveItems/delete', 'ReceiveItemsController::delete');

$routes->get('receiveitem/goToStore/(:num)', 'ReceiveItemsController::goToStore/$1');

