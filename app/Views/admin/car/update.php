<?= $this->extend('layout/user_template'); ?>

<?= $this->section('content'); ?>
<!-- Main Content -->
<div id="content">

    <?= $this->include('layout/topbarAdmin'); ?>

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

        <form action="/admin/car/edit/<?= $car['id']; ?>" method="post" enctype="multipart/form-data" autocomplete="off">
            <?= csrf_field(); ?>
            <input type="hidden" name="old-image" value="<?= $car['image']; ?>">
            <div class="row mb-3">
                <label for="name" class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="name" name="name" value="<?= old('name', $car['name']); ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label for="merk" class="col-sm-2 col-form-label">Merk</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="merk" name="merk" value="<?= old('merk', $car['merk']); ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label for="transmission" class="col-sm-2 col-form-label">Transmisi</label>
                <div class="col-sm-5">
                    <select id="transmission" name="transmission" class="form-control">
                        <?php if ($car['transmission'] == 'Manual') : ?>
                            <option selected value="<?= $car['transmission']; ?>"><?= $car['transmission']; ?></option>
                            <option value="Matik">Matik</option>
                        <?php else : ?>
                            <option selected value="<?= $car['transmission']; ?>"><?= $car['transmission']; ?></option>
                            <option value="Manual">Manual</option>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label for="seat" class="col-sm-2 col-form-label">Jumlah kursi</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="seat" name="seat" value="<?= old('seat', $car['seat']); ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label for="number-of-cars" class="col-sm-2 col-form-label">Jumlah mobil</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="number-of-cars" name="number-of-cars" value="<?= old('number-of-cars', $car['number_of_cars']); ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label for="rental-price-per-day" class="col-sm-2 col-form-label">Harga sewa / hari</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="rental-price-per-day" name="rental-price-per-day" value="<?= old('rental-price-per-day', formatRupiah($car['rental_price_per_day'])); ?>" onkeyup="this.value = formatRupiah(this.value, 'Rp')">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-2">
                    <img src="/assets/img/car/<?= $car['image']; ?>" alt="<?= $car['name']; ?>" class="img-thumbnail img-preview">
                </div>
                <div class="col-sm-5">
                    <div class="custom-file">
                        <input type="file" accept="image/*" class="custom-file-input" id="image" name="image" aria-describedby="inputGroupFileAddon01">
                        <label class="custom-file-label" for="image">Choose file</label>
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <button type="submit" class="btn btn-info">Ubah data</button>
                <a href="/admin/car" class="btn btn-secondary">Batal</a>
            </div>
        </form>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?= $this->endSection(); ?>