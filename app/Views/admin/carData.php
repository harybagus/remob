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

        <!-- Button trigger modal -->
        <a href="/admin/car/create" class="btn btn-info mb-3">
            <i class="fas fa-car"></i>
            Tambah data mobil
        </a>

        <!-- Menampilkan pesan berhasil ketika berhasil menambah, mengubah atau menghapus data mobil -->
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
                                <a href="/admin/car/update/<?= $car['id']; ?>" class="btn btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <a href="/admin/car/delete/<?= $car['id']; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data mobil?')">
                                    <i class="fas fa-trash-alt"></i>
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
                                        <td>Jumlah mobil</td>
                                        <td>:</td>
                                        <th><?= $car['number_of_cars']; ?></th>
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