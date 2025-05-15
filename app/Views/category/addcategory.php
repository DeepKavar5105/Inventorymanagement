<?= $this->extend('pages/layout'); ?>
<?= $this->section('content'); ?>
<h2><?= isset($category) ? 'Edit' : 'Add' ?> category</h2>
<form method="post" id="categoryForm" enctype="multipart/form-data">
    <?php if (isset($category)): ?>
        <input type="hidden" id="cat_id" name="cat_id" value="<?= esc($category['cat_id']) ?>">
    <?php endif; ?>
    <div class="mb-3">
        <label class="form-label">Store Name</label>
        <select name="storeId" id="storeId" class="form-control" required>
            <option value="">-- Select Store --</option>
            <?php foreach ($store as $row) : ?>
                <option value="<?= esc($row['store_id']) ?>"
                    <?= isset($category) && $category['storeId'] == $row['store_id'] ? 'selected' : '' ?>>
                    <?= esc($row['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <span class="text-danger error-storeId"></span>
    </div>            
    <div class="mb-3">
        <label>Category Name</label>
        <input type="text" id="catName" name="catName" class="form-control" value="<?= esc($category['catName'] ?? '') ?>" required>
        <span class="text-danger error-catName"></span>
    </div>

    <div class="mb-3">
        <label>Status</label>
        <select id="status" name="status" class="form-select" required>
            <option value="1" <?= (isset($category) && $category['status'] == 1) ? 'selected' : '' ?>>Active</option>
            <option value="0" <?= (isset($category) && $category['status'] == 0) ? 'selected' : '' ?>>Inactive</option>
        </select>
        <span class="text-danger error-status"></span>
    </div>
    <button type="submit" id="categorybtn" class="btn btn-primary">
        <?= isset($category) ? 'Update' : 'Add' ?> Category
    </button>
</form>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    const CAT_UPDATE_URL = "<?= base_url('category/update/') ?>";
    const CAT_ADD_URL = "<?= base_url('category/addcategory') ?>";
    const CAT_URL = "<?= base_url('category') ?>";
</script>
<script src="<?= base_url('assets/custom-Js/addcategory.js') ?>"></script>
<?= $this->endSection(); ?>