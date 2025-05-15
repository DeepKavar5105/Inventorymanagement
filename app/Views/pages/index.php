<?= $this->extend('pages/layout'); ?>
<?= $this->section('content'); ?>

<?php if ($showRoleAlert): ?>
    <div class="alert alert-warning text-center">
        You don’t have any role assigned yet. Please contact admin to assign one.
    </div>
<?php endif; ?>
<h1 class="mt-4">Dashboard</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Dashboard</li>
</ol>

<div class="alert alert-info" role="alert">
    <h4 class="alert-heading">
        Welcome <?= ucfirst(session('user_type')) ?>!
    </h4>
</div>  

<div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-dark mb-4">
                    <div class="card-body">
                        Total Products: <?= $totalProducts; ?>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-dark mb-4">
                    <div class="card-body">
                        Total Stores: <?= $totalStores; ?>
                    </div>
                </div>
            </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-success text-dark mb-4">
            <div class="card-body">Success Card</div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-6">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-chart-area me-1"></i>
                Area Chart Example
            </div>
            <div class="card-body">
                <canvas id="myAreaChart" width="100%" height="40"></canvas>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-chart-bar me-1"></i>
                Bar Chart Example
            </div>
            <div class="card-body">
                <canvas id="myBarChart" width="100%" height="40"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        DataTable Example
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Office</th>
                    <th>Age</th>
                    <th>Start date</th>
                    <th>Salary</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Office</th>
                    <th>Age</th>
                    <th>Start date</th>
                    <th>Salary</th>
                </tr>
            </tfoot>
            <tbody>
                <tr>
                    <td>Tiger Nixon</td>
                    <td>System Architect</td>
                    <td>Edinburgh</td>
                    <td>61</td>
                    <td>2011/04/25</td>
                    <td>$320,800</td>
                </tr>
                <tr>
                    <td>Donna Snider</td>
                    <td>Customer Support</td>
                    <td>New York</td>
                    <td>27</td>
                    <td>2011/01/25</td>
                    <td>$112,000</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection(); ?>
<?= $this->section('scripts'); ?>
<script src="js/scripts.js"></script>
<?= $this->endSection(); ?>