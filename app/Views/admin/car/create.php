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

        <!-- Form untuk menambah data mobil -->
        <form action="/admin/car/add" method="post" enctype="multipart/form-data" autocomplete="off">
            <!-- Melindungi web dari serangan CSRF(Cross-Site Request Forgery) -->
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