<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forgot Password</title>
  <link href="assets/bootstrap-5.1.3-dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">

      <div class="card shadow rounded-4">
        <div class="card-body p-4">
          <h4 class="card-title text-center mb-4">Forgot Password</h4>

          <?php if (session()->getFlashdata('message')): ?>
            <div class="alert alert-success">
              <?= session()->getFlashdata('message') ?>
            </div>
          <?php endif; ?>

          <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
              <?= session()->getFlashdata('error') ?>
            </div>
          <?php endif; ?>

          <form method="post" action="<?= base_url('send-reset-link') ?>">
            <?= csrf_field() ?>

            <div class="mb-3">
              <label for="email" class="form-label">Email Address</label>
              <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
            </div>

            <div class="d-grid">
              <button type="submit" class="btn btn-primary">Send Reset Link</button>
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

<script src="assets/bootstrap-5.1.3-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
