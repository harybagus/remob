<?php

namespace App\Controllers;

use App\Models\AuthModel;

class Admin extends BaseController
{
    protected $authModel;

    public function __construct()
    {
        $this->authModel = new AuthModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'account' => $this->authModel->getAccount(session()->get('email'))
        ];

        return view('admin/index', $data);
    }

    public function account()
    {
        $data = [
            'title' => 'Kelola Akun',
            'account' => $this->authModel->getAccount(session()->get('email')),
            'adminAccount' => $this->authModel->getAdminAccount(session()->get('email'))
        ];

        return view('admin/account', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Data Admin',
            'account' => $this->authModel->getAccount(session()->get('email'))
        ];

        return view('admin/create', $data);
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
            ]
        ])) {
            return redirect()->to(base_url('admin/create'))->withInput();
        }

        $this->authModel->save([
            'name' => $this->request->getVar('name'),
            'email' => $this->request->getVar('email'),
            'image' => 'default.jpg',
            'password' => password_hash(123123123, PASSWORD_DEFAULT),
            'role_id' => 1,
            'date_created' => time()
        ]);

        session()->setFlashdata('successMessage', 'Selamat, Anda berhasil membuat akun admin!');
        return redirect()->to(base_url('admin/account'));
    }

    public function update($id)
    {
        $data = [
            'title' => 'Ubah Data Admin',
            'account' => $this->authModel->getAccount(session()->get('email')),
            'updatedAccount' => $this->authModel->getAccountById($id)
        ];

        return view('admin/update', $data);
    }

    public function edit($id)
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
            return redirect()->to(base_url('admin/update/' . $id))->withInput();
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

        $this->authModel->save([
            'id' => $id,
            'name' => $this->request->getVar('name'),
            'image' => $imageName
        ]);

        session()->setFlashdata('successMessage', 'Data berhasil diubah');
        return redirect()->to(base_url('admin/account'));
    }
}
