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

        <?php if (session()->getFlashdata('successMessage')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('successMessage'); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <table class="table table-hover text-center">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Nama Penyewa</th>
                    <th scope="col">Nama Mobil</th>
                    <th scope="col">Harga Sewa / Hari</th>
                    <th scope="col">Total Harga Sewa</th>
                    <th scope="col">Awal Sewa</th>
                    <th scope="col">Akhir Sewa</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($rental as $rental) : ?>
                    <?php
                    $db = db_connect();
                    $queryCar = "SELECT * FROM `car` WHERE `id` = ?";
                    $queryRenter = "SELECT * FROM `renter` WHERE `id` = ?";

                    $car = $db->query($queryCar, $rental['car_id'])->getRowArray();
                    $renter = $db->query($queryRenter, $rental['renter_id'])->getRowArray();
                    ?>
                    <tr>
                        <th scope="row"><?= $i++; ?></th>
                        <td><?= $renter['name']; ?></td>
                        <td><?= $car['name']; ?></td>
                        <td><?= formatRupiah($rental['rental_price_per_day']); ?></td>
                        <?php if ($rental['total_rental_price'] == 0) : ?>
                            <td><?= 'Rp---.---' ?></td>
                        <?php else : ?>
                            <td><?= formatRupiah($rental['total_rental_price']); ?></td>
                        <?php endif; ?>
                        <td><?= date('d F Y', strtotime($rental['rental_start'])); ?></td>
                        <?php if ($rental['rental_end'] == '0000-00-00') : ?>
                            <td><?= '-- -- --'; ?></td>
                        <?php else : ?>
                            <td><?= date('d F Y', strtotime($rental['rental_end'])); ?></td>
                        <?php endif; ?>
                        <?php if ($rental['status'] == 0) : ?>
                            <td>Belum dikembalikan</td>
                            <td><a href="/admin/car-return/<?= $rental['id']; ?>" class="btn btn-dark">Pengembalian</a></td>
                        <?php elseif ($rental['status'] == 1) : ?>
                            <td>Sudah dikembalikan</td>
                            <td><button class="btn btn-dark" data-toggle="modal" data-target="#hasBeenReturnedModal">Pengembalian</button></td>
                        <?php else : ?>
                            <td>Sudah dibayar</td>
                            <td><button class="btn btn-dark" data-toggle="modal" data-target="#hasBeenReturnedModal">Pengembalian</button></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Has Been Returned Modal-->
<div class="modal fade" id="hasBeenReturnedModal" tabindex="-1" role="dialog" aria-labelledby="hasBeenReturnedModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hasBeenReturnedModalLabel">Mobil sudah dikembalikan!</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>