<?= $this->extend('pages/layout'); ?>
<?= $this->section('content'); ?>
<div class="d-flex justify-content-between align-items-center mt-4 mb-3">
    <h2 class="mb-0">products info</h2>
    <div class="d-flex gap-2"> <?php $permissions = session()->get('permissions'); ?>
        <?php if (!empty($permissions['Product']['addAccess']) && $permissions['Product']['addAccess'] == 1): ?>
            <a href="<?= base_url('products/addproduct') ?>" class="btn btn-success">
                <i class="fas fa-plus"></i> Add Products
            </a>
        <?php endif; ?>
<!--  <button class="btn btn-danger" id="delete-multiple-btn">
            <i class="fas fa-trash-alt"></i> Delete Selected
        </button> -->
    </div>
</div>
<table id="myTable_product" class="table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <!-- <th></th> -->
            <!-- <th>Product Id</th> -->
            <th>Store Name</th>
            <th>Categoriy Name</th>
            <th>Product Name</th>
            <th>SKU</th>
            <th>Barcode</th>
            <th>Quantity</th>
            <th>Product Image</th>
            <th>Status</th>
            <th>Created By</th>
            <th>Updated By</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <!-- Data will be populated here by DataTables -->
    </tbody>
</table>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    const PRODUCT_DATA_URL = "<?= base_url('products/data') ?>";
    const PRODUCT_UPLOAD_URL = "<?= base_url('uploads/product/') ?>";
    const PRODUCT_ADD_URL = "<?= base_url('products/addproduct/') ?>";
    const PRODUCT_DELETE_URL = "<?= site_url('products/delete') ?>";
    const PRODUCT_FILTER_URL = "<?= base_url('/product/filterByName') ?>";
</script>
<script src="<?= base_url('assets/custom-Js/product.js') ?>"></script>
<?= $this->endSection(); ?>