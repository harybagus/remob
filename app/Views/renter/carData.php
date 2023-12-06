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
        <h3 class="mb-4 text-gray-800"><?= $title; ?></h3>

        <div class="dropdown-divider mb-3"></div>

        <!-- Menampilkan pesan berhasil ketika menyewa mobil -->
        <?php if (session()->getFlashdata('successMessage')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('successMessage'); ?>

                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <!-- Menampilkan data mobil -->
        <div class="row row-cols-1 row-cols-md-3">
            <?php foreach ($car as $car) : ?>
                <div class="col mb-4">
                    <div class="card border-info">
                        <div class="card-header">
                            <h6 class="float-left pt-2"><?= $car['name']; ?></h6>

                            <div class="float-right">
                                <?php if ($account['mobile_phone_number'] == "" || $account['ktp_image'] == "" || $account['sim_image'] == "") : ?>
                                    <button class="btn btn-info" data-toggle="modal" data-target="#dataIsIncompleteModal">
                                        Sewa
                                    </button>
                                <?php elseif ($car['number_of_cars'] >= 1) : ?>
                                    <a href="/renter/car-rental/<?= $car['id']; ?>" class="btn btn-info">
                                        Sewa
                                    </a>
                                <?php else : ?>
                                    <button class="btn btn-info" data-toggle="modal" data-target="#notAvailableModal">
                                        Sewa
                                    </button>
                                <?php endif; ?>
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
                                        <td>Transmisi</td>
                                        <td>:</td>
                                        <th><?= $car['transmission']; ?></th>
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
                                        <td>Status</td>
                                        <td>:</td>
                                        <?php if ($car['number_of_cars'] >= 1) : ?>
                                            <th>Tersedia</th>
                                        <?php else : ?>
                                            <th>Tidak tersedia</th>
                                        <?php endif; ?>
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

<!-- Data Is Incomplete Modal-->
<div class="modal fade" id="dataIsIncompleteModal" tabindex="-1" role="dialog" aria-labelledby="dataIsIncompleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataIsIncompleteModalLabel">Anda belum melengkapi data diri!</h5>

                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-footer">
                <a class="btn btn-info" href="/renter">Lengkapi sekarang!</a>
            </div>
        </div>
    </div>
</div>

<!-- Not Available Modal-->
<div class="modal fade" id="notAvailableModal" tabindex="-1" role="dialog" aria-labelledby="notAvailableModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notAvailableModalLabel">Mobil tidak tersedia!</h5>

                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>