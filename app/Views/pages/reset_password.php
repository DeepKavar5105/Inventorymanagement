<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reset Password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- <link href="assets/bootstrap-5.1.3-dist/css/bootstrap.min.css"" rel="stylesheet"> -->
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">

      <div class="card shadow rounded-4">
        <div class="card-body p-4">
          <h4 class="card-title text-center mb-4">Reset Your Password</h4>

          <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
              <?= session()->getFlashdata('error') ?>
            </div>
          <?php endif; ?>

          <form method="post" action="<?= base_url('reset-password') ?>">
            <?= csrf_field() ?>
            <input type="hidden" name="token" value="<?= esc($token) ?>" />

            <div class="mb-3">
              <label for="password" class="form-label">New Password</label>
              <input type="password" name="password" id="password" class="form-control" placeholder="Enter new password" required>
            </div>

            <div class="mb-3">
              <label for="confirm_password" class="form-label">Confirm Password</label>
              <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm new password" required>
            </div>

            <div class="d-grid">
              <button type="submit" class="btn btn-success">Reset Password</button>
            </div>
          </form>

          <div class="text-center mt-3">
            <a href="<?= base_url('/login') ?>">Back to Login</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- <script src="assets/bootstrap-5.1.3-dist/js/bootstrap.bundle.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

