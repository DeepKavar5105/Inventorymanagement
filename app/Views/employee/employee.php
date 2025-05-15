<?= $this->extend('pages/layout'); ?>
<?= $this->section('content'); ?>
<div class="d-flex justify-content-between align-items-center mt-4 mb-3">
    <h2 class="mb-0">Employee Info</h2>
    <div class="d-flex gap-2">
        <?php $permissions = session()->get('permissions'); ?>
        <?php if (!empty($permissions['Employee']['addAccess']) && $permissions['Employee']['addAccess'] == 1): ?>
            <a href="<?= base_url('employee/addemployee') ?>" class="btn btn-success">
                <i class="fas fa-plus"></i> Add Employee
            </a>
        <?php endif; ?>
          <a href="<?= base_url('employee/addmultipalemployee') ?>" class="btn btn-success">
                <i class="fas fa-plus"></i> Add Multipal Employee
            </a>    

        <!-- <button class="btn btn-danger" id="delete-multiple-employee-btn">
                                <i class="fas fa-trash-alt"></i> Delete Selected
                            </button> -->

    </div>
</div>

<!-- Filter Form -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="post" action="<?= base_url('employee/search') ?>">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="empName" class="form-label">Employee Name</label>
                    <input type="search" name="empName" id="empName" class="form-control" placeholder="Enter name">
                </div>
                <div class="col-md-3">
                    <label for="empEmail" class="form-label">Employee Email</label>
                    <input type="search" name="empEmail" id="empEmail" class="form-control" placeholder="Enter email">
                </div>
                <div class="col-md-3">
                    <label for="empMobile" class="form-label">Mobile Number</label>
                    <input type="search" name="empMobile" id="empMobile" class="form-control" placeholder="Enter mobile number">
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-select">
                        <option value=""> --Select Status --</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <div class="col-md-9">
                    <button type="submit" class="btn btn-primary mt-3">
                        <i class="fas fa-search me-1"></i> Filter
                    </button>
                    <a href="<?= base_url('employee') ?>" class="btn btn-secondary mt-3">
                        <i class="fas fa-undo me-1"></i> Reset
                    </a>
                </div>

                <div class="col-md-3 ">
                    <button type="button" id="Export" class="btn btn-outline-success mt-3 w-100">
                        <i class="fas fa-file-excel me-1"></i> Export to Excel
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="table-responsive">
    <table id="myTable" class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <!-- <th><input type="checkbox" id="select-all"></th> -->
                <!-- <th>Emp ID</th> -->
                <th>Employee Code</th>
                <th>Store Name</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Profile</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Populated by DataTables -->
        </tbody>
    </table>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    const EMPLOYEE_DATA_URL = "<?= base_url('employee/data') ?>";
    const EMPLOYEE_PROFILE_URL = "<?= base_url('uploads/profile/') ?>";
    const EMPLOYEE_ADD_URL = "<?= base_url('employee/addemployee/') ?>";
    const EMPLOYEE_DELETE_URL = "<?= site_url('employee/delete') ?>";
    const EMPLOYEE_DOWN_URL = "<?= site_url('check-before-download') ?>";
    const EMPLOYEE_CSV_URL = "<?= site_url('download-csv') ?>";
</script>
<script src="<?= base_url('assets/custom-Js/employee.js') ?>"></script>
<?= $this->endSection(); ?>