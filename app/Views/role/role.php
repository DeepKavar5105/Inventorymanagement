<?= $this->extend('pages/layout'); ?>
<?= $this->section('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">Role Info</h2>
    <div class="d-flex gap-2"> <?php $permissions = session()->get('permissions'); ?>
        <?php if (!empty($permissions['Role']['addAccess']) && $permissions['Role']['addAccess'] == 1): ?>
            <a href="<?= base_url('addrole') ?>" class="btn btn-success">
                <i class="fas fa-plus"></i> Add Role
            </a>
        <?php endif; ?>
        <!-- Uncomment for multiple delete -->
        <!-- <button class="btn btn-danger" id="delete-multiple-employee-btn">
            <i class="fas fa-trash-alt"></i> Delete Selected
        </button> -->
    </div>
</div>

<table id="myTable" class="table table-striped">
    <thead>
        <tr>
            <!-- <th><input type="checkbox" id="select-all"></th> -->
            <!-- <th>Role ID</th> -->
            <th>Name</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <!-- DataTables populates this -->
    </tbody>
</table>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    const ROLE_DATA_URL = "<?= site_url('role/data') ?>";
    const ROLE_DELETE_URL = "<?= site_url('role/delete') ?>";
    const ROLE_EDIT_BASE_URL = "<?= base_url('role/edit/') ?>";
</script>
<script src="<?= base_url('assets/custom-Js/role.js') ?>"></script>
<?= $this->endSection(); ?>