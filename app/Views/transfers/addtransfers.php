<?= $this->extend('pages/layout'); ?>
<?= $this->section('content'); ?>
<h2>Transfer Product</h2>
<form id="transferForm">
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="fromStoreId" class="form-label">From Store</label>
            <select name="fromStoreId" id="fromStoreId" class="form-select" required>
                <option value="">-- Select From Store --</option>
                <?php foreach ($stores as $store): ?>
                    <option value="<?= $store['store_id'] ?>"><?= esc($store['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6">
            <label for="toStoreId" class="form-label">To Store</label>
            <select name="toStoreId" id="toStoreId" class="form-select" required>
                <option value="">-- Select To Store --</option>
                <?php foreach ($stores as $store): ?>
                    <option value="<?= $store['store_id'] ?>"><?= esc($store['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="specialNotes" class="form-label">Special Notes</label>
            <input type="text" class="form-control" id="specialNotes" name="specialNotes" placeholder="Enter any notes" required>
        </div>
        <div class="col-md-6">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status" required>
                <option value="">-- Select Status --</option>
                <option value="0">Pending</option>
                <option value="1">Send</option>
            </select>
        </div>
    </div>

    <table class="table" id="productTable">
        <thead>
            <tr>
                <th>Product</th>
                <th>Available Quantity</th>
                <th>Transfer Quantity</th>
                <th><button type="button" id="addRow" class="btn btn-success btn-sm">Add</button></th>
            </tr>
        </thead>
        <tbody id="productTableBody">
            <tr>
                <td>
                    <select name="products[0][product_id]" class="form-control product-select" data-index="0">
                        <option value="">-- Select Product --</option>
                        <?php foreach ($products as $product): ?>
                            <option value="<?= $product['product_id'] ?>"><?= esc($product['productName']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <input type="text" name="products[0][available_quantity]" class="form-control available-qty" data-index="0" readonly>
                </td>
                <td>
                    <input type="number" name="products[0][quantity]" class="form-control" required min="1">
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm removeRow">Remove</button>
                </td>
            </tr>
        </tbody>
    </table>

    <button type="submit" id="transfer" class="btn btn-primary">Transfer</button>
</form>
<?= $this->endSection(); ?>


<?= $this->section('scripts'); ?>
<script>
    const TRANSFER_DATA_URL = "<?= base_url('transfer/data') ?>";
    const TRANSFER_GET_URL = "<?= base_url('transfer/getProductQuantity') ?>";
    const TRANSFER_CHECK_URL = "<?= base_url('transfer/checkProductInStore') ?>";
    const TRANSFER_PRO_URL = "<?= base_url('transfer/processTransfer') ?>";
    const TRANSFER_UPDATE_URL = "<?= base_url('employee/update') ?>/";
    const TRANSFER_ADD_URL = "<?= base_url('employee/addemployee') ?>";
    const TRANSFER_DELETE_URL = "<?= base_url('employee') ?>";
    
    const GET_PRODUCTS_BY_STORE_URL = "<?= base_url('transfer/getProductsByStore') ?>";

    const PRODUCT_OPTIONS = `<?php foreach ($products as $product): ?>
        <option value="<?= $product['product_id'] ?>"><?= esc($product['productName']) ?></option>
    <?php endforeach; ?>`;
</script>
<script src="<?= base_url('assets/custom-Js/addtransfers.js') ?>"></script>
<?= $this->endSection(); ?>