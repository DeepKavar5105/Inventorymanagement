<?= $this->extend('pages/layout'); ?>
<?= $this->section('content'); ?>
<div class="d-flex justify-content-between align-items-center mt-4 mb-3">
    <h2 class="mb-0">Category info</h2>
    <div class="d-flex gap-2">
        <?php $permissions = session()->get('permissions'); ?>
        <?php if (!empty($permissions['Categories']['addAccess']) && $permissions['Categories']['addAccess'] == 1): ?>
            <a href="<?= base_url('category/addcategory') ?>" class="btn btn-success">
                <i class="fas fa-plus"></i> Add Category
            </a>
        <?php endif; ?>
        <!-- <button class="btn btn-danger" id="delete-multiple-category-btn">
                                <i class="fas fa-trash-alt"></i> Delete Selected 
                            </button> -->
    </div>
</div>

<table id="myTable_cateogory" class="table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <!-- <th></th> -->
            <!-- <th>Category Id</th> -->
            <th>Store Name</th>
            <th>category Name</th>
            <th>Status</th>
            <th>Created By</th>
            <th>Updated By</th>
            <!-- <th>Deleted By</th> -->
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <!-- Data will be populated here by DataTables -->
    </tbody>
</table>
<!-- <div class="modal" id="Modal_category" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Category Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="category_form" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="catName" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="catName" name="catName" required>
                        <input type="hidden" name="category_id" id="category_id">
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="category_model_status" name="category_model_status" required>
                            <option value="">Select Status</option>
                            <option value="1">Active</option>
                            <option value="0">InActive</option>
                        </select>
                    </div>

                    <button type="submit" id="update-btn-category" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div> -->

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    const CAT_DATA_URL = "<?= site_url('category/data') ?>";
    const CAT_ADD_URL = "<?= base_url('category/addcategory/') ?>";
    const CAT_DELETE_URL = "<?= site_url('category/delete') ?>";
</script>
<script src="<?= base_url('assets/custom-Js/category.js') ?>"></script>
<?= $this->endSection(); ?>

</html>