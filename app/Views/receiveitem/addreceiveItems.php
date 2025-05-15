<?= $this->extend('pages/layout'); ?>
<?= $this->section('content'); ?>
<h2 class="mb-0">Receive Product</h2>
<div class="card-body">
    <form id="transferForm" class="row g-3">
    <div id="formError" class="alert alert-danger d-none"></div>
        <input type="hidden" id="receiveId" name="receiveId" value="<?= esc($receive['transfer_item_id'] ?? '') ?>">
        <!-- <input type="text" name="toStoreId" id="toStoreId" value=""> -->

        <div class="col-md-6">
            <label for="receiveNotes" class="form-label">Receive Notes</label>
            <input type="text" class="form-control" id="receiveNotes" name="receiveNotes" placeholder="Enter any message" value="<?= esc($receive['receivedMessage'] ?? '') ?>" required>
        </div>
        <div class="col-md-6">
            <label for="rproduct" class="form-label">To Product</label>
            <select name="rproduct" id="rproduct" class="form-select">
                <option value="">-- Select Product --</option>
                <?php foreach ($product as $row) : ?>
                    <option value="<?= esc($row['product_id']) ?>" <?= (isset($receive) && $receive['productId'] == $row['product_id']) ? 'selected' : '' ?>>
                        <?= esc($row['productName']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status" required>
                <option value="" disabled <?= !isset($receive['status']) ? 'selected' : '' ?>>Select Status</option>
                <option value="1" <?= (isset($receive['status']) && $receive['status'] == 1) ? 'selected' : '' ?>>send</option>
                <option value="0" <?= (isset($receive['status']) && $receive['status'] == 0) ? 'selected' : '' ?>>Pending</option>
                <option value="2" <?= (isset($receive['status']) && $receive['status'] == 2) ? 'selected' : '' ?>>Received</option>
                <option value="3" <?= (isset($receive['status']) && $receive['status'] == 3) ? 'selected' : '' ?>>Damage</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="tquantity" class="form-label">Transfer Quantity</label>
            <input type="number" class="form-control" id="tquantity" name="tquantity" value="<?= esc($receive['transferQuantity'] ?? '') ?>" readonly>
        </div>
        <div class="col-md-6">
            <label for="tquantity" class="form-label">Receive Quantity</label>
            <input type="number" class="form-control" id="rquantity" name="rquantity" value="<?= esc($receive['transferQuantity'] ?? '') ?>" require>
        </div>            
        <div class="col-md-6">
            <label for="dquantity" class="form-label">Damage Quantity</label>
            <input type="number" class="form-control" id="dquantity" name="dquantity" placeholder="Enter quantity" required>
        </div>

        <div class="col-12 text-end">
            <button type="submit" id="Received" class="btn btn-success">Received</button>
        </div>
    </form>
</div>
<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    const REC_UPDATE_URL = "<?= base_url('receiveItems/update') ?>";
    const REC_URL = "<?= base_url('receiveItems') ?>";
</script>
<script src="<?= base_url('assets/custom-Js/addreceiveItem.js') ?>"></script>
<?= $this->endSection(); ?>