<?= $this->extend('pages/layout'); ?>
<?= $this->section('content'); ?>

<h2>Edit Role</h2>
<form id="roleForm">
    <div class="mb-3">
        <label for="edit_name" class="form-label">Role Name</label>
        <input type="text" class="form-control" id="edit_name" name="edit_name" required>
        <input type="hidden" id="editRoleId" name="editRoleId" value="<?= esc($roleId ?? '') ?>">
        <span class="text-danger error-edit_name"></span>
    </div>

    <div class="mb-3">
        <label for="edit_status" class="form-label">Status</label>
        <select class="form-select" id="edit_status" name="edit_status" required>
            <option value="">Select Status</option>
            <option value="1">Active</option>
            <option value="0">Inactive</option>
        </select>
        <span class="text-danger error-edit_status"></span>
    </div>

    <h4>Assign Permissions</h4>
    <table id="permisionTable" class="table table-bordered">
        <thead>
            <tr> 
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

    <button type="submit" id="EditPermissions" class="btn btn-primary mb-4">Update Role</button>
</form>
<?= $this->endsection(); ?>

<?= $this->section('scripts') ?>
<script>
    const ROLE_GET_URL = "<?= base_url('role/getEditRoleData') ?>/";
    const ROLE_UPDATEPER_URL = "<?= base_url('role/updatePermissions') ?>";
    const ROLE_URL = "<?= base_url('role') ?>";
</script>
<script src="<?= base_url('assets/custom-Js/aditrole.js') ?>"></script>
<?= $this->endSection() ?>