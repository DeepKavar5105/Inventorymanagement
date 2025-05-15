<?= $this->extend('pages/layout'); ?>
<?= $this->section('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="mt-4 ">Receive Items</h1>
    <div class="d-flex gap-2">
        <label for="toStoreId" class="form-label">To Store</label>
        <select name="toStoreId" id="toStoreId" class="form-select" required>
            <option value="">-- Select To Store --</option>
            <?php foreach ($tranfers as $row) : ?>
                <?php if ($row['status'] != 2) : ?>
                    <option value="<?= esc($row['transfers_id']) ?>">
                        <?= esc($row['name']) ?>
                    </option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<a href="<?= base_url('receiveItems/addreceiveItems') ?>"></a>
<table id="transferItemTable">
    <thead>
        <tr>
            <!-- <th></th> -->
            <!-- <th>Receive Item Id</th> -->
            <th>Product Name</th>
            <th>Receive Quantity</th>
            <th>Notes</th>
            <th>Received Message</th>
            <th>Status</th>
            <th>Created_By</th>
            <th>Updated_By</th>
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
    const REC_DATA_URL = "<?= base_url('receiveItems/data') ?>";
    const REC_GOTO_URL = "<?= base_url('receiveitem/goToStore') ?>/";
    const RECEIVE_DELETE_URL = "<?= base_url('receiveItems/delete') ?>";
</script>
<script src="<?= base_url('assets/custom-Js/receiveItem.js') ?>"></script>
<?= $this->endSection(); ?>