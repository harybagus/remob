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

        <!-- Menampilkan pesan berhasil ketika berhasil mengubah password -->
        <?php if (session()->getFlashdata('successMessage')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('successMessage'); ?>

                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Menampilkan pesan error ketika tidak lolos validasi -->
        <?php elseif (session()->getFlashdata('errorMessage')) : ?>
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

        <!-- Form untuk mengubah password admin -->
        <form action="/admin/change" method="post" autocomplete="off">
            <!-- Melindungi web dari serangan CSRF(Cross-Site Request Forgery) -->
            <?= csrf_field(); ?>

            <div class="row mb-3">
                <label for="current-password" class="col-sm-2 col-form-label">Password saat ini</label>
                <div class="col-sm-5">
                    <input type="password" class="form-control" id="current-password" name="current-password">
                </div>
            </div>

            <div class="row mb-3">
                <label for="new-password" class="col-sm-2 col-form-label">Password baru</label>
                <div class="col-sm-5">
                    <input type="password" class="form-control" id="new-password" name="new-password">
                </div>
            </div>

            <div class="row mb-3">
                <label for="confirm-password" class="col-sm-2 col-form-label">Confirm password</label>
                <div class="col-sm-5">
                    <input type="password" class="form-control" id="confirm-password" name="confirm-password">
                </div>
            </div>

            <button type="submit" class="btn btn-info">Ubah</button>
        </form>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?= $this->endSection(); ?>