<?php

namespace App\Controllers;

use App\Models\AuthModel;

class RenterAccount extends BaseController
{
    protected $authModel;

    public function __construct()
    {
        $this->authModel = new AuthModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Tambah Data Penyewa',
            'account' => $this->authModel->getAccount(session()->get('email'))
        ];

        return view('admin/renterAccount/create', $data);
    }

    public function add()
    {
        if (!$this->validate([
            'name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama lengkap harus diisi.'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[user.email]',
                'errors' => [
                    'required' => 'Alamat email harus diisi.',
                    'valid_email' => 'Alamat email tidak valid.',
                    'is_unique' => 'Alamat email sudah terdaftar.'
                ]
            ],
            'image' => [
                'rules' => 'max_size[image,1024]|is_image[image]|mime_in[image,image/jpg,image,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar',
                    'is_image' => 'Yang Anda pilih bukan gambar',
                    'mime_in' => 'Ekstensi file tidak diizinkan'
                ]
            ]
        ])) {
            return redirect()->to(base_url('admin/renter/create'))->withInput();
        }

        $image = $this->request->getFile('image');
        if ($image->getError() == 4) {
            $imageName = 'default.jpg';
        } else {
            $imageName = $image->getRandomName();
            $image->move('assets/img/profile', $imageName);
        }

        $this->authModel->save([
            'name' => $this->request->getVar('name'),
            'email' => $this->request->getVar('email'),
            'image' => $imageName,
            'password' => password_hash(321321321, PASSWORD_DEFAULT),
            'role_id' => 2,
            'date_created' => time()
        ]);

        session()->setFlashdata('successMessage', 'Data berhasil ditambahkan');
        return redirect()->to(base_url('admin/renter'));
    }
}
