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

        <?php if (session()->getFlashdata('_ci_validation_errors')) : ?>
            <div class="col-sm-7 alert alert-danger alert-dismissible fade show" role="alert">
                <h4>Kesalahan</h4>
                <ul>
                    <?php foreach (session()->getFlashdata('_ci_validation_errors') as $error) : ?>
                        <li>
                            <?= $error; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <form action="/admin/car/add" method="post" enctype="multipart/form-data" autocomplete="off">
            <?= csrf_field(); ?>
            <div class="row mb-3">
                <label for="name" class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="name" name="name" value="<?= old('name'); ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label for="merk" class="col-sm-2 col-form-label">Merk</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="merk" name="merk" value="<?= old('merk'); ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label for="transmission" class="col-sm-2 col-form-label">Transmisi</label>
                <div class="col-sm-5">
                    <select id="transmission" name="transmission" class="custom-select">
                        <option selected disabled value="">Pilih transmisi</option>
                        <option value="Manual">Manual</option>
                        <option value="Matik">Matik</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label for="seat" class="col-sm-2 col-form-label">Jumlah kursi</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="seat" name="seat" value="<?= old('seat'); ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label for="number-of-cars" class="col-sm-2 col-form-label">Jumlah mobil</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="number-of-cars" name="number-of-cars" value="<?= old('number-of-cars'); ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label for="rental-price-per-day" class="col-sm-2 col-form-label">Harga sewa / hari</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="rental-price-per-day" name="rental-price-per-day" value="<?= old('rental-price-per-day'); ?>" onkeyup="this.value = formatRupiah(this.value, 'Rp')">
                </div>
            </div>
            <div class="row mb-3">
                <label for="image" class="col-sm-2 col-form-label" id="img-label">Gambar</label>
                <div class="col-sm-2 d-none" id="col-img-preview">
                    <img src="/assets/img/car/HondaBrioSatya.png" alt="Default image" class="img-thumbnail img-preview">
                </div>
                <div class="col-sm-5">
                    <div class="custom-file">
                        <input type="file" accept="image/*" class="custom-file-input" id="image" name="image" aria-describedby="inputGroupFileAddon01">
                        <label class="custom-file-label" for="image">Choose file</label>
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <button type="submit" class="btn btn-info">Tambah data</button>
                <a href="/admin/car" class="btn btn-secondary">Batal</a>
            </div>
        </form>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?= $this->endSection(); ?>