<?= $this->extend('pages/layout'); ?>
<?= $this->section('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="mt-4 ">Transfer info</h1>
    <div class="d-flex gap-2"> <?php $permissions = session()->get('permissions'); ?>
        <?php $permissions = session()->get('permissions'); ?>
        <?php if (!empty($permissions['Transfers']['addAccess']) && $permissions['Transfers']['addAccess'] == 1): ?>
            <a href="<?= base_url('addtransfers') ?>"> <button class='edit_btn btn btn-outline-success'>Transfer Product</button></a>
        <?php endif; ?>
    </div>
</div>
<table id="myTable_transfers">
    <thead>
        <tr>
            <!-- <th>Transfers Id</th> -->
            <th>FromStore Name</th>
            <th>ToStore Name</th>
            <th>Special Notes</th>
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
    const TRANSFER_DATA_URL = "<?= base_url('transfers/data') ?>";
    const TRANSFER_DELETE_URL = "<?= site_url('transfer/delete') ?>";
</script>
<script src="<?= base_url('assets/custom-Js/transfers.js') ?>"></script>
<?= $this->endSection(); ?>