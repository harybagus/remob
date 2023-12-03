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
        $this->renterAccountModel = new RenterAccountModel();
        $this->carModel = new CarModel();
        $this->rentalModel = new RentalModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Profil Saya',
            'account' => $this->renterAccountModel->getAccount(session()->get('email'))
        ];

        return view('renter/myProfile', $data);
    }

    public function save($id)
    {
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
                    'uploaded' => 'Anda belum meng-upload foto SIM.',
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
            return redirect()->to(base_url('renter'))->withInput();
        }

        $ktpImage = $this->request->getFile('ktp-image');
        $ktpImageName = $ktpImage->getRandomName();
        $ktpImage->move('assets/img/ktp', $ktpImageName);
        if ($this->request->getVar('old-ktp-image') != '') {
            unlink('assets/img/ktp/' . $this->request->getVar('old-ktp-image'));
        }

        $simImage = $this->request->getFile('sim-image');
        $simImageName = $simImage->getRandomName();
        $simImage->move('assets/img/sim', $simImageName);
        if ($this->request->getVar('old-sim-image') != '') {
            unlink('assets/img/sim/' . $this->request->getVar('old-sim-image'));
        }

        $image = $this->request->getFile('image');
        if ($image->getError() == 4) {
            $imageName = $this->request->getVar('old-image');
        } else {
            $imageName = $image->getRandomName();
            $image->move('assets/img/profile', $imageName);
            if ($this->request->getVar('old-image') != 'default.jpg') {
                unlink('assets/img/profile/' . $this->request->getVar('old-image'));
            }
        }

        $this->renterAccountModel->save([
            'id' => $id,
            'name' => $this->request->getVar('name'),
            'mobile_phone_number' => $this->request->getVar('mobile-phone-number'),
            'ktp_image' => $ktpImageName,
            'sim_image' => $simImageName,
            'image' => $imageName
        ]);

        session()->setFlashdata('successMessage', 'Data diri berhasil disimpan');
        return redirect()->to(base_url('renter'));
    }

    public function changePassword()
    {
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
            return redirect()->to(base_url('renter'))->withInput();
        }

        $account = $this->renterAccountModel->getAccount(session()->get('email'));

        $currentPassword = $this->request->getVar('current-password');
        $newPassword = $this->request->getVar('new-password');

        if (!password_verify($currentPassword, $account['password'])) {
            session()->setFlashdata('errorMessage', 'Password saat ini salah!');
            return redirect()->to(base_url('renter'));
        } else {
            if ($currentPassword == $newPassword) {
                session()->setFlashdata('errorMessage', 'Password saat ini dan password baru tidak boleh sama!');
                return redirect()->to(base_url('renter'));
            }
        }

        $this->renterAccountModel->save([
            'id' => $account['id'],
            'password' => password_hash($newPassword, PASSWORD_DEFAULT)
        ]);

        session()->setFlashdata('successMessage', 'Password berhasil diubah');
        return redirect()->to(base_url('renter'));
    }

    public function carData()
    {
        $data = [
            'title' => 'Data Mobil',
            'account' => $this->renterAccountModel->getAccount(session()->get('email')),
            'car' => $this->carModel->getCar()
        ];

        return view('renter/carData', $data);
    }

    public function carRental($id)
    {
        $data = [
            'title' => 'Sewa Mobil',
            'account' => $this->renterAccountModel->getAccount(session()->get('email')),
            'car' => $this->carModel->getCarById($id)
        ];

        return view('renter/carRental', $data);
    }

    public function rentalData()
    {
        $data = [
            'title' => 'Data Penyewaan',
            'account' => $this->renterAccountModel->getAccount(session()->get('email')),
            'rental' => $this->rentalModel->getRentalData()
        ];

        return view('renter/rentalData', $data);
    }

    public function addBalance($id)
    {
        if (!$this->validate([
            'add-balance' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tambah saldo harus diisi.'
                ]
            ]
        ])) {
            return redirect()->to(base_url('renter'))->withInput();
        }

        $currentBalance = $this->request->getVar('current-balance');
        $currentBalance = str_replace('Rp', '', $currentBalance);
        $currentBalance = str_replace('.', '', $currentBalance);

        $addBalance = $this->request->getVar('add-balance');
        $addBalance = str_replace('Rp', '', $addBalance);
        $addBalance = str_replace('.', '', $addBalance);

        $balance = $currentBalance + $addBalance;

        $this->renterAccountModel->save([
            'id' => $id,
            'balance' => $balance
        ]);

        session()->setFlashdata('successMessage', 'Saldo berhasil ditambahkan');
        return redirect()->to(base_url('renter'));
    }

    public function payment($id)
    {
        $data = [
            'title' => 'Pembayaran',
            'account' => $this->renterAccountModel->getAccount(session()->get('email')),
            'rental' => $this->rentalModel->getRentalDataById($id)
        ];

        return view('renter/payment', $data);
    }

    public function pay($id)
    {
        $renter = $this->renterAccountModel->getAccountById($this->request->getVar('renter-id'));
        $rental = $this->rentalModel->getRentalDataById($id);

        if ($renter['balance'] < $rental['total_rental_price']) {
            session()->setFlashdata('errorMessage', 'Saldo Anda tidak cukup!');
            return redirect()->to(base_url('renter/payment/' . $id))->withInput();
        }

        $balance = $renter['balance'] - $rental['total_rental_price'];

        $this->rentalModel->save([
            'id' => $id,
            'status' => 2
        ]);

        $this->renterAccountModel->save([
            'id' => $this->request->getVar('renter-id'),
            'balance' => $balance
        ]);

        session()->setFlashdata('successMessage', 'Pembayaran berhasil');
        return redirect()->to(base_url('renter/rental-data'));
    }
}
