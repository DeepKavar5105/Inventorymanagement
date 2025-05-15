<?= $this->extend('pages/layout'); ?>
<?= $this->section('content'); ?>

<h2>Create Account</h2>

<form id="registerForm" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="mb-3">
        <label>Name</label>
        <input type="text" class="form-control" name="name" value="<?= old('name') ?>" required>
        <small class="text-danger error-name"></small>
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" class="form-control" name="email" value="<?= old('email') ?>" required>
        <small class="text-danger error-email"></small>
    </div>

    <div class="mb-3">
        <label>Phone</label>
        <input type="text" class="form-control" name="phone" value="<?= old('phone') ?>" required>
        <small class="text-danger error-phone"></small>
    </div>

    <div class="mb-3">
        <label>Profile</label>
        <input type="file" class="form-control" name="profile">
        <small class="text-danger error-profile"></small>
    </div>

    <div class="mb-3">
        <label>Role Name</label>
        <select name="usertype" class="form-control" required>
            <option value="">-- Select Role --</option>
            <?php foreach ($role as $row) : ?>
                <option value="<?= esc($row['role_id']) ?>" <?= old('usertype') == $row['role_id'] ? 'selected' : '' ?>>
                    <?= esc($row['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <small class="text-danger error-usertype"></small>
    </div>

    <div class="mb-3">
        <label>Password</label>
        <input type="password" class="form-control" name="password" placeholder="Create a password">
        <small class="text-danger error-password"></small>
    </div>

    <div class="mb-3">
        <label>Confirm Password</label>
        <input type="password" class="form-control" name="confirm_password" placeholder="Confirm password">
        <small class="text-danger error-confirm_password"></small>
    </div>

    <div class="d-grid">
        <button type="submit" class="btn btn-primary">Create Account</button>
    </div>
</form>

<div id="success-msg" class="text-success mt-3"></div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
$('#registerForm').submit(function(e) {
    e.preventDefault();

    let formData = new FormData(this);
    $('.text-danger').text('');
    $('#success-msg').text('');

    $.ajax({
        url: "<?= base_url('register/save') ?>",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
            console.log(response);
            if (response.status === 'success') {
                $('#success-msg').text(response.message);
                $('#registerForm')[0].reset();
            } else if (response.status === 'error') {
                $.each(response.errors, function(field, message) {
                    $('.error-' + field).text(message);
                });
            }
        },
        error: function(xhr, status, error) {
            alert('An error occurred: ' + error);
        }
    });
});
</script>
<?= $this->endSection(); ?>
