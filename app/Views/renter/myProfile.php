<!-- Menggunakan template user -->
<?= $this->extend('layout/user_template'); ?>

<!-- Membuat halaman ini menjadi section content -->
<?= $this->section('content'); ?>
<!-- Main Content -->
<div id="content">

    <!-- Menggunakan topbar renter -->
    <?= $this->include('layout/topbarRenter'); ?>

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

        <div class="dropdown-divider mb-3"></div>

        <!-- Menampilkan pesan peringatan ketika penyewa belum melengkapi data diri -->
        <?php if ($account['mobile_phone_number'] == "" || $account['ktp_image'] == "" || $account['sim_image'] == "") : ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                Selamat datang di ReMob, sebelum menyewa mobil Anda harus <strong>melengkapi data diri</strong> terlebih dahulu!

                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <!-- Menampilkan error ketika tidak lolos validasi -->
        <?php if (session()->getFlashdata('_ci_validation_errors')) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
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

        <!-- Menampilkan pesan berhasil ketika berhasil melengkapi data diri, mengubah password dan menambah saldo e-Wallet -->
        <?php if (session()->getFlashdata('successMessage')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('successMessage'); ?>

                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Menampilkan pesan error ketika tidak lolos validasi -->
        <?php elseif (session()->getFlashdata('errorMessage')) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
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

        <div class="d-flex mb-4">
            <div class="float-left w-100">
                <!-- Card profil -->
                <div class="card mb-3 mr-3 border-info">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="/assets/img/profile/<?= $account['image']; ?>" class="img-thumbnail m-2" alt="<?= $account['name']; ?>">
                        </div>

                        <div class="col-md-8 d-flex">
                            <div class="card-body m-auto">
                                <h5 class="card-title mb-0 text-dark"><?= $account['name']; ?></h5>
                                <p class="card-text mb-2"><?= $account['email']; ?></p>
                                <p class="card-text"><small class="text-body-secondary">Bergabung sejak <?= date('d F Y', $account['date_created']); ?></small></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card ubah password -->
                <div class="card mr-3 border-info">
                    <h5 class="card-header">Ubah Password</h5>

                    <div class="card-body">
                        <!-- Form untuk mengubah password -->
                        <form action="/renter/change-password" method="post" autocomplete="off">
                            <!-- Melindungi web dari serangan CSRF(Cross-Site Request Forgery) -->
                            <?= csrf_field(); ?>

                            <div class="form-group">
                                <label for="current-password">Password saat ini</label>
                                <input type="password" class="form-control" id="current-password" name="current-password">
                            </div>

                            <div class="form-group">
                                <label for="new-password">Password baru</label>
                                <input type="password" class="form-control" id="new-password" name="new-password">
                            </div>

                            <div class="form-group">
                                <label for="confirm-password">Confirm password</label>
                                <input type="password" class="form-control" id="confirm-password" name="confirm-password">
                            </div>

                            <button type="submit" class="btn btn-info">Ubah</button>
                            <button type="reset" class="btn btn-secondary">Batal</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="float-right w-100">
                <!-- Card lengkapi data diri -->
                <div class="card border-info">
                    <div class="card-header">
                        <h5 class="float-left mb-0">Data Diri</h5>

                        <?php if ($account['mobile_phone_number'] != "" && $account['ktp_image'] != "" && $account['sim_image'] != "") : ?>
                            <p class="float-right mb-0 text-info"><small>Data diri sudah lengkap</small></p>
                        <?php else : ?>
                            <p class="float-right mb-0 text-danger"><small>Data diri belum lengkap</small></p>
                        <?php endif; ?>
                    </div>

                    <div class="card-body">
                        <!-- Form untuk melengkapi data diri -->
                        <form action="/renter/save/<?= $account['id']; ?>" method="post" enctype="multipart/form-data" autocomplete="off">
                            <!-- Melindungi web dari serangan CSRF(Cross-Site Request Forgery) -->
                            <?= csrf_field(); ?>

                            <input type="hidden" name="old-ktp-image" value="<?= $account['ktp_image']; ?>">
                            <input type="hidden" name="old-sim-image" value="<?= $account['sim_image']; ?>">
                            <input type="hidden" name="old-image" value="<?= $account['image']; ?>">

                            <div class="form-group">
                                <label for="name">Nama lengkap</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?= old('name', $account['name']); ?>">
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="email" name="email" value="<?= old('email', $account['email']); ?>" readonly>
                            </div>

                            <div class="form-group">
                                <label for="mobile-phone-number">Nomor handphone</label>
                                <input type="text" class="form-control" id="mobile-phone-number" name="mobile-phone-number" value="<?= old('mobile-phone-number', $account['mobile_phone_number']); ?>">
                            </div>

                            <div class="row mb-3">
                                <?php if ($account['ktp_image'] != "") : ?>
                                    <div class="col-sm-4">
                                        <img src="/assets/img/ktp/<?= $account['ktp_image']; ?>" alt="<?= $account['name']; ?>" class="img-thumbnail img-preview">
                                    </div>
                                <?php else : ?>
                                    <label for="ktp-image" class="col-sm-4 col-form-label" id="ktp-img-label">Foto KTP</label>
                                    <div class="col-sm-4 d-none" id="col-ktp-img-preview">
                                        <img src="" alt="KTP Image" class="img-thumbnail ktp-img-preview">
                                    </div>
                                <?php endif; ?>

                                <div class="col-sm-8">
                                    <div class="custom-file">
                                        <input type="file" accept="image/*" class="custom-file-input" id="ktp-image" name="ktp-image" aria-describedby="inputGroupFileAddon01">
                                        <label class="custom-file-label" for="ktp-image">Choose file</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <?php if ($account['sim_image'] != "") : ?>
                                    <div class="col-sm-4">
                                        <img src="/assets/img/sim/<?= $account['sim_image']; ?>" alt="<?= $account['name']; ?>" class="img-thumbnail img-preview">
                                    </div>
                                <?php else : ?>
                                    <label for="sim-image" class="col-sm-4 col-form-label" id="sim-img-label">Foto SIM A</label>
                                    <div class="col-sm-4 d-none" id="col-sim-img-preview">
                                        <img src="" alt="SIM Image" class="img-thumbnail sim-img-preview">
                                    </div>
                                <?php endif; ?>

                                <div class="col-sm-8">
                                    <div class="custom-file">
                                        <input type="file" accept="image/*" class="custom-file-input" id="sim-image" name="sim-image" aria-describedby="inputGroupFileAddon01">
                                        <label class="custom-file-label" for="sim-image">Choose file</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <img src="/assets/img/profile/<?= $account['image']; ?>" alt="<?= $account['name']; ?>" class="img-thumbnail img-preview">
                                </div>

                                <div class="col-sm-8">
                                    <div class="custom-file">
                                        <input type="file" accept="image/*" class="custom-file-input" id="image" name="image" aria-describedby="inputGroupFileAddon01">
                                        <label class="custom-file-label" for="image">Choose file</label>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-info">Simpan</button>
                            <button type="reset" class="btn btn-secondary">Batal</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?= $this->endSection(); ?>