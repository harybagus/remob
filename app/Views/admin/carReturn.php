<!-- Menggunakan template user -->
<?= $this->extend('layout/user_template'); ?>

<!-- Membuat halaman ini menjadi section content -->
<?= $this->section('content'); ?>
<!-- Main Content -->
<div id="content">

    <!-- Menggunakan topbar admin -->
    <?= $this->include('layout/topbarAdmin'); ?>

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h3 class="mb-4 text-gray-800"><?= $title; ?></h3>

        <div class="dropdown-divider mb-3"></div>

        <!-- Menampilkan error ketika tidak lolos validasi -->
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

        <!-- Menampilkan pesan error ketika tidak lolos validasi -->
        <?php if (session()->getFlashdata('errorMessage')) : ?>
            <div class="col-sm-7 alert alert-danger alert-dismissible fade show" role="alert">
                <h4>Kesalahan</h4>

                <ul>
                    <li>
                        <?= session()->getFlashdata('errorMessage'); ?>
                    </li>
                </ul>

                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <?php
        // Koneksi ke database.
        $db = db_connect();

        // Membuat query mengambil data mobil berdasarkan id mobil di table rental.
        $queryCar = "SELECT * FROM `car` WHERE `id` = ?";
        // Membuat query mengambil data penyewa berdasarkan id penyewa di table rental.
        $queryRenter = "SELECT * FROM `renter` WHERE `id` = ?";

        // Mengambil data mobil.
        $car = $db->query($queryCar, $rental['car_id'])->getRowArray();
        // Mengambil data penyewa.
        $renter = $db->query($queryRenter, $rental['renter_id'])->getRowArray();
        ?>

        <!-- Form untuk mengembalikan mobil -->
        <form action="/admin/return/<?= $rental['id']; ?>" method="post" enctype="multipart/form-data" autocomplete="off">
            <!-- Melindungi web dari serangan CSRF(Cross-Site Request Forgery) -->
            <?= csrf_field(); ?>

            <input type="hidden" name="renter-id" value="<?= $rental['renter_id']; ?>">
            <input type="hidden" name="car-id" value="<?= $rental['car_id']; ?>">

            <div class="row mb-3">
                <label for="name" class="col-sm-2 col-form-label">Nama lengkap</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="name" name="name" value="<?= $renter['name']; ?>" readonly>
                </div>
            </div>

            <div class="row mb-3">
                <label for="car-name" class="col-sm-2 col-form-label">Nama mobil</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="car-name" name="car-name" value="<?= $car['name']; ?>" readonly>
                </div>
            </div>

            <div class="row mb-3">
                <label for="rental-price-per-day" class="col-sm-2 col-form-label">Harga sewa / hari</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="rental-price-per-day" name="rental-price-per-day" value="<?= formatRupiah($rental['rental_price_per_day']); ?>" readonly>
                </div>
            </div>

            <div class="row mb-3">
                <label for="rental-start" class="col-sm-2 col-form-label">Awal sewa</label>
                <div class="col-sm-5">
                    <input type="date" min="<?= date('Y-m-d'); ?>" class="form-control" id="rental-start" name="rental-start" value="<?= $rental['rental_start']; ?>" readonly>
                </div>
            </div>

            <div class="row mb-3">
                <label for="rental-end" class="col-sm-2 col-form-label">Akhir sewa</label>
                <div class="col-sm-5">
                    <input type="date" min="<?= date('Y-m-d'); ?>" class="form-control" id="rental-end" name="rental-end" value="<?= old('rental-end'); ?>">
                </div>
            </div>

            <div class="mb-4">
                <button type="submit" class="btn btn-info">Simpan</button>
                <a href="/admin/rental" class="btn btn-secondary">Batal</a>
            </div>
        </form>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?= $this->endSection(); ?>