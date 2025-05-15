<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Tables - StoreWise Product info</title>
    <link href="<?= base_url('assets/datatable/css/style.min.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('assets/css/styles.css') ?>" rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap-5.1.3-dist/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/datatable/css/dataTables.dataTables.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/datatable/css/jquery.dataTables.min.css') ?>">
    <script src="<?= base_url('assets/fontawesome/js/all.js') ?>" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <?= $this->include('templates/header') ?>
    <div id="layoutSidenav">
        <?= $this->include('templates/sidebar') ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">

                    <h1 class="mt-4 ">StoreWise Product</h1>
                    <button class="btn btn-outline-danger" id="delete-multiple-btn">Delete</button>
                    <table id="myTable_storeProduct">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Product Image Id</th>
                                <th>Store Name</th>
                                <th>Product Name</th>
                                <th>Available Quantity</th>
                                <th>Blocked Quantity</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be populated here by DataTables -->
                        </tbody>
                    </table>
                    <div class="modal" id="Modal" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Update Form</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="roleform" enctype="multipart/form-data">
                                        <input type="hidden" name="model_id" id="model_id">
                                        <div class="mb-3">
                                            <label for="product_image_id" class="form-label">Product Image ID</label>
                                            <input type="text" class="form-control" id="model_product_image_id" name="model_product_image_id" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="storeId" class="form-label">Store ID</label>
                                            <input type="text" class="form-control" id="model_storeId" name="model_storeId" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="productId" class="form-label">Product ID</label>
                                            <input type="text" class="form-control" id="model_productId" name="model_productId" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="availableQuantity" class="form-label">Available Quantity</label>
                                            <input type="text" class="form-control" id="model_availableQuantity" name="model_availableQuantity" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="blockedQuantity" class="form-label">Blocked Quantity</label>
                                            <input type="text" class="form-control" id="model_blockedQuantity" name="model_blockedQuantity" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-select" id="role_model_status" name="status" required>
                                                <!-- <option value="">Select Status</option> -->
                                                <option value="0">Active</option>
                                                <option value="1">inactive</option>
                                            </select>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="update">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?= $this->include('templates/footer') ?>
                </div>
            </main>
        </div>
    </div>
    <script src="<?= base_url('assets/jquery/js/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/bootstrap-5.1.3-dist/js/bootstrap.bundle.min.js') ?>" crossorigin="anonymous"></script>
    <script src="<?= base_url('assets/bootstrap-5.1.3-dist/js/scripts.js') ?>"></script>
    <script src="<?= base_url('assets/datatable/js/simple-datatables.min.js') ?>" crossorigin="anonymous"></script>
    <script src="<?= base_url('assets/datatable/js/datatables-simple-demo.js') ?>"></script>
    <script src="<?= base_url('assets/datatable/js/datatables.min.js') ?>"></script>

    <script>
        $(document).ready(function() {
            var table = $('#myTable_storeProduct').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: "<?= site_url('storeWiseProduct/data') ?>",
                    dataSrc: 'data'
                },
                columns: [{
                        data: 'product_image_id',
                        render: function(data) {
                            return `<input type="checkbox" class="product-checkbox" value="${data}">`;
                        }
                    },
                    {
                        data: 'product_image_id'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'productName'
                    },
                    {
                        data: 'availableQuantity'
                    },
                    {
                        data: 'blockedQuantity'
                    },
                    {
                        data: 'status',
                        render: function(data) {
                        return data == 0 ? '<h5><span class="badge bg-success">Active</span></h5>' : '<h5><span class="badge bg-danger">Inactive</span></h5>';
                    }
                    },
                    {
                        data: 'product_image_id',
                        render: function(data, type, row) {
                            return `
                    <button class="btn btn btn-outline-primary" onclick="editstoreproduct(${row.product_image_id})">Edit</button>
                    <button class="btn btn-outline-danger delete-storewise-product" data-id="${row.product_image_id}">Delete</button>`;
                        }
                    }
                ]
            })
        });

        $(document).on('click', '.delete-storewise-product', function() {
            var productstoreId = $(this).data('id');
            var data = {
                productstoreId: productstoreId
            }
            console.log(productstoreId);
            if (confirm('Are you sure you want to delete this employee?')) {
                $.ajax({
                    url: "<?= site_url('storeWiseProduct/delete') ?>",
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#myTable_storeProduct').DataTable().ajax.reload();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function() {
                        alert('Something went wrong during deletion.');
                    }
                });
            }
        });

    </script>

</body>

</html>