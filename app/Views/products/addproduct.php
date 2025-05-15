<?= $this->extend('pages/layout'); ?>
<?= $this->section('content'); ?>
<h2><?= isset($product) ? 'Edit' : 'Add' ?> Product</h2>
<form method="post" id="productForm" enctype="multipart/form-data">

    <?php if (isset($product)): ?>
        <input type="hidden" name="product_id" id="product_id" value="<?= esc($product['product_id']) ?>">
    <?php endif; ?>

    <div class="mb-3">
        <label class="form-label">Store Name</label>
        <select name="storeId" id="storeId" class="form-control" required>
            <option value="">-- Select Store --</option>
            <?php foreach ($stores as $row) : ?>
                <option value="<?= esc($row['store_id']) ?>"
                    <?= isset($product) && $product['storeId'] == $row['store_id'] ? 'selected' : '' ?>>
                    <?= esc($row['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <span class="text-danger error-storeId"></span>
    </div>

    <div class="mb-3">
        <label class="form-label">Category Name</label>
        <select name="categoryId" id="categoryId" class="form-control" required>
            <option value="">-- Select Category --</option>
            <?php foreach ($categories as $row) : ?>
                <option value="<?= esc($row['cat_id']) ?>"
                    <?= isset($product) && $product['categoryId'] == $row['cat_id'] ? 'selected' : '' ?>>
                    <?= esc($row['catName']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <span class="text-danger error-categoryId"></span>
    </div>
    <div class="mb-3">
        <label class="form-label">Product Name</label>
        <input class="form-control" type="text" name="productName" id="productName" value="<?= isset($product) ? esc(data: $product['productName']) : '' ?>" required>

        <span class="text-danger error-productName"></span>
    </div>
    <div class="mb-3">
        <label for="sku" class="form-label">SKU</label>
        <input type="text" class="form-control" id="sku" name="sku"
            value="<?= isset($product) ? esc(data: $product['sku']) : '' ?>" required>
        <span class="text-danger error-sku"></span>
    </div>

    <div class="mb-3">
        <label for="barcode" class="form-label">Barcode</label>
        <input type="text" class="form-control" id="barcode" name="barcode"
            value="<?= isset($product) ? esc($product['barcode']) : '' ?>" required>
        <span class="text-danger error-barcode"></span>
    </div>

    <div class="mb-3">
        <label for="quantity" class="form-label">Product Quantity</label>
        <input type="number" class="form-control" name="quantity" id="quantity"
            value="<?= isset($product) ? esc($product['quantity']) : '' ?>">
        <span class="text-danger error-quantity"></span>
    </div>

    <div class="mb-3">
        <label for="productImage" class="form-label">Product Image</label>
        <input type="file" class="form-control" id="productImage" name="productImage" <?= isset($product) ? '' : 'required' ?>>
        <?php if (!empty($product['productImage'])): ?>
            <div class="form-text mt-1">
                <strong>Current file:</strong> <?= esc($product['productImage']) ?>
            </div>
        <?php endif; ?>
        <span class="text-danger error-productImage"></span>
    </div>

    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select class="form-select" id="product_status" name="product_status" required>
            <option value="">Select Status</option>
            <option value="1" <?= isset($product) && $product['status'] == '1' ? 'selected' : '' ?>>Active</option>
            <option value="0" <?= isset($product) && $product['status'] == '0' ? 'selected' : '' ?>>Inactive</option>
        </select>
        <span class="text-danger error-product_status"></span>
    </div>

    <!-- <div class="mb-3">
        <label class="form-label">Created By</label>
        <select name="created_By" id="created_By" class="form-control" required>
            <option value="">-- Created By --</option>
        </select>
        <span class="text-danger error-created_By"></span>
    </div> -->

    <button type="submit" class="btn btn-primary" id="addproduct"><?= isset($product) ? 'Update' : 'Add' ?> Product</button>
</form>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    const PRODUCT_UPDATE_URL = "<?= base_url('products/update') ?>/";
    const PRODUCT_ADD_URL = "<?= base_url('products/addproduct/') ?>";
    const PRODUCT_URL = "<?= base_url('products') ?>";
</script>
<script src="<?= base_url('assets/custom-Js/addproduct.js') ?>"></script>

<?= $this->endSection(); ?> 