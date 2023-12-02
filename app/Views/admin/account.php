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

        <?php if (session()->getFlashdata('successMessage')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('successMessage'); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <!-- Button trigger modal -->
        <a href="/admin/account/create" class="btn btn-info mb-3">
            <i class="fas fa-user-plus"></i>
            Tambah data admin
        </a>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Email</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($adminAccount as $adminAccount) : ?>
                    <tr>
                        <th scope="row"><?= $i++; ?></th>
                        <td><?= $adminAccount['name']; ?></td>
                        <td><?= $adminAccount['email']; ?></td>
                        <td>
                            <a href="/admin/account/update/<?= $adminAccount['id']; ?>" class="btn btn-warning">
                                <i class="fas fa-user-edit"></i>
                            </a>
                            <?php if ($adminAccount['email'] != session()->get('email')) : ?>
                                <a href="/admin/account/delete/<?= $adminAccount['id']; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data admin?')">
                                    <i class="fas fa-user-minus"></i>
                                </a>
                            <?php endif; ?>
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