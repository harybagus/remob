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
        <a href="/admin/renter/create" class="btn btn-info mb-3">
            <i class="fas fa-user-plus"></i>
            Tambah data penyewa
        </a>

        <!-- Menampilkan pesan berhasil ketika berhasil menambah, mengubah atau menghapus data penyewa -->
        <?php if (session()->getFlashdata('successMessage')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('successMessage'); ?>

                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <!-- Menampilkan data penyewa -->
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Email</th>
                    <th scope="col">Bergabung</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($renterAccount as $renterAccount) : ?>
                    <tr>
                        <th scope="row"><?= $i++; ?></th>
                        <td><?= $renterAccount['name']; ?></td>
                        <td><?= $renterAccount['email']; ?></td>
                        <td><?= date('d F Y', $renterAccount['date_created']); ?></td>
                        <td>
                            <a href="/admin/renter/update/<?= $renterAccount['id']; ?>" class="btn btn-warning">
                                <i class="fas fa-user-edit"></i>
                            </a>

                            <a href="/admin/renter/delete/<?= $renterAccount['id']; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data penyewa?')">
                                <i class="fas fa-user-minus"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?= $this->endSection(); ?>