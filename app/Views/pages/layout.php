<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title><?= $title ?? 'Dashboard - SB Admin' ?></title>

    <!-- CSS -->
    <link href="<?= base_url('assets/datatable/css/style.min.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('assets/css/styles.css') ?>" rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap-5.1.3-dist/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/datatable/css/dataTables.dataTables.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/datatable/css/jquery.dataTables.min.css') ?>">

    <!-- FontAwesome -->
    <script src="<?= base_url('assets/fontawesome/js/all.js') ?>" crossorigin="anonymous"></script>

    <?= $this->renderSection('head') ?>
</head>

<body class="sb-nav-fixed">
    <?= $this->include('templates/header') ?>
    <div id="layoutSidenav">    
        <?= $this->include('templates/sidebar') ?>
        <div id="layoutSidenav_content">
            <main class="container-fluid px-4 mt-4">
                <?= $this->renderSection('content') ?>
            </main>
            <?= $this->include('templates/footer') ?>
        </div>
    </div>

    <!-- JS -->
    <script src="<?= base_url('assets/jquery/js/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/bootstrap-5.1.3-dist/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('assets/bootstrap-5.1.3-dist/js/scripts.js') ?>"></script>
    <script src="<?= base_url('assets/datatable/js/simple-datatables.min.js') ?>"></script>
    <script src="<?= base_url('assets/datatable/js/datatables.min.js') ?>"></script>

    <?= $this->renderSection('scripts') ?>
</body>
</html>
