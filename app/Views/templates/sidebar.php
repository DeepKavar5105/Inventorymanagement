<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>

                <a class="nav-link" href="<?= site_url('index') ?>">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>

                <?php if (session()->get('user_type') === 'admin') : ?>
                    <a class="nav-link" href="<?= base_url('register') ?>">Registration</a>
                <?php endif; ?>

                <?php $permissions = session()->get('permissions'); ?>
                <div class="sb-sidenav-menu-heading">Modules</div>
               
                <?php if ((isset($permissions['Role']) && $permissions['Role']['viewAccess'] == 1)) : ?>
                    <a class="nav-link" href="<?= site_url('role') ?>">Role</a>
                <?php endif; ?>

                <?php if ((isset($permissions['Stores']) && $permissions['Stores']['viewAccess'] == 1)) : ?>
                    <a class="nav-link" href="<?= site_url('store') ?>">Stores</a>
                <?php endif; ?>

                <?php if ((isset($permissions['Employee']) && $permissions['Employee']['viewAccess'] == 1)) : ?>
                    <a class="nav-link" href="<?= site_url('employee') ?>">Employees</a>
                <?php endif; ?>

                <?php if ((isset($permissions['Categories']) && $permissions['Categories']['viewAccess'] == 1)) : ?>
                    <a class="nav-link" href="<?= site_url('category') ?>">Categories</a>
                <?php endif; ?>

                <?php if ((isset($permissions['Product']) && $permissions['Product']['viewAccess'] == 1)) : ?>
                    <a class="nav-link" href="<?= site_url('products') ?>">Products</a>
                <?php endif; ?>

                <?php if ((isset($permissions['Transfers']) && $permissions['Transfers']['viewAccess'] == 1)) : ?>
                    <a class="nav-link" href="<?= site_url('transfers') ?>">Transfers</a>
                <?php endif; ?>

                <?php if ((isset($permissions['ReceiveItem']) && $permissions['ReceiveItem']['viewAccess'] == 1)) : ?>
                    <a class="nav-link" href="<?= site_url('receiveItems') ?>">Receive Items</a>
                <?php endif; ?>

                <?php if (session()->get('user_type') === 'employee' && empty(session()->get('role_id'))) : ?>
                    <div class="alert alert-warning mt-3">
                        <strong>Attention:</strong> You haven't been assigned a role yet. Please contact the admin.
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            <?= session()->get('empname') ?>
        </div>
    </nav>
</div>