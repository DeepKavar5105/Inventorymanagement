<?= $this->extend('pages/layout'); ?>
<?= $this->section('content'); ?>
<h3 class="mb-4"> Receive Product Items</h3>

<?php foreach ($received as $index => $row): ?>
    <div class="card">
        <div class="card-body">
            <input type="hidden" name="transfer_item_id[]" value="<?= esc($row['transfer_item_id']) ?>">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">From Store</label>
                    <select name="fromstoreId[]" class="form-select" disabled>
                        <option value="">-- Select Store --</option>
                        <?php foreach ($stores as $store): ?>
                            <option value="<?= esc($store['store_id']) ?>" <?= ($store['store_id'] == $tranfer['fromStoreId']) ? 'selected' : '' ?>>
                                <?= esc($store['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Product</label>
                    <select name="product[]" class="form-select" disabled>
                        <option value="">-- Select Product --</option>
                        <?php foreach ($product as $prod): ?>
                            <option value="<?= esc($prod['product_id']) ?>" <?= ($prod['product_id'] == $row['productId']) ? 'selected' : '' ?>>
                                <?= esc($prod['productName']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Quantity</label>
                    <input type="number" class="form-control" name="quantity[]" value="<?= esc($row['transferQuantity']) ?>" min="1" readonly>
                </div>

                <div class="col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-success w-100 receive-btn" data-tid="<?= esc($row['transfer_item_id']) ?>">
                        Receive
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    const REC_ADD_URL = "<?= base_url('receiveItems/addreceiveItems/') ?>";
</script>
<script src="<?= base_url('assets/custom-Js/select-store.js') ?>"></script>
<?= $this->endSection(); ?>
