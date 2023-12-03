<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars text-info"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Wallet -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="walletDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-wallet fa-fw"></i>
            </a>

            <!-- Dropdown - Messages -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header border-info bg-info">Dompet Saya</h6>

                <div class="m-4">
                    <form action="/renter/add-balance/<?= $account['id']; ?>" method="post" autocomplete="off">
                        <?= csrf_field(); ?>

                        <div class="form-group">
                            <label for="current-balance">Saldo</label>
                            <input type="text" class="form-control" id="current-balance" name="current-balance" value="<?= formatRupiah($account['balance']); ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label for="add-balance">Tambah saldo</label>
                            <input type="text" class="form-control" id="add-balance" name="add-balance" onkeyup="this.value = formatRupiah(this.value, 'Rp')">
                        </div>

                        <button type="submit" class="btn btn-info">Tambah</button>
                    </form>
                </div>
            </div>
        </li>

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