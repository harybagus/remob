<?php

namespace App\Controllers;

use App\Models\AdminAccountModel;

class AdminAccount extends BaseController
{
    protected $adminAccountModel;

    public function __construct()
    {
        $this->adminAccountModel = new AdminAccountModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Tambah Data Admin',
            'account' => $this->adminAccountModel->getAccount(session()->get('email'))
        ];

        return view('admin/adminAccount/create', $data);
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
                'rules' => 'required|valid_email|is_unique[admin.email]',
                'errors' => [
                    'required' => 'Alamat email harus diisi.',
                    'valid_email' => 'Alamat email tidak valid.',
                    'is_unique' => 'Alamat email sudah terdaftar.'
                ]
            ],
            'image' => [
                'rules' => 'max_size[image,1024]|is_image[image]|mime_in[image,image/jpg,image,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar.',
                    'is_image' => 'Yang Anda pilih bukan gambar.',
                    'mime_in' => 'Yang Anda pilih bukan gambar.'
                ]
            ]
        ])) {
            return redirect()->to(base_url('admin/account/create'))->withInput();
        }

        $image = $this->request->getFile('image');
        if ($image->getError() == 4) {
            $imageName = 'default.jpg';
        } else {
            $imageName = $image->getRandomName();
            $image->move('assets/img/profile', $imageName);
        }

        $this->adminAccountModel->save([
            'name' => $this->request->getVar('name'),
            'email' => $this->request->getVar('email'),
            'image' => $imageName,
            'password' => password_hash(123123123, PASSWORD_DEFAULT)
        ]);

        session()->setFlashdata('successMessage', 'Data berhasil ditambahkan');
        return redirect()->to(base_url('admin/account'));
    }

    public function update($id)
    {
        $data = [
            'title' => 'Ubah Data Admin',
            'account' => $this->adminAccountModel->getAccount(session()->get('email')),
            'updatedAccount' => $this->adminAccountModel->getAccountById($id)
        ];

        return view('admin/adminAccount/update', $data);
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
            return redirect()->to(base_url('admin/account/update/' . $id))->withInput();
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

        $this->adminAccountModel->save([
            'id' => $id,
            'name' => $this->request->getVar('name'),
            'image' => $imageName
        ]);

        session()->setFlashdata('successMessage', 'Data berhasil diubah');
        return redirect()->to(base_url('admin/account'));
    }

    public function delete($id)
    {
        $account = $this->adminAccountModel->getAccountById($id);

        if ($account['image'] != 'default.jpg') {
            unlink('assets/img/profile/' . $account['image']);
        }

        $this->adminAccountModel->delete($id);

        session()->setFlashdata('successMessage', 'Data berhasil dihapus');
        return redirect()->to(base_url('admin/account'));
    }
}
