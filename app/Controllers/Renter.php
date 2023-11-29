<?php

namespace App\Controllers;

use App\Models\RenterAccountModel;
use App\Models\CarModel;

class Renter extends BaseController
{
    protected $renterAccountModel;
    protected $carModel;

    public function __construct()
    {
        $this->renterAccountModel = new RenterAccountModel();
        $this->carModel = new CarModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Profil Saya',
            'account' => $this->renterAccountModel->getAccount(session()->get('email'))
        ];

        return view('renter/myProfile', $data);
    }

    public function updateAccount($id)
    {
        if (!$this->validate([
            'name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama lengkap harus diisi.'
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
            'image' => $imageName
        ]);

        session()->setFlashdata('successMessage', 'Data berhasil diubah');
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
            return redirect()->to(base_url('renter'));
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
}
