<?= $this->extend('pages/layout'); ?>
<?= $this->section('content'); ?>
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <h2 class="mb-0">Store Info</h2>
        <div class="d-flex gap-2">
            <a href="<?= base_url('store/addstore') ?>" class="btn btn-success">
                <i class="fas fa-plus"></i> Add Store
            </a>
            <!-- <button class="btn btn-danger" id="delete-multiple-store-btn"> -->
            <!-- <i class="fas fa-trash-alt"></i> Delete Selected -->
            <!-- </button> -->
        </div>
    </div>
    <div class="table-responsive">
        <table id="myTable" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <!-- <th></th> -->
                    <!-- <th>Store Id</th> -->
                    <th>Name</th>
                    <th>Contact Number</th>
                    <th>Email</th>
                    <!-- <th>Phone</th> -->
                    <th>Address</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be populated here by DataTables -->
            </tbody>
        </table>
    </div>
    <?= $this->endSection() ?>

    <?= $this->section('scripts'); ?>
    <script>
        const STORE_DATA_URL = "<?= base_url('store/data') ?>";
        const STORE_ADD_URL = "<?= base_url('store/addstore/') ?>";
        const STORE_GETDATA_URL = "<?= base_url('getstoredata') ?>/";
        const STORE_UPDATE_URL = "<?= site_url('store/update') ?>";
        const STORE_DELETE_URL = "<?= site_url('store/delete') ?>";
    </script>
    <script src="<?= base_url('assets/custom-Js/store.js') ?>"></script>

    <?= $this->endSection() ?>
    </body>

    </html>