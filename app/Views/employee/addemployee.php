<?= $this->extend('pages/layout'); ?>
<?= $this->section('content'); ?>

<h2><?= isset($employee) ? 'Edit' : 'Add' ?> Employee</h2>
<form method="post" id="employeeForm" enctype="multipart/form-data">
    <input type="hidden" id="editempId" name="editempId" value="<?= esc($employee['emp_id'] ?? '') ?>">
    <div class="mb-3">
        <label class="form-label">Store Name</label>
        <select name="accessStoreId" id="accessStoreId" class="form-control" required>
            <option value="">-- Select Store --</option>
            <?php foreach ($stores as $row) : ?>
                <option value="<?= esc($row['store_id']) ?>" <?= (isset($employee) && $employee['accessStoreId'] == $row['store_id']) ? 'selected' : '' ?>>
                    <?= esc($row['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="rolename">Role Name</label>
        <select name="rolename" id="rolename" class="form-control">
            <option value="">-- Select Role --</option>
            <?php foreach ($roles as $row) : ?>
                <option value="<?= esc($row['role_id']) ?>" <?= (isset($employee) && $employee['role_id'] == $row['role_id']) ? 'selected' : '' ?>>
                    <?= esc($row['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="code" class="form-label">Employee Code</label>
        <input type="text" class="form-control" id="code" name="code" value="<?= esc($employee['employee_code'] ?? '') ?>" required>
        <span class="text-danger error-code"></span>
    </div>
    <div class="mb-3">
        <label for="empname" class="form-label">Employee Name</label>
        <input type="text" class="form-control" id="empname" name="empname" value="<?= esc($employee['empname'] ?? '') ?>" required>
        <span class="text-danger error-empname"></span>
    </div>

    <div class="mb-3">
        <label for="email_emp" class="form-label">Email</label>
        <input type="email" class="form-control" id="email_emp" name="email" value="<?= esc($employee['email'] ?? '') ?>" required>
        <span class="text-danger error-email"></span>
    </div>
    <?php if (!isset($employee)): ?>
        <div class="mb-3">
            <label for="password_emp" class="form-label">Password</label>
            <input type="password" class="form-control" id="password_emp" name="password" <?= isset($employee) ? '' : 'required' ?>>
        </div>
    <?php endif; ?>
    <div class="mb-3">
        <label for="mobile" class="form-label">Mobile</label>
        <input type="text" class="form-control" id="mobile" name="mobile" pattern="\d{10}" maxlength="10" value="<?= esc($employee['mobile'] ?? '') ?>" required>
        <span class="text-danger error-mobile"></span>
    </div>

    <div class="mb-3">
        <label for="profile" class="form-label">Profile</label>
        <input type="file" class="form-control" id="profile" name="profile" <?= isset($employee) ? '' : 'required' ?>>

        <?php if (!empty($employee['profile'])): ?>
            <div class="form-text mt-1">
                <strong>Current file:</strong> <?= esc($employee['profile']) ?>
            </div>
        <?php endif; ?>

        <span class="text-danger error-profile"></span>
    </div>



    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select class="form-select" id="status" name="status" required>
            <option value="">Select Status</option>
            <option value="1" <?= (isset($employee) && $employee['status'] == 1) ? 'selected' : '' ?>>Active</option>
            <option value="0" <?= (isset($employee) && $employee['status'] == 0) ? 'selected' : '' ?>>Inactive</option>
        </select>
    </div>

    <button type="button" id="submitBtn" class="btn btn-primary"><?= isset($employee) ? 'Update' : 'Add' ?> Employee</button>
</form>

<?= $this->endSection(); ?>
<?= $this->section('scripts'); ?>
<script>
    const EMPLOYEE_UPDATE_URL = "<?= base_url('employee/updatedata') ?>/";
    const EMPLOYEE_ADDEMP_URL = "<?= base_url('employee/addemployee') ?>";
    const EMPLOYEE_URL = "<?= base_url('employee') ?>";
    const EMPLOYEE_SAMPLE_URL = "<?= base_url('sample/generate-csv') ?>";
    const EMPLOYEE_DOWN_URL = "<?= base_url('sample/download-csv') ?>";
    const EMPLOYEE_UPLODE_URL = '<?= base_url("employee/upload_csv"); ?>';
</script>
<script src="<?= base_url('assets/custom-Js/addemployee.js') ?>"></script>
<?= $this->endSection(); ?>