<?= $this->extend('layout/user_template'); ?>

<?= $this->section('content'); ?>
<!-- Main Content -->
<div id="content">

    <?= $this->include('layout/topbarAdmin'); ?>

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?= $this->endSection(); ?>