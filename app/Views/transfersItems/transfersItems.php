<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Tables - transfersItems info</title>
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
                    <h1 class="mt-4 ">Receive Items</h1>
                    <!-- <a href="<?= base_url('addtransfersItems') ?>"> <button class='edit_btn btn btn-outline-success'>Add</button></a> -->
                    <!-- <button class="btn btn-outline-danger" id="delete-multiple-btn">Delete</button> -->
                    <table id="transferItemTable">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Transfer Quantity</th>
                                <th>Notes</th>
                                <th>Received Message</th>
                                <th>Status</th>
                                <th>Created_By</th>
                                <th>Updated_By</th>
                                <th>Deleted_By</th>
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
                                        <input type="hidden" name="transfer_item_id" id="transfer_item_id">
                                        <div class="mb-3">
                                            <label class="form-label">transferId</label>
                                            <select name="transferId" id="model_transferId" class="form-control" required>
                                                <option value="">-- Select Store --</option>

                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">productId</label>
                                            <select name="productId" id="model_productId" class="form-control" required>
                                                <option value="">-- Select Store --</option>

                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="transferQuantity" class="form-label">transferQuantity</label>
                                            <input type="text" class="form-control" id="model_transferQuantity" name="model_transferQuantity" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="notes" class="form-label">notes</label>
                                            <input type="text" class="form-control" id="model_notes" name="model_notes" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="receivedMessage" class="form-label">receivedMessage</label>
                                            <input type="text" class="form-control" id="model_receivedMessage" name="model_receivedMessage" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-select" id="model_status" name="model_status" required>
                                                <option value="" selected>Select Status</option>
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Created By</label>
                                            <select name="model_updated_By" id="model_updated_By" class="form-control" required>
                                                <option value="">-- Select Store --</option>
                                                <option value="1">Admin</option>
                                                <option value="2">User</option>
                                                <option value="3">Manager</option>
                                                <option value="4">Employee</option>
                                                <option value="5">Guest</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Updated By</label>
                                            <select name="model_created_By" id="model_created_By" class="form-control" required>
                                                <option value="">-- Select Store --</option>
                                                <option value="1">Admin</option>
                                                <option value="2">User</option>
                                                <option value="3">Manager</option>
                                                <option value="4">Employee</option>
                                                <option value="5">Guest</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Deleted By</label>
                                            <select name="model_deleted_by" id="model_deleted_by" class="form-control" required>
                                                <option value="">-- Select Store --</option>
                                                <option value="1">Admin</option>
                                                <option value="2">User</option>
                                                <option value="3">Manager</option>
                                                <option value="4">Employee</option>
                                                <option value="5">Guest</option>
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
            var table = $('#transferItemTable').DataTable({
                "ajax": {
                    "url": "<?= base_url('transfersItems/data') ?>",
                    "type": "GET",
                    "dataSrc": ""
                },
                "columns": [{
                        data: 'transfer_item_id',
                        render: function(data) {
                            return `<input type="checkbox" class="product-checkbox" value="${data}">`;
                        }
                    },
                    {
                        "data": "transferQuantity"
                    },
                    {
                        "data": "notes"
                    },
                    {
                        "data": "receivedMessage"
                    },

                    {
                        "data": "status",
                        render: function(data) {
                            switch (parseInt(data)) {
                                case 1:
                                    return '<h5><span class="badge bg-primary">SEND</span></h5>';
                                case 2:
                                    return '<h5><span class="badge bg-success text-dark">RECEIVED</span></h5>';
                                case 3:
                                    return '<h5><span class="badge bg-danger text-dark">REJECT</span></h5>'
                                default:
                                    return '<h5><span class="badge bg-info text-light">PENDING</span></h5>'
                            }
                        }
                    },
                    {
                        data: 'created_By',
                        render: function(data) {
                            switch (parseInt(data)) {
                                case 0:
                                    return '<h5><span class="badge bg-success">Admin</span></h5>';
                                case 1:
                                    return '<h5><span class="badge bg-primary">User</span></h5>';
                                case 2:
                                    return '<h5><span class="badge bg-warning text-dark">Manager</span></h5>';
                                default:
                                    return '<h5><span class="badge bg-info text-light">Null</span></h5>'
                            }
                        }
                    },
                    {
                        data: 'updated_By',
                        render: function(data) {
                            switch (parseInt(data)) {
                                case 0:
                                    return '<h5><span class="badge bg-success">Admin</span></h5>';
                                case 1:
                                    return '<h5><span class="badge bg-primary">User</span></h5>';
                                case 2:
                                    return '<h5><span class="badge bg-warning text-dark">Manager</span></h5>';
                                default:
                                    return '<h5><span class="badge bg-info text-light">Null</span></h5>'
                            }
                        }
                    },
                    {
                        data: 'deleted_By',
                        render: function(data) {
                            switch (parseInt(data)) {
                                case 0:
                                    return '<h5><span class="badge bg-success">Admin</span></h5>';
                                case 1:
                                    return '<h5><span class="badge bg-primary">User</span></h5>';
                                case 2:
                                    return '<h5><span class="badge bg-warning text-dark">Manager</span></h5>';
                                default:
                                    return '<h5><span class="badge bg-info text-light">Null</span></h5>'
                            }
                        }
                    },
                    {
                        data: "transfers_id",
                        render: function(data, type, row) {
                            return `<button class="btn btn-outline-success edit-btn_transfer" data-eid='${row.transfers_id}'>Edit</button>
                                    <button class='delete-transfer btn btn-outline-danger' data-did='${row.transfers_id}'>Delete</button>`;
                        }
                    }
                ]
            });
        });
    </script>
</body>

</html>