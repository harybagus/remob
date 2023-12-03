<?= $this->extend('layout/user_template'); ?>

<?= $this->section('content'); ?>
<!-- Main Content -->
<div id="content">

    <?= $this->include('layout/topbarAdmin'); ?>

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

        <table class="table table-striped table-hover">
            <thead class="">
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
                            <td><a href="/admin/car-return/<?= $rental['id']; ?>" class="btn btn-info">Pengembalian</a></td>
                        <?php elseif ($rental['status'] == 1) : ?>
                            <td>Sudah dikembalikan</td>
                            <td><button class="btn btn-info" data-toggle="modal" data-target="#hasBeenReturnedModal">Pengembalian</button></td>
                        <?php else : ?>
                            <td>Sudah dibayar</td>
                            <td><button class="btn btn-info" data-toggle="modal" data-target="#hasBeenReturnedModal">Pengembalian</button></td>
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