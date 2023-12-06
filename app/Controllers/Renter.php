<?php

namespace App\Controllers;

use App\Models\RenterAccountModel;
use App\Models\CarModel;
use App\Models\RentalModel;

class Renter extends BaseController
{
    protected $renterAccountModel;
    protected $carModel;
    protected $rentalModel;

    public function __construct()
    {
        // Membuat object dari model.
        $this->renterAccountModel = new RenterAccountModel();
        $this->carModel = new CarModel();
        $this->rentalModel = new RentalModel();
    }

    public function index()
    {
        /**
         * Membuat title untuk halaman profil saya.
         * Mengambil data akun penyewa berdasarkan email di session ketika berhasil login.
         */
        $data = [
            'title' => 'Profil Saya',
            'account' => $this->renterAccountModel->getAccount(session()->get('email'))
        ];

        // Mengarahkan tampilan ke file myProfile di folder renter, serta mengirim data.
        return view('renter/myProfile', $data);
    }

    public function save($id)
    {
        // Memvalidasi data yang diinputkan penyewa.
        if (!$this->validate([
            'name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama lengkap harus diisi.'
                ]
            ],
            'mobile-phone-number' => [
                'rules' => 'required|numeric|max_length[13]',
                'errors' => [
                    'required' => 'Nomor handphone harus diisi.',
                    'numeric' => 'Nomor handphone harus berisi angka.',
                    'max_length' => 'Nomor handphone maksimal 13 angka.'
                ]
            ],
            'ktp-image' => [
                'rules' => 'uploaded[ktp-image]|max_size[image,1024]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Anda belum meng-upload foto KTP.',
                    'max_size' => 'Ukuran gambar terlalu besar.',
                    'is_image' => 'Yang Anda pilih bukan gambar.',
                    'mime_in' => 'Yang Anda pilih bukan gambar.'
                ]
            ],
            'sim-image' => [
                'rules' => 'uploaded[sim-image]|max_size[image,1024]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Anda belum meng-upload foto SIM A.',
                    'max_size' => 'Ukuran gambar terlalu besar.',
                    'is_image' => 'Yang Anda pilih bukan gambar.',
                    'mime_in' => 'Yang Anda pilih bukan gambar.'
                ]
            ],
            'image' => [
                'rules' => 'max_size[image,1024]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar.',
                    'is_image' => 'Yang Anda pilih bukan gambar.',
                    'mime_in' => 'Yang Anda pilih bukan gambar.'
                ]
            ]
        ])) {
            // Jika tidak lolos validasi maka redirect ke url renter.
            return redirect()->to(base_url('renter'))->withInput();
        }

        /**
         * Mengambil file gambar ktp yang diinputkan.
         * Membuat nama random untuk nama gambar.
         * Pindahkan file gambar ke foler ktp.
         */
        $ktpImage = $this->request->getFile('ktp-image');
        $ktpImageName = $ktpImage->getRandomName();
        $ktpImage->move('assets/img/ktp', $ktpImageName);

        // Cek apakah penyewa tidak meng-upload gambar ktp.
        if ($this->request->getVar('old-ktp-image') != '') {
            // Jika iya, maka hapus gambar di folder ktp.
            unlink('assets/img/ktp/' . $this->request->getVar('old-ktp-image'));
        }

        /**
         * Mengambil file gambar sim yang diinputkan.
         * Membuat nama random untuk nama gambar.
         * Pindahkan file gambar ke foler sim.
         */
        $simImage = $this->request->getFile('sim-image');
        $simImageName = $simImage->getRandomName();
        $simImage->move('assets/img/sim', $simImageName);

        // Cek apakah penyewa tidak meng-upload gambar sim.
        if ($this->request->getVar('old-sim-image') != '') {
            // Jika iya, maka hapus gambar di folder sim.
            unlink('assets/img/sim/' . $this->request->getVar('old-sim-image'));
        }

        // Mengambil file gambar profil yang diinputkan.
        $image = $this->request->getFile('image');

        // Cek apakah penyewa tidak meng-upload gambar profil.
        if ($image->getError() == 4) {
            // Jika iya, maka tentukan nama file gambar sesuai dengan nama file gambar yang lama.
            $imageName = $this->request->getVar('old-image');
        } else {
            // Jika tidak, maka buat nama random untuk nama gambar.
            $imageName = $image->getRandomName();
            // Lalu pindahkan file gambar yang diinput ke dalam folder profile.
            $image->move('assets/img/profile', $imageName);

            // Cek apakah nama gambar lama bukan defualt.jpg.
            if ($this->request->getVar('old-image') != 'default.jpg') {
                // Jika iya, maka hapus file gambar di folder profile berdasarkan nama gambar lama.
                unlink('assets/img/profile/' . $this->request->getVar('old-image'));
            }
        }

        // Memasukkan id, nama, nomor hp, gambar ktp, gambar sim dan gambar profil ke table renter.
        $this->renterAccountModel->save([
            'id' => $id,
            'name' => $this->request->getVar('name'),
            'mobile_phone_number' => $this->request->getVar('mobile-phone-number'),
            'ktp_image' => $ktpImageName,
            'sim_image' => $simImageName,
            'image' => $imageName
        ]);

        // Buat flash data success.
        session()->setFlashdata('successMessage', 'Data diri berhasil disimpan');
        // Lalu redirect ke url renter.
        return redirect()->to(base_url('renter'));
    }

    public function changePassword()
    {
        // Memvalidasi password yang diinput penyewa.
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
            // Jika tidak lolos validasi maka redirect ke url renter.
            return redirect()->to(base_url('renter'))->withInput();
        }

        // Mengambil data penyewa berdasarkan email di session ketika berhasil login.
        $account = $this->renterAccountModel->getAccount(session()->get('email'));

        // Mengambil inputan password saat ini penyewa.
        $currentPassword = $this->request->getVar('current-password');
        // Mengambil inputan password baru penyewa.
        $newPassword = $this->request->getVar('new-password');

        // Cek apakah password saat ini yang diinput penyewa sama dengan password yang ada di database.
        if (!password_verify($currentPassword, $account['password'])) {
            // Jika tidak sama, maka buat flash data error.
            session()->setFlashdata('errorMessage', 'Password saat ini salah!');
            // Lalu redirect ke url renter.
            return redirect()->to(base_url('renter'));
        } else {
            // Jika sama, maka cek apakah password saat ini dan password baru sama.
            if ($currentPassword == $newPassword) {
                // Jika iya, maka buat flash data error.
                session()->setFlashdata('errorMessage', 'Password saat ini dan password baru tidak boleh sama!');
                // Lalu redirect ke url renter.
                return redirect()->to(base_url('renter'));
            }
        }

        // Masukkan id dan password ke table renter.
        $this->renterAccountModel->save([
            'id' => $account['id'],
            'password' => password_hash($newPassword, PASSWORD_DEFAULT) // Membuat password hash, agar password tidak terlihat di database.
        ]);

        // Buat flash data success.
        session()->setFlashdata('successMessage', 'Password berhasil diubah');
        // Lalu redirect ke url renter.
        return redirect()->to(base_url('renter'));
    }

    public function carData()
    {
        /**
         * Membuat title untuk halaman data mobil.
         * Mengambil data akun penyewa berdasarkan email di session ketika berhasil login.
         * Mengambil semua data mobil.
         */
        $data = [
            'title' => 'Data Mobil',
            'account' => $this->renterAccountModel->getAccount(session()->get('email')),
            'car' => $this->carModel->getCar()
        ];

        // Mengarahkan tampilan ke file carData di folder renter, serta mengirim data.
        return view('renter/carData', $data);
    }

    public function carRental($id)
    {
        /**
         * Membuat title untuk halaman sewa mobil.
         * Mengambil data akun penyewa berdasarkan email di session ketika berhasil login.
         * Mengambil data mobil berdasarkan id.
         */
        $data = [
            'title' => 'Sewa Mobil',
            'account' => $this->renterAccountModel->getAccount(session()->get('email')),
            'car' => $this->carModel->getCarById($id)
        ];

        // Mengarahkan tampilan ke file carRental di folder renter, serta mengirim data.
        return view('renter/carRental', $data);
    }

    public function rentalData()
    {
        /**
         * Membuat title untuk halaman data penyewaan.
         * Mengambil data akun penyewa berdasarkan email di session ketika berhasil login.
         * Mengambil semua data penyewaan.
         */
        $data = [
            'title' => 'Data Penyewaan',
            'account' => $this->renterAccountModel->getAccount(session()->get('email')),
            'rental' => $this->rentalModel->getRentalData()
        ];

        // Mengarahkan tampilan ke file rentalData di folder renter, serta mengirim data.
        return view('renter/rentalData', $data);
    }

    public function addBalance($id)
    {
        // Memvalidasi saldo yang diinputkan penyewa.
        if (!$this->validate([
            'add-balance' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tambah saldo harus diisi.'
                ]
            ]
        ])) {
            // Jika tidak lolos validasi maka redirect ke url renter.
            return redirect()->to(base_url('renter'))->withInput();
        }

        /**
         * Mengambil saldo dari form readonly.
         * Membersihkan dari karakter selain angka.
         */
        $currentBalance = $this->request->getVar('current-balance');
        $currentBalance = str_replace('Rp', '', $currentBalance);
        $currentBalance = str_replace('.', '', $currentBalance);

        /**
         * Mengambil saldo yang diinputkan.
         * Membersihkan dari karakter selain angka.
         */
        $addBalance = $this->request->getVar('add-balance');
        $addBalance = str_replace('Rp', '', $addBalance);
        $addBalance = str_replace('.', '', $addBalance);

        // Tambahkan saldo saat ini dengan saldo yang diinputkan.
        $balance = $currentBalance + $addBalance;

        // Memasukkan id dan saldo ke table renter.
        $this->renterAccountModel->save([
            'id' => $id,
            'balance' => $balance
        ]);

        // Buat flash data success.
        session()->setFlashdata('successMessage', 'Saldo berhasil ditambahkan');
        // Lalu redirect ke url renter.
        return redirect()->to(base_url('renter'));
    }

    public function payment($id)
    {
        /**
         * Membuat title untuk halaman pembayaran.
         * Mengambil data akun penyewa berdasarkan email di session ketika berhasil login.
         * Mengambil data penyewaan berdasarkan id.
         */
        $data = [
            'title' => 'Pembayaran',
            'account' => $this->renterAccountModel->getAccount(session()->get('email')),
            'rental' => $this->rentalModel->getRentalDataById($id)
        ];

        // Mengarahkan tampilan ke file payment di folder renter, serta mengirim data.
        return view('renter/payment', $data);
    }

    public function pay($id)
    {
        // Mengambil data akun penyewa berdasarkan email di session ketika berhasil login.
        $renter = $this->renterAccountModel->getAccountById($this->request->getVar('renter-id'));
        // Mengambil data penyewaan berdasarkan id.
        $rental = $this->rentalModel->getRentalDataById($id);

        // Cek apakah saldo lebih kecil dari total harga sewa.
        if ($renter['balance'] < $rental['total_rental_price']) {
            // Jika iya, maka buat flash error.
            session()->setFlashdata('errorMessage', 'Saldo Anda tidak cukup!');
            // Lalu reidrect ke url renter/payment/id.
            return redirect()->to(base_url('renter/payment/' . $id))->withInput();
        }

        // Kurangi saldo dengan total harga sewa.
        $balance = $renter['balance'] - $rental['total_rental_price'];

        // Memasukkan id dan status ke table rental.
        $this->rentalModel->save([
            'id' => $id,
            'status' => 2
        ]);

        // Memasukkan id dan saldo ke table renter.
        $this->renterAccountModel->save([
            'id' => $this->request->getVar('renter-id'),
            'balance' => $balance
        ]);

        // Buat flash data success.
        session()->setFlashdata('successMessage', 'Pembayaran berhasil');
        // Lalu redirect ke url renter/rental-data.
        return redirect()->to(base_url('renter/rental-data'));
    }
}
