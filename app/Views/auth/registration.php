<?= $this->extend('layout/auth_template'); ?>

<?= $this->section('content'); ?>
<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5 col-lg-7 mx-auto">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Buat Akun!</h1>
                        </div>

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

                        <form class="user" autocomplete="off" method="post" action="/auth/create">
                            <?= csrf_field(); ?>

                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="name" name="name" placeholder="Nama lengkap" value="<?= old('name'); ?>">
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="email" name="email" placeholder="Email" value="<?= old('email'); ?>">
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
                                </div>

                                <div class="col-sm-6">
                                    <input type="password" class="form-control form-control-user" id="confirm-password" name="confirm-password" placeholder="Confirm password">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-info btn-user btn-block">
                                Daftar Akun
                            </button>
                        </form>

                        <hr>

                        <div class="text-center">
                            <a class="small" href="/auth">Sudah punya akun? Login!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<?= $this->endSection(); ?>