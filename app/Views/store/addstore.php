<?= $this->extend('pages/layout'); ?>
<?= $this->section('content'); ?>
<div class="container-fluid px-4">
    <h2><?= isset($store) ? 'Edit' : 'Add' ?> store</h2>
    <form method="post" id="storeForm" enctype="multipart/form-data">
        <input type="hidden" id="storeId" name="storeId" value="<?= esc($store['store_id'] ?? '') ?>">

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= esc($store['name'] ?? '') ?>" required>
            <span class="text-danger error-name"></span>
        </div>
        <div class="mb-3">
            <label for="contactNumber" class="form-label">Contact Number</label>
            <input type="text" class="form-control" id="contactNumber" name="contactNumber" value="<?= esc($store['contactNumber'] ?? '') ?>" required>
            <span class="text-danger error-contactNumber"></span>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= esc($store['email'] ?? '') ?>" required>
            <span class="text-danger error-email"></span>
        </div>
        <?php if (!isset($store)): ?>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <span class="text-danger error-password"></span>
            </div>
        <?php endif; ?>

        <!-- <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" value="" required>
            <span class="text-danger error-phone"></span>
        </div> -->
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" id="address" name="address" value="<?= esc($store['address'] ?? '') ?>" required>
            <span class="text-danger error-address"></span>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status" required>
                <option value="" disabled <?= !isset($store['status']) ? 'selected' : '' ?>>Select Status</option>
                <option value="1" <?= (isset($store['status']) && $store['status'] == 1) ? 'selected' : '' ?>>Active</option>
                <option value="0" <?= (isset($store['status']) && $store['status'] == 0) ? 'selected' : '' ?>>Inactive</option>
            </select>
            <span class="text-danger error-status"></span>
        </div>

        <button type="submit" id="storeBtn" class="btn btn-primary"><?= isset($store) ? 'Edit' : 'Add' ?> Store</button>
    </form>
    <?= $this->endSection(); ?>
    <?= $this->section('scripts'); ?>
    <script>
        const STORE_UPDATE_URL = "<?= base_url('store/update') ?>/";
        const STORE_ADDSTORE_URL = "<?= base_url('store/addstore') ?>";
        const STORE_URL = "<?= base_url('store') ?>";
    </script>
    <script src="<?= base_url('assets/custom-Js/addstore.js') ?>"></script>
    <?= $this->endSection(); ?>
    </body>