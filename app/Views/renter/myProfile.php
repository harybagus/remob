<?= $this->extend('layout/user_template'); ?>

<?= $this->section('content'); ?>
<!-- Main Content -->
<div id="content">

    <!-- Topbar -->
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

        <!-- Sidebar Toggle (Topbar) -->
        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars text-info"></i>
        </button>

        <!-- Topbar Navbar -->
        <ul class="navbar-nav ml-auto">

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $account['name']; ?></span>
                    <img class="img-profile rounded-circle" src="/assets/img/profile/<?= $account['image']; ?>">
                </a>
                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="/renter">
                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                        Profil Saya
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="/auth/logout" data-toggle="modal" data-target="#logoutModal">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </a>
                </div>
            </li>

        </ul>

    </nav>
    <!-- End of Topbar -->

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

        <div class="dropdown-divider mb-3"></div>

        <?php if (session()->getFlashdata('_ci_validation_errors')) : ?>
            <div class="col-sm alert alert-danger alert-dismissible fade show" role="alert">
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

        <?php if (session()->getFlashdata('successMessage')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('successMessage'); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <!-- Card Profile -->
        <div class="d-flex mb-3">
            <div class="float-left w-100">
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

                <div class="card mr-3 border-info">
                    <h5 class="card-header">Ubah Password</h5>
                    <div class="card-body">
                        <form action="/renter/change-password" method="post" autocomplete="off">
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
                            <button type="submit" class="btn btn-info">Ubah password</button>
                            <button type="reset" class="btn btn-secondary">Batal</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="float-right w-100">
                <div class="card border-info">
                    <h5 class="card-header">Ubah Profil</h5>
                    <div class="card-body">
                        <form action="/renter/account/update/<?= $account['id']; ?>" method="post" enctype="multipart/form-data" autocomplete="off">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="old-image" value="<?= $account['image']; ?>">
                            <div class="form-group">
                                <label for="name">Nama lengkap</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?= old('name', $account['name']); ?>">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="email" name="email" value="<?= old('email', $account['email']); ?>" readonly>
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
                            <button type="submit" class="btn btn-info">Ubah profil</button>
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