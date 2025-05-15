<?= $this->extend('pages/layout') ?>
<?= $this->section('content') ?>


<h2>Add Role</h2>
<form id="roleForm" enctype="multipart/form-data">
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php foreach (session()->getFlashdata('errors') as $field => $error): ?>
                <div><strong><?= ucfirst($field) ?>:</strong> <?= esc($error) ?></div>
            <?php endforeach; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <div id="successMessage" class="alert alert-success alert-dismissible fade show d-none" role="alert">
        <span id="successText"></span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <div id="errorMessage" class="alert alert-danger alert-dismissible fade show d-none" role="alert">
        <span id="errorText"></span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
            
    <div class="mb-3">
        <label for="name" class="form-label">Role Name</label>
        <input type="text" class="form-control" id="name" name="name" required>
        <input type="hidden" id="roleId" name="roleId" value="<?= esc($roleId ?? '') ?>">
    </div>

    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select class="form-select" id="status" name="status" required>
            <option value="">Select Status</option>
            <option value="1">Active</option>
            <option value="0">Inactive</option>
        </select>
    </div>
    <h4>Assign Permissions</h4>
    <table id="permisionTable" class="display table table-bordered" style="width: 100%;">
        <thead>
            <tr>
                <th></th>
                <th>Module Name</th>
                <th>View</th>
                <th>Add</th>
                <th>Update</th>
                <th>Delete</th>
                <th>Import</th>
                <th>Export</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <button type="submit" id="savePermissions" class="btn btn-primary mb-4">Save Role</button>
</form>


<?= $this->endSection() ?>


<?= $this->section('scripts') ?>
<script>
    const ROLE_CHECK_URL = "<?= site_url('role/checkRoleName') ?>";
    const ROLE_PEMI_URL = "<?= site_url('role/permissions') ?>";
    const ROLE_URL = "<?= site_url('role') ?>";
</script>
<script src="<?= base_url('assets/custom-Js/addrole.js') ?>"></script>
<?= $this->endSection() ?>