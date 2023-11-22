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
            'account' => $this->authModel->getAccount(session()->get('email')),
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
}
