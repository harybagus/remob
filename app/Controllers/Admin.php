<?php

namespace App\Controllers;

use App\Models\AdminAccountModel;
use App\Models\RenterAccountModel;
use App\Models\CarModel;
use App\Models\RentalModel;

class Admin extends BaseController
{
    protected $adminAccountModel;
    protected $renterAccountModel;
    protected $carModel;
    protected $rentalModel;

    public function __construct()
    {
        // Membuat object dari model.
        $this->adminAccountModel = new AdminAccountModel();
        $this->renterAccountModel = new RenterAccountModel();
        $this->carModel = new CarModel();
        $this->rentalModel = new RentalModel();
    }

    public function index()
    {
        /**
         * Membuat title untuk halaman dashboard.
         * Mengambil data akun admin berdasarkan email di session ketika berhasil login.
         * Mengambil jumlah data mobil.
         * Mengambil jumlah data akun penyewa.
         * Mengambil jumlah data penyewaan.
         * Mengambil jumlah data akun admin.
         */
        $data = [
            'title' => 'Dashboard',
            'account' => $this->adminAccountModel->getAccount(session()->get('email')),
            'car' => $this->carModel->getNumberOfCars(),
            'renterAccount' => $this->renterAccountModel->getNumberOfRenters(),
            'rental' => $this->rentalModel->getNumberOfRentals(),
            'adminAccount' => $this->adminAccountModel->getNumberOfAdmins(),
        ];

        // Mengarahkan tampilan ke file dashboard di folder admin, serta mengirim data.
        return view('admin/dashboard', $data);
    }

    public function account()
    {
        /**
         * Membuat title untuk halaman kelola akun.
         * Mengambil data akun admin berdasarkan email di session ketika berhasil login.
         * Mengambil semua data akun admin.
         */
        $data = [
            'title' => 'Kelola Akun',
            'account' => $this->adminAccountModel->getAccount(session()->get('email')),
            'adminAccount' => $this->adminAccountModel->getAllAccount()
        ];

        // Mengarahkan tampilan ke file account di folder admin, serta mengirim data.
        return view('admin/account', $data);
    }

    public function renterData()
    {
        /**
         * Membuat title untuk halaman data penyewa.
         * Mengambil data akun admin berdasarkan email di session ketika berhasil login.
         * Mengambil semua data akun penyewa.
         */
        $data = [
            'title' => 'Data Penyewa',
            'account' => $this->adminAccountModel->getAccount(session()->get('email')),
            'renterAccount' => $this->renterAccountModel->getAllAccount()
        ];

        // Mengarahkan tampilan ke file renterData di folder admin, serta mengirim data.
        return view('admin/renterData', $data);
    }

    public function carData()
    {
        /**
         * Membuat title untuk halaman data mobil.
         * Mengambil data akun admin berdasarkan email di session ketika berhasil login.
         * Mengambil semua data mobil.
         */
        $data = [
            'title' => 'Data Mobil',
            'account' => $this->adminAccountModel->getAccount(session()->get('email')),
            'car' => $this->carModel->getCar()
        ];

        // Mengarahkan tampilan ke file carData di folder admin, serta mengirim data.
        return view('admin/carData', $data);
    }

    public function rentalData()
    {
        /**
         * Membuat title untuk halaman data penyewaan.
         * Mengambil data akun admin berdasarkan email di session ketika berhasil login.
         * Mengambil semua data penyewaan.
         */
        $data = [
            'title' => 'Data Penyewaan',
            'account' => $this->adminAccountModel->getAccount(session()->get('email')),
            'rental' => $this->rentalModel->getRentalData()
        ];

        // Mengarahkan tampilan ke file rentalData di folder admin, serta mengirim data.
        return view('admin/rentalData', $data);
    }

    public function changePassword()
    {
        /**
         * Membuat title untuk halaman ubah password.
         * Mengambil data akun admin berdasarkan email di session ketika berhasil login.
         */
        $data = [
            'title' => 'Ubah Password',
            'account' => $this->adminAccountModel->getAccount(session()->get('email'))
        ];

        // Mengarahkan tampilan ke file changePassword di folder admin, serta mengirim data.
        return view('admin/changePassword', $data);
    }

    public function change()
    {
        // Memvalidasi password yang diinput admin.
        if (!$this->validate([
            'current-password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password saat ini harus diisi.'
                ]
            ],
            'new-password' => [
                'rules' => 'required|min_length[8]|matches[confirm-password]',
                'errors' => [
                    'required' => 'Password baru harus diisi.',
                    'min_length' => 'Password baru harus berisi minimal 8 karakter.',
                    'matches' => 'Password baru dan confirm password tidak sama.'
                ]
            ],
            'confirm-password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Confirm password harus diisi.'
                ]
            ]
        ])) {
            // Jika tidak lolos validasi maka redirect ke url admin/change-password.
            return redirect()->to(base_url('admin/change-password'))->withInput();
        }

        // Mengambil data akun admin berdasarkan email di session ketika berhasil login.
        $account = $this->adminAccountModel->getAccount(session()->get('email'));

        // Mengambil inputan password saat ini admin.
        $currentPassword = $this->request->getVar('current-password');
        // Mengambil inputan password baru admin.
        $newPassword = $this->request->getVar('new-password');

        // Cek apakah password saat ini yang diinput admin sama dengan password yang ada di database.
        if (!password_verify($currentPassword, $account['password'])) {
            // Jika tidak sama, maka buat flash data error.
            session()->setFlashdata('errorMessage', 'Password saat ini salah!');
            // Lalu redirect ke url admin/change-password.
            return redirect()->to(base_url('admin/change-password'));
        } else {
            // Jika sama, maka cek apakah password saat ini dan password baru sama.
            if ($currentPassword == $newPassword) {
                // Jika iya, maka buat flash data error.
                session()->setFlashdata('errorMessage', 'Password saat ini dan password baru tidak boleh sama!');
                // Lalu redirect ke url admin/change-password.
                return redirect()->to(base_url('admin/change-password'));
            }
        }

        // Masukkan id dan password ke table admin.
        $this->adminAccountModel->save([
            'id' => $account['id'],
            'password' => password_hash($newPassword, PASSWORD_DEFAULT) // Membuat password hash, agar password tidak terlihat di database.
        ]);

        // Buat flash data success.
        session()->setFlashdata('successMessage', 'Password berhasil diubah');
        // Lalu redirect ke url admin/change-password.
        return redirect()->to(base_url('admin/change-password'));
    }
}
