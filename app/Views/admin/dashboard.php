<?= $this->extend('layout/user_template'); ?>

<?= $this->section('content'); ?>
<!-- Main Content -->
<div id="content">

    <?= $this->include('layout/topbarAdmin'); ?>

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

        <div class="dropdown-divider mb-3"></div>

        <!-- Content Row -->
        <div class="row">

            <!-- Car Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <a href="/admin/car" class="text-decoration-none">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Data Mobil</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $car; ?> Mobil</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-car fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Renter Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <a href="/admin/renter" class="text-decoration-none">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Data Penyewa</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $renterAccount; ?> Penyewa</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Rental Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <a href="/admin/rental" class="text-decoration-none">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Data Penyewaan</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $rental; ?> Penyewaan</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-receipt fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Admin Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <a href="/admin/account" class="text-decoration-none">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Data Admin</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $adminAccount; ?> Admin</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        </div>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?= $this->endSection(); ?>