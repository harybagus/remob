<?= $this->extend('layout/user_template'); ?>

<?= $this->section('content'); ?>
<!-- Main Content -->
<div id="content">

    <!-- Topbar -->
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

        <!-- Sidebar Toggle (Topbar) -->
        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars text-info"></i>
        </button>

        <!-- Topbar Navbar -->
        <ul class="navbar-nav ml-auto">

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $account['name']; ?></span>
                    <img class="img-profile rounded-circle" src="/assets/img/profile/<?= $account['image']; ?>">
                </a>
                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="/admin/account">
                        <i class="fas fa-users-cog fa-sm fa-fw mr-2 text-gray-400"></i>
                        Kelola Akun
                    </a>
                    <a class="dropdown-item" href="/admin/change-password">
                        <i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>
                        Ubah Password
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="/auth/logout" data-toggle="modal" data-target="#logoutModal">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </a>
                </div>
            </li>

        </ul>

    </nav>
    <!-- End of Topbar -->

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h3 class="mb-4 text-gray-800"><?= $title; ?></h3>

        <div class="dropdown-divider mb-3"></div>

        <div class="row row-cols-1 row-cols-md-3">
            <?php foreach ($car as $car) : ?>
                <div class="col mb-4">
                    <div class="card border-info">
                        <div class="card-header">
                            <h6 class="float-left pt-2"><?= $car['name']; ?></h6>
                            <div class="float-right">
                                <a href="/renter/rental-car/<?= $car['id']; ?>" class="btn btn-info">
                                    Sewa
                                </a>
                            </div>
                        </div>
                        <div class="col-md">
                            <img src="/assets/img/car/<?= $car['image']; ?>" alt="<?= $car['name']; ?>" class="img-thumbnail mt-3 mb-2">
                        </div>
                        <div class="col-md">
                            <table class="table table-sm table-borderless">
                                <tbody>
                                    <tr>
                                        <td>Merk</td>
                                        <td>:</td>
                                        <th><?= $car['merk']; ?></th>
                                    </tr>
                                </tbody>
                                <tbody>
                                    <tr>
                                        <td>Nomor polisi</td>
                                        <td>:</td>
                                        <th><?= $car['license_plate']; ?></th>
                                    </tr>
                                </tbody>
                                <tbody>
                                    <tr>
                                        <td>Jumlah kursi</td>
                                        <td>:</td>
                                        <th><?= $car['seat']; ?></th>
                                    </tr>
                                </tbody>
                                <tbody>
                                    <tr>
                                        <td>Tahun produksi</td>
                                        <td>:</td>
                                        <th><?= $car['production_year']; ?></th>
                                    </tr>
                                </tbody>
                                <tbody>
                                    <tr>
                                        <td>Harga sewa / hari</td>
                                        <td>:</td>
                                        <th><?= formatRupiah($car['rental_price_per_day']); ?></th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?= $this->endSection(); ?>