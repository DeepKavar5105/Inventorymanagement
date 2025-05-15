<?= $this->extend('pages/layout'); ?>
<?= $this->section('content'); ?>

<h2>Add Employee</h2>
<div class="container mt-5">
    <div class="card shadow-lg rounded-4 p-4">
        <h4 class="mb-4">Upload CSV File </h4>

        <form id="csv-upload-form" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="csv_file" class="form-label">Choose CSV File</label>
                <input type="file" class="form-control" name="csv_file" id="csv_file" accept=".csv" required>
                <div id="message" class="form-text text-danger mt-1"></div>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-upload"></i> Upload
                </button>

                <button id="ajaxDownloadBtn" type="button" class="btn btn-primary">
                    <i class="bi bi-download"></i> Download Sample CSV
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection(); ?>
<?= $this->section('scripts'); ?>
<script>
    const EMPLOYEE_SAMPLE_URL = "<?= base_url('sample/generate-csv') ?>";
    const EMPLOYEE_DOWN_URL = "<?= base_url('sample/download-csv') ?>";
    const EMPLOYEE_UPLODE_URL = '<?= base_url("employee/upload_csv"); ?>';
</script>
<script src="<?= base_url('assets/custom-Js/addemployee.js') ?>"></script>
<?= $this->endSection(); ?>