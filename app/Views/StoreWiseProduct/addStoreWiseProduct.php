<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Tables - SB Admin</title><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Tables - SB Admin</title>
    <link rel="stylesheet" href="<?= base_url('assets/datatable/css/dataTables.dataTables.min.css') ?>">
    <link href="<?= base_url('assets/datatable/css/style.min.css') ?>" rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url('assets/css/styles.css') ?>">
    <script src="<?= base_url('assets/fontawesome/js/all.js') ?>" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <?= view('templates/header') ?>
    <div id="layoutSidenav">
        <?= view('templates/sidebar') ?>
        <div id="layoutSidenav_content">
            <main>
                <small class="text-danger">
                    <?= session('errors.name') ?>
                    <?= session('errors.status') ?>
                </small>

                <div class="container-fluid px-4">
                    <h2>Add Storewise Product</h2>
                    <?php if (session()->has('errors')) : ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php foreach (session('errors') as $error) : ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success">
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>
                    <form method="post" action="<?= base_url('addproduct') ?>" enctype="multipart/form-data">
                        <input type="text" class="form-control" id="product_id" name="product_id" hidden>
                        <div class="mb-3">
                            <label class="form-label">Store Name</label>
                            <select name="storeId" id="storeId" class="form-control" required>
                                <option value="">-- Select Store --</option>
                             
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category Name</label>
                            <select name="categoryId" id="categoryId" class="form-control" required>
                                <option value="">-- Select Store --</option>
                                
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="productName" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="productName" name="productName" required>
                        </div>
                        <div class="mb-3">
                            <label for="sku" class="form-label">SKU</label>
                            <input type="text" class="form-control" id="sku" name="sku" required>
                        </div>
                        <div class="mb-3">
                            <label for="barcode" class="form-label">Barcode</label>
                            <input type="text" class="form-control" id="barcode" name="barcode" required>
                        </div>
                        <div class="mb-3">
                            <label for="productImage" class="form-label">Product Image</label>
                            <input type="file" class="form-control" id="productImage" name="productImage" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="product_status" name="product_status" required>
                                <option value="">Select Status</option>
                                <option value="0">Active</option>
                                <option value="1">inactive</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Created By</label>
                            <select name="updated_By" id="updated_By" class="form-control" required>
                                <option value="">-- Created By --</option>
                                <option value="0">Admin</option>
                                <option value="1">User</option>
                                <option value="2">Manager</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" id="addproduct">Add Product</button>
                    </form>
                    <?= view('templates/footer') ?>
                </div>
            </main>
        </div>
    </div>
    <script src="<?= base_url('assets/jquery/js/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/bootstrap-5.1.3-dist/js/bootstrap.bundle.min.js') ?>" crossorigin="anonymous"></script>
    <script src="<?= base_url('assets/bootstrap-5.1.3-dist/js/scripts.js') ?>"></script>
    <script src="<?= base_url('assets/datatable/js/datatables-simple-demo.js') ?>"></script>
    <script src="<?= base_url('assets/datatable/js/datatables.min.js') ?>"></script>

    <script>
    </script>

</body>
    <link rel="stylesheet" href="<?= base_url('assets/datatable/css/dataTables.dataTables.min.css') ?>">
    <link href="<?= base_url('assets/datatable/css/style.min.css') ?>" rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url('assets/css/styles.css') ?>">
    <script src="<?= base_url('assets/fontawesome/js/all.js') ?>" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <?= $this->include('templates/header') ?>
    <div id="layoutSidenav">
        <?= $this->include('templates/sidebar') ?>
        <div id="layoutSidenav_content">
            <main>
                <small class="text-danger">
                    <?= session('errors.name') ?>
                    <?= session('errors.status') ?>
                </small>

                <div class="container-fluid px-4">
                    <h2>Add StoreWise Product</h2>
                    <form method="post" action="<?= base_url('addStoreWiseProduct') ?>" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id">
                        <div class="mb-3">
                            <label for="product_image_id" class="form-label">Product Image ID</label>
                            <input type="text" class="form-control" id="product_image_id" name="product_image_id" required>
                        </div>
                        <div class="mb-3">
                            <label for="storeId" class="form-label">Store ID</label>
                            <input type="text" class="form-control" id="storeId" name="storeId" required>
                        </div>
                        <div class="mb-3">
                            <label for="productId" class="form-label">Product ID</label>
                            <input type="text" class="form-control" id="productId" name="productId" required>
                        </div>
                        <div class="mb-3">
                            <label for="availableQuantity" class="form-label">Available Quantity</label>
                            <input type="text" class="form-control" id="availableQuantity" name="availableQuantity" required>
                        </div>
                        <div class="mb-3">
                            <label for="blockedQuantity" class="form-label">Blocked Quantity</label>
                            <input type="text" class="form-control" id="blockedQuantity" name="blockedQuantity" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="role_model_status" name="status" required>
                                <!-- <option value="">Select Status</option> -->
                                <option value="0">Active</option>
                                <option value="1">inactive</option>
                            </select>
                        </div>

                        <button type="submit" id="add-btn" class="btn btn-primary">Save</button>
                    </form>
                    <?= $this->include('templates/footer') ?>
                </div>
            </main>
        </div>
    </div>
    <script src="<?= base_url('assets/jquery/js/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/bootstrap-5.1.3-dist/js/bootstrap.bundle.min.js') ?>" crossorigin="anonymous"></script>
    <script src="<?= base_url('assets/bootstrap-5.1.3-dist/js/scripts.js') ?>"></script>
    <script src="<?= base_url('assets/datatable/js/datatables-simple-demo.js') ?>"></script>
    <script src="<?= base_url('assets/datatable/js/datatables.min.js') ?>"></script>

    <script>
    </script>

</body>